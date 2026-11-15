<?php

namespace Database\Seeders;

use App\Models\CommitteeMember;
use App\Models\Complaint;
use App\Models\ComplaintCategory;
use App\Models\ComplaintComment;
use App\Models\Newsletter;
use App\Models\NewsletterRecipient;
use App\Models\OwnerProperty;
use App\Models\Property;
use App\Models\Society;
use App\Models\SocietyMember;
use App\Models\Tenant;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // 1. Roles
        $roleSuperAdmin = Role::firstOrCreate(['name' => 'super_admin']);
        $roleCommittee = Role::firstOrCreate(['name' => 'committee_member']);
        $roleOwner = Role::firstOrCreate(['name' => 'house_owner']);
        $roleTenant = Role::firstOrCreate(['name' => 'tenant']);

        // 2. Global Default Complaint Categories
        $defaultCategories = [
            'Maintenance',
            'Water',
            'Electricity',
            'Security',
            'Cleaning',
            'Parking',
            'Other',
        ];
        foreach ($defaultCategories as $cat) {
            ComplaintCategory::firstOrCreate(['name' => $cat, 'society_id' => null]);
        }

        // 3. Super Admin User
        $superAdmin = User::firstOrCreate(
            ['email' => 'admin@societysetu.com'],
            [
                'name' => 'Super Administrator',
                'user_name' => '9999999999#SUPERADMIN',
                'mobile' => '9999999999',
                'password' => Hash::make('password'),
                'pin' => Hash::make('1234'),
                'is_super_admin' => true,
            ]
        );
        $superAdmin->assignRole($roleSuperAdmin);

        // 4. Sample Society 1: Kohinoor Heights
        $society1 = Society::firstOrCreate(
            ['society_code' => 'KOHINOOR01'],
            [
                'name' => 'Kohinoor Heights Co-Op Housing Society',
                'address' => 'Plot 42, Palm Beach Road, Sector 18',
                'city' => 'Navi Mumbai',
                'state' => 'Maharashtra',
                'pincode' => '400705',
                'contact_person' => 'Rajesh Sharma',
                'contact_phone' => '9820011223',
                'contact_email' => 'committee@kohinoor.com',
                'status' => 'active',
            ]
        );

        // Sample Society 2: Green Acres
        $society2 = Society::firstOrCreate(
            ['society_code' => 'GREEN02'],
            [
                'name' => 'Green Acres Residency',
                'address' => 'Survey 88, Baner-Pashan Link Road',
                'city' => 'Pune',
                'state' => 'Maharashtra',
                'pincode' => '411045',
                'contact_person' => 'Sunil Verma',
                'contact_phone' => '9822233445',
                'contact_email' => 'contact@greenacres.org',
                'status' => 'active',
            ]
        );

        // 5. Properties for Society 1
        $flatA101 = Property::firstOrCreate(
            ['society_id' => $society1->id, 'wing_or_block' => 'Wing A', 'house_number' => '101'],
            ['property_type' => 'Flat', 'occupancy_status' => 'rented']
        );

        $flatA102 = Property::firstOrCreate(
            ['society_id' => $society1->id, 'wing_or_block' => 'Wing A', 'house_number' => '102'],
            ['property_type' => 'Flat', 'occupancy_status' => 'owner_occupied']
        );

        $flatB301 = Property::firstOrCreate(
            ['society_id' => $society1->id, 'wing_or_block' => 'Wing B', 'house_number' => '301'],
            ['property_type' => 'Flat', 'occupancy_status' => 'owner_occupied']
        );

        $flatB302 = Property::firstOrCreate(
            ['society_id' => $society1->id, 'wing_or_block' => 'Wing B', 'house_number' => '302'],
            ['property_type' => 'Flat', 'occupancy_status' => 'vacant']
        );

        // 6. Society Users
        // User A: Rajesh Sharma (Committee President + also Owner of A-102)
        $userRajesh = User::firstOrCreate(
            ['mobile' => '9820011223'],
            [
                'name' => 'Rajesh Sharma',
                'user_name' => '9820011223#KOHINOOR01',
                'email' => 'rajesh.sharma@example.com',
                'password' => Hash::make('password'),
                'pin' => Hash::make('1234'),
                'is_super_admin' => false,
            ]
        );
        $userRajesh->user_name = '9820011223#KOHINOOR01';
        $userRajesh->save();
        $userRajesh->assignRole([$roleCommittee, $roleOwner]);

        // Memberships for Rajesh (holds committee_member AND house_owner)
        SocietyMember::firstOrCreate([
            'society_id' => $society1->id,
            'user_id' => $userRajesh->id,
            'role_type' => 'committee_member',
        ], ['status' => 'active']);

        SocietyMember::firstOrCreate([
            'society_id' => $society1->id,
            'user_id' => $userRajesh->id,
            'role_type' => 'house_owner',
        ], ['status' => 'active']);

        CommitteeMember::firstOrCreate([
            'society_id' => $society1->id,
            'user_id' => $userRajesh->id,
        ], [
            'designation' => 'President',
            'term_start' => now()->startOfYear(),
            'term_end' => now()->addYears(2),
        ]);

        OwnerProperty::firstOrCreate([
            'society_id' => $society1->id,
            'property_id' => $flatA102->id,
            'user_id' => $userRajesh->id,
        ], [
            'ownership_start_date' => now()->subYears(3),
            'is_primary' => true,
        ]);

        // User B: Amit Deshmukh (House Owner of A-101 and B-302)
        $userAmit = User::firstOrCreate(
            ['mobile' => '9820077889'],
            [
                'name' => 'Amit Deshmukh',
                'user_name' => '9820077889#KOHINOOR01',
                'email' => 'amit.deshmukh@example.com',
                'password' => Hash::make('password'),
                'pin' => Hash::make('1234'),
                'is_super_admin' => false,
            ]
        );
        $userAmit->user_name = '9820077889#KOHINOOR01';
        $userAmit->save();
        $userAmit->assignRole($roleOwner);

        SocietyMember::firstOrCreate([
            'society_id' => $society1->id,
            'user_id' => $userAmit->id,
            'role_type' => 'house_owner',
        ], ['status' => 'active']);

        OwnerProperty::firstOrCreate([
            'society_id' => $society1->id,
            'property_id' => $flatA101->id,
            'user_id' => $userAmit->id,
        ], [
            'ownership_start_date' => now()->subYears(2),
            'is_primary' => true,
        ]);

        OwnerProperty::firstOrCreate([
            'society_id' => $society1->id,
            'property_id' => $flatB302->id,
            'user_id' => $userAmit->id,
        ], [
            'ownership_start_date' => now()->subYear(),
            'is_primary' => false,
        ]);

        // User C: Vikram Malhotra (Tenant in Flat A-101)
        $userVikram = User::firstOrCreate(
            ['mobile' => '9820099001'],
            [
                'name' => 'Vikram Malhotra',
                'user_name' => '9820099001#KOHINOOR01',
                'email' => 'vikram.m@example.com',
                'password' => Hash::make('password'),
                'pin' => Hash::make('1234'),
                'is_super_admin' => false,
            ]
        );
        $userVikram->user_name = '9820099001#KOHINOOR01';
        $userVikram->save();
        $userVikram->assignRole($roleTenant);

        SocietyMember::firstOrCreate([
            'society_id' => $society1->id,
            'user_id' => $userVikram->id,
            'role_type' => 'tenant',
        ], ['status' => 'active']);

        Tenant::firstOrCreate([
            'society_id' => $society1->id,
            'property_id' => $flatA101->id,
            'owner_id' => $userAmit->id,
            'tenant_user_id' => $userVikram->id,
        ], [
            'lease_start_date' => now()->subMonths(6),
            'lease_end_date' => now()->addMonths(6),
            'status' => 'active',
        ]);

        // 7. Newsletters
        $newsletterBoth = Newsletter::firstOrCreate(
            ['society_id' => $society1->id, 'title' => 'Annual General Meeting & Cultural Evening'],
            [
                'created_by' => $userRajesh->id,
                'content' => 'Dear Residents, our Annual General Meeting is scheduled for next Sunday at 6:30 PM in the Clubhouse. All residents (owners & tenants) are cordially invited for the cultural program and dinner following the meeting.',
                'target_audience' => 'both',
                'status' => 'published',
                'published_at' => now()->subDays(2),
            ]
        );

        $newsletterOwners = Newsletter::firstOrCreate(
            ['society_id' => $society1->id, 'title' => 'Building Sinking Fund & Lift Modernization Resolution'],
            [
                'created_by' => $userRajesh->id,
                'content' => 'Dear Property Owners, please review the proposed resolution for elevator modernization. As decided by the managing committee, a one-time sinking fund contribution of ₹12,000 per flat is requested by month end.',
                'target_audience' => 'owners_only',
                'status' => 'published',
                'published_at' => now()->subDay(),
            ]
        );

        $newsletterTenants = Newsletter::firstOrCreate(
            ['society_id' => $society1->id, 'title' => 'Tenant Police Verification & Move-in Guidelines'],
            [
                'created_by' => $userRajesh->id,
                'content' => 'Dear Tenants, this is a friendly reminder to ensure your local police verification copy is submitted at the society office if not already completed. Please also coordinate moving trucks during designated 10 AM - 5 PM hours.',
                'target_audience' => 'tenants_only',
                'status' => 'published',
                'published_at' => now()->subHours(12),
            ]
        );

        foreach ([$newsletterBoth, $newsletterOwners, $newsletterTenants] as $nl) {
            $eligibleUsers = collect();
            if ($nl->target_audience === 'both') {
                $eligibleUsers = SocietyMember::where('society_id', $nl->society_id)->pluck('user_id')->unique();
            } elseif ($nl->target_audience === 'owners_only') {
                $eligibleUsers = SocietyMember::where('society_id', $nl->society_id)->where('role_type', 'house_owner')->pluck('user_id')->unique();
            } elseif ($nl->target_audience === 'tenants_only') {
                $eligibleUsers = SocietyMember::where('society_id', $nl->society_id)->where('role_type', 'tenant')->pluck('user_id')->unique();
            }

            foreach ($eligibleUsers as $uid) {
                NewsletterRecipient::firstOrCreate([
                    'newsletter_id' => $nl->id,
                    'user_id' => $uid,
                ], [
                    'read_at' => null,
                ]);
            }
        }

        // 8. Complaints
        $waterCategory = ComplaintCategory::where('name', 'Water')->first();
        $maintenanceCategory = ComplaintCategory::where('name', 'Maintenance')->first();

        $comp1 = Complaint::firstOrCreate(
            ['society_id' => $society1->id, 'title' => 'Low water pressure in kitchen faucet'],
            [
                'property_id' => $flatA101->id,
                'submitted_by' => $userVikram->id,
                'submitter_role' => 'tenant',
                'category_id' => $waterCategory->id,
                'description' => 'Water pressure has been extremely low since yesterday morning in the kitchen utility line.',
                'priority' => 'medium',
                'status' => 'In Progress',
            ]
        );

        ComplaintComment::firstOrCreate([
            'complaint_id' => $comp1->id,
            'user_id' => $userRajesh->id,
            'remark' => 'Plumber has been assigned. Will inspect the overhead pressure valve today at 4 PM.',
            'status_changed_to' => 'In Progress',
        ]);

        $comp2 = Complaint::firstOrCreate(
            ['society_id' => $society1->id, 'title' => 'Corridor sensor light flickering on 3rd floor'],
            [
                'property_id' => $flatB302->id,
                'submitted_by' => $userAmit->id,
                'submitter_role' => 'house_owner',
                'category_id' => $maintenanceCategory->id,
                'description' => 'The corridor motion sensor light outside flat 302 keeps blinking rapidly and needs bulb replacement.',
                'priority' => 'low',
                'status' => 'Pending',
            ]
        );
    }
}
