<?php

namespace Tests\Feature;

use App\Models\Complaint;
use App\Models\ComplaintCategory;
use App\Models\Newsletter;
use App\Models\Property;
use App\Models\Society;
use App\Models\SocietyMember;
use App\Models\Tenant;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class SocietySetuTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();
        // Clear session between tests
        session()->flush();
    }

    public function test_super_admin_can_login_and_access_dashboard(): void
    {
        $response = $this->post(route('admin.login.submit'), [
            'email' => 'admin@societysetu.com',
            'password' => 'password',
        ]);

        $response->assertRedirect(route('admin.dashboard'));
        $this->assertAuthenticated();
        $this->assertTrue(auth()->user()->is_super_admin);

        $dashResponse = $this->get(route('admin.dashboard'));
        $dashResponse->assertStatus(200);
        $dashResponse->assertSee('Super Admin Overview');
    }

    public function test_super_admin_can_create_society_with_unique_code(): void
    {
        $admin = User::where('is_super_admin', true)->first();
        $this->actingAs($admin);

        $code = 'TESTSOC' . rand(100, 999);
        $response = $this->post(route('admin.societies.store'), [
            'name' => 'Test Heights Co-op',
            'society_code' => $code,
            'address' => 'Test Street 1',
            'city' => 'Mumbai',
            'state' => 'Maharashtra',
            'pincode' => '400001',
            'contact_person' => 'Test Manager',
            'contact_phone' => '9800000000',
            'contact_email' => 'test@heights.com',
            'status' => 'active',
        ]);

        $this->assertDatabaseHas('societies', [
            'society_code' => $code,
            'name' => 'Test Heights Co-op',
        ]);
    }

    public function test_mobile_login_validates_society_code_mobile_and_pin(): void
    {
        // 1. Wrong Society Code
        $res = $this->post(route('app.login.submit'), [
            'society_code' => 'INVALID999',
            'mobile' => '9820011223',
            'pin' => '1234',
        ]);
        $res->assertSessionHasErrors(['society_code']);

        // 2. Correct Society Code, Mobile, and PIN
        $res = $this->post(route('app.login.submit'), [
            'society_code' => 'KOHINOOR01',
            'mobile' => '9820011223',
            'pin' => '1234',
        ]);

        $res->assertRedirect(route('committee.dashboard'));
        $this->assertEquals('KOHINOOR01', session('current_society_code'));
        $this->assertEquals('committee_member', session('active_role'));
    }

    public function test_mobile_multi_role_support_and_role_switcher(): void
    {
        // Rajesh Sharma holds both committee_member AND house_owner
        $res = $this->post(route('app.login.submit'), [
            'society_code' => 'KOHINOOR01',
            'mobile' => '9820011223',
            'pin' => '1234',
        ]);

        $this->assertContains('committee_member', session('available_roles'));
        $this->assertContains('house_owner', session('available_roles'));

        // Switch to house_owner view
        $switchRes = $this->get(route('app.switch_role', 'house_owner'));
        $switchRes->assertRedirect(route('owner.dashboard'));
        $this->assertEquals('house_owner', session('active_role'));

        // Access owner dashboard
        $ownerDash = $this->get(route('owner.dashboard'));
        $ownerDash->assertStatus(200);
        $ownerDash->assertSee('House Owner Portal');
    }

    public function test_multi_tenant_isolation_prevents_cross_society_leaks(): void
    {
        $soc1 = Society::where('society_code', 'KOHINOOR01')->first();
        $soc2 = Society::where('society_code', 'GREEN02')->first();

        // Create a property in Green Acres
        $propSoc2 = Property::withoutGlobalScopes()->create([
            'society_id' => $soc2->id,
            'wing_or_block' => 'Block Z',
            'house_number' => '999',
            'property_type' => 'Villa',
            'occupancy_status' => 'vacant',
        ]);

        // When a user is in Kohinoor session
        session(['current_society_id' => $soc1->id]);

        $propertiesInSession = Property::all();

        // Must NOT contain property from Green Acres!
        $this->assertFalse($propertiesInSession->contains('id', $propSoc2->id));

        // When switching session to Green Acres
        session(['current_society_id' => $soc2->id]);
        $greenProps = Property::all();
        $this->assertTrue($greenProps->contains('id', $propSoc2->id));
    }

    public function test_strict_newsletter_audience_targeting(): void
    {
        $soc = Society::where('society_code', 'KOHINOOR01')->first();
        $ownerUser = User::where('mobile', '9820077889')->first(); // Amit Deshmukh
        $tenantUser = User::where('mobile', '9820099001')->first(); // Vikram Malhotra

        // Login as Owner
        $this->post(route('app.login.submit'), [
            'society_code' => 'KOHINOOR01',
            'mobile' => '9820077889',
            'pin' => '1234',
        ]);

        $ownerNoticeRes = $this->get(route('owner.newsletters.index'));
        $ownerNoticeRes->assertStatus(200);
        $ownerNoticeRes->assertSee('Building Sinking Fund & Lift Modernization');
        $ownerNoticeRes->assertDontSee('Tenant Police Verification & Move-in Guidelines');

        // Logout
        $this->post(route('app.logout'));

        // Login as Tenant
        $this->post(route('app.login.submit'), [
            'society_code' => 'KOHINOOR01',
            'mobile' => '9820099001',
            'pin' => '1234',
        ]);

        $tenantNoticeRes = $this->get(route('tenant.newsletters.index'));
        $tenantNoticeRes->assertStatus(200);
        $tenantNoticeRes->assertSee('Tenant Police Verification & Move-in Guidelines');
        $tenantNoticeRes->assertDontSee('Building Sinking Fund & Lift Modernization');
    }

    public function test_complaint_lifecycle_and_committee_remarks(): void
    {
        $soc = Society::where('society_code', 'KOHINOOR01')->first();
        $category = ComplaintCategory::first();

        // 1. Tenant submits complaint
        $this->post(route('app.login.submit'), [
            'society_code' => 'KOHINOOR01',
            'mobile' => '9820099001',
            'pin' => '1234',
        ]);

        $compResponse = $this->post(route('tenant.complaints.store'), [
            'property_id' => Property::first()->id,
            'category_id' => $category->id,
            'title' => 'Corridor bulb not working',
            'description' => '3rd floor corridor is completely dark',
            'priority' => 'low',
        ]);

        $compResponse->assertRedirect();
        $complaint = Complaint::where('title', 'Corridor bulb not working')->first();
        $this->assertNotNull($complaint);
        $this->assertEquals('Pending', $complaint->status);

        // 2. Committee logs in and posts remark
        $this->post(route('app.logout'));
        $this->post(route('app.login.submit'), [
            'society_code' => 'KOHINOOR01',
            'mobile' => '9820011223',
            'pin' => '1234',
        ]);

        $remarkRes = $this->post(route('committee.complaints.update_status', $complaint), [
            'status' => 'In Progress',
            'remark' => 'Electrician will replace bulb today at 5 PM',
        ]);

        $complaint->refresh();
        $this->assertEquals('In Progress', $complaint->status);
        $this->assertDatabaseHas('complaint_comments', [
            'complaint_id' => $complaint->id,
            'remark' => 'Electrician will replace bulb today at 5 PM',
            'status_changed_to' => 'In Progress',
        ]);
    }

    public function test_rest_api_sanctum_login_and_scoped_endpoints(): void
    {
        // 1. API Login
        $response = $this->postJson('/api/v1/auth/login', [
            'society_code' => 'KOHINOOR01',
            'mobile' => '9820011223',
            'pin' => '1234',
        ]);

        $response->assertStatus(200);
        $response->assertJsonStructure([
            'success',
            'data' => [
                'token',
                'user',
                'society',
                'available_roles',
            ],
        ]);

        $token = $response->json('data.token');

        // 2. Access scoped newsletters endpoint with Bearer token
        $apiNewsletters = $this->withHeader('Authorization', 'Bearer ' . $token)
            ->withHeader('X-User-Role', 'committee_member')
            ->getJson('/api/v1/newsletters');

        $apiNewsletters->assertStatus(200);
        $apiNewsletters->assertJsonStructure(['success', 'data']);
    }
}
