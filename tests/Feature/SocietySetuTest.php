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
        session()->flush();
    }

    public function test_customer_landing_page_does_not_show_project_details_or_login_buttons(): void
    {
        $response = $this->get('/');
        $response->assertStatus(200);
        $response->assertSee('SocietySetu');
        $response->assertSee('What We Provide');
        $response->assertSee('Next-Generation Society Living');

        // Verify NO project/developer details are displayed on customer landing page
        $response->assertDontSee('API & Engine Active');
        $response->assertDontSee('mobileno#societycode');
        $response->assertDontSee('Single-Codebase Technology Stack');
        $response->assertDontSee('Live REST API Endpoints');
        $response->assertDontSee('Phase 1 Prototype');

        // Verify NO login buttons are displayed
        $response->assertDontSee('Sign In as Super Admin');
        $response->assertDontSee('Enter Society Portal');
        $response->assertDontSee('Mobile App View');
        $response->assertDontSee('Super Admin Portal');
        $response->assertDontSee('Launch Mobile App Portal');
        $response->assertDontSee('Open Super Admin Login');
    }

    public function test_ssa_slug_and_docs_page(): void
    {
        // 1. SSA Login page loads
        $loginRes = $this->get('/ssa/login');
        $loginRes->assertStatus(200);
        $loginRes->assertSee('SSA Portal Access');

        // 2. Legacy /admin redirects to /ssa/login
        $adminRedirect = $this->get('/admin/login');
        $adminRedirect->assertRedirect('/ssa/login');

        // 3. SSA Docs page is accessible and displays technical specifications
        $docsRes = $this->get('/ssa/docs');
        $docsRes->assertStatus(200);
        $docsRes->assertSee('SocietySetu Technical Documentation');
        $docsRes->assertSee('mobileno#societycode');
        $docsRes->assertSee('Live REST API v1 Documentation');
        $docsRes->assertSee('Single-Codebase Technology Architecture');

        // 4. Verify noindex robots meta tag protects ssa and docs from search engines
        $docsRes->assertSee('noindex, nofollow, noarchive, nosnippet');
    }

    public function test_users_have_user_name_in_mobile_hash_society_format(): void
    {
        $userRajesh = User::where('mobile', '9820011223')->first();
        $this->assertNotNull($userRajesh);
        $this->assertEquals('9820011223#KOHINOOR01', $userRajesh->user_name);

        $userAmit = User::where('mobile', '9820077889')->first();
        $this->assertNotNull($userAmit);
        $this->assertEquals('9820077889#KOHINOOR01', $userAmit->user_name);

        $userVikram = User::where('mobile', '9820099001')->first();
        $this->assertNotNull($userVikram);
        $this->assertEquals('9820099001#KOHINOOR01', $userVikram->user_name);
    }

    public function test_super_admin_can_login_via_ssa_and_access_dashboard(): void
    {
        $response = $this->post('/ssa/login', [
            'email' => 'admin@societysetu.com',
            'password' => 'password',
        ]);

        $response->assertRedirect(route('admin.dashboard'));
        $this->assertAuthenticated();
        $this->assertTrue(auth()->user()->is_super_admin);

        $dashResponse = $this->get('/ssa/dashboard');
        $dashResponse->assertStatus(200);
        $dashResponse->assertSee('Super Admin Overview');
    }

    public function test_committee_login_with_society_code_mobile_and_password(): void
    {
        $res = $this->post(route('app.login.submit'), [
            'society_code' => 'KOHINOOR01',
            'mobile' => '9820011223',
            'password' => 'password',
        ]);

        $res->assertRedirect(route('committee.dashboard'));
        $this->assertEquals('KOHINOOR01', session('current_society_code'));
        $this->assertEquals('committee_member', session('active_role'));
    }

    public function test_house_owner_login_with_society_code_mobile_and_password(): void
    {
        $res = $this->post(route('app.login.submit'), [
            'society_code' => 'KOHINOOR01',
            'mobile' => '9820077889',
            'password' => 'password',
        ]);

        $res->assertRedirect(route('owner.dashboard'));
        $this->assertEquals('KOHINOOR01', session('current_society_code'));
        $this->assertEquals('house_owner', session('active_role'));
    }

    public function test_tenant_login_with_society_code_mobile_and_password(): void
    {
        $res = $this->post(route('app.login.submit'), [
            'society_code' => 'KOHINOOR01',
            'mobile' => '9820099001',
            'password' => 'password',
        ]);

        $res->assertRedirect(route('tenant.dashboard'));
        $this->assertEquals('KOHINOOR01', session('current_society_code'));
        $this->assertEquals('tenant', session('active_role'));
    }

    public function test_mobile_multi_role_support_and_role_switcher(): void
    {
        $res = $this->post(route('app.login.submit'), [
            'society_code' => 'KOHINOOR01',
            'mobile' => '9820011223',
            'password' => 'password',
        ]);

        $this->assertContains('committee_member', session('available_roles'));
        $this->assertContains('house_owner', session('available_roles'));

        $switchRes = $this->get(route('app.switch_role', 'house_owner'));
        $switchRes->assertRedirect(route('owner.dashboard'));
        $this->assertEquals('house_owner', session('active_role'));

        $ownerDash = $this->get(route('owner.dashboard'));
        $ownerDash->assertStatus(200);
        $ownerDash->assertSee('House Owner Portal');
    }

    public function test_strict_newsletter_audience_targeting(): void
    {
        // Login as Owner
        $this->post(route('app.login.submit'), [
            'society_code' => 'KOHINOOR01',
            'mobile' => '9820077889',
            'password' => 'password',
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
            'password' => 'password',
        ]);

        $tenantNoticeRes = $this->get(route('tenant.newsletters.index'));
        $tenantNoticeRes->assertStatus(200);
        $tenantNoticeRes->assertSee('Tenant Police Verification & Move-in Guidelines');
        $tenantNoticeRes->assertDontSee('Building Sinking Fund & Lift Modernization');
    }

    public function test_complaint_lifecycle_and_committee_remarks(): void
    {
        $category = ComplaintCategory::first();

        // 1. Tenant submits complaint
        $this->post(route('app.login.submit'), [
            'society_code' => 'KOHINOOR01',
            'mobile' => '9820099001',
            'password' => 'password',
        ]);

        $compResponse = $this->post(route('tenant.complaints.store'), [
            'property_id' => Property::first()->id,
            'category_id' => $category->id,
            'title' => 'Main gate intercom issue',
            'description' => 'Static sound when buzzer rings',
            'priority' => 'low',
        ]);

        $compResponse->assertRedirect();
        $complaint = Complaint::where('title', 'Main gate intercom issue')->first();
        $this->assertNotNull($complaint);
        $this->assertEquals('Pending', $complaint->status);

        // 2. Committee logs in and posts remark
        $this->post(route('app.logout'));
        $this->post(route('app.login.submit'), [
            'society_code' => 'KOHINOOR01',
            'mobile' => '9820011223',
            'password' => 'password',
        ]);

        $remarkRes = $this->post(route('committee.complaints.update_status', $complaint), [
            'status' => 'In Progress',
            'remark' => 'Technician scheduled for inspection tomorrow',
        ]);

        $complaint->refresh();
        $this->assertEquals('In Progress', $complaint->status);
        $this->assertDatabaseHas('complaint_comments', [
            'complaint_id' => $complaint->id,
            'remark' => 'Technician scheduled for inspection tomorrow',
            'status_changed_to' => 'In Progress',
        ]);
    }

    public function test_rest_api_sanctum_login_with_society_code_mobile_and_password(): void
    {
        $response = $this->postJson('/api/v1/auth/login', [
            'society_code' => 'KOHINOOR01',
            'mobile' => '9820011223',
            'password' => 'password',
        ]);

        $response->assertStatus(200);
        $response->assertJsonStructure([
            'success',
            'data' => [
                'token',
                'user' => [
                    'id',
                    'name',
                    'user_name',
                    'mobile',
                ],
                'society',
                'available_roles',
            ],
        ]);

        $this->assertEquals('9820011223#KOHINOOR01', $response->json('data.user.user_name'));

        $token = $response->json('data.token');

        $apiNewsletters = $this->withHeader('Authorization', 'Bearer ' . $token)
            ->withHeader('X-User-Role', 'committee_member')
            ->getJson('/api/v1/newsletters');

        $apiNewsletters->assertStatus(200);
        $apiNewsletters->assertJsonStructure(['success', 'data']);
    }
}
