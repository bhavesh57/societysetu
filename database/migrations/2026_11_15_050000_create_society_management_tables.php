<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // 1. Societies
        Schema::create('societies', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('society_code', 30)->unique(); // uppercase alphanumeric e.g. KOHINOOR01
            $table->text('address')->nullable();
            $table->string('city', 100)->nullable();
            $table->string('state', 100)->nullable();
            $table->string('pincode', 20)->nullable();
            $table->string('contact_person')->nullable();
            $table->string('contact_phone', 25)->nullable();
            $table->string('contact_email')->nullable();
            $table->string('status', 20)->default('active'); // active, inactive
            $table->timestamps();
        });

        // 4. Society Members (Pivot / Multi-Society Membership)
        Schema::create('society_members', function (Blueprint $table) {
            $table->id();
            $table->foreignId('society_id')->constrained('societies')->cascadeOnDelete();
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();
            $table->string('role_type', 40); // committee_member, house_owner, tenant
            $table->string('status', 20)->default('active'); // active, inactive
            $table->timestamps();

            $table->unique(['society_id', 'user_id', 'role_type'], 'sm_soc_user_role_unique');
        });

        // 5. Properties (Houses/Flats)
        Schema::create('properties', function (Blueprint $table) {
            $table->id();
            $table->foreignId('society_id')->constrained('societies')->cascadeOnDelete();
            $table->string('wing_or_block', 50); // e.g., Block A, Wing B
            $table->string('house_number', 50); // e.g., 101, A-402
            $table->string('property_type', 40)->default('Flat'); // Flat, Villa, Tenament, Shop
            $table->string('occupancy_status', 40)->default('vacant'); // vacant, owner_occupied, rented
            $table->timestamps();

            $table->unique(['society_id', 'wing_or_block', 'house_number'], 'prop_soc_wing_house_unique');
        });

        // 6. Owner Property (Ownership Link)
        Schema::create('owner_property', function (Blueprint $table) {
            $table->id();
            $table->foreignId('society_id')->constrained('societies')->cascadeOnDelete();
            $table->foreignId('property_id')->constrained('properties')->cascadeOnDelete();
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();
            $table->date('ownership_start_date')->nullable();
            $table->boolean('is_primary')->default(true);
            $table->timestamps();
        });

        // 7. Tenants (Rental Users)
        Schema::create('tenants', function (Blueprint $table) {
            $table->id();
            $table->foreignId('society_id')->constrained('societies')->cascadeOnDelete();
            $table->foreignId('property_id')->constrained('properties')->cascadeOnDelete();
            $table->foreignId('owner_id')->constrained('users')->cascadeOnDelete();
            $table->foreignId('tenant_user_id')->constrained('users')->cascadeOnDelete();
            $table->date('lease_start_date');
            $table->date('lease_end_date')->nullable();
            $table->string('status', 30)->default('active'); // active, moved_out
            $table->timestamps();
        });

        // 8. Committee Members
        Schema::create('committee_members', function (Blueprint $table) {
            $table->id();
            $table->foreignId('society_id')->constrained('societies')->cascadeOnDelete();
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();
            $table->string('designation', 50)->default('Member'); // President, Secretary, Treasurer, Member
            $table->date('term_start')->nullable();
            $table->date('term_end')->nullable();
            $table->timestamps();
        });

        // 11. Complaint Categories
        Schema::create('complaint_categories', function (Blueprint $table) {
            $table->id();
            $table->foreignId('society_id')->nullable()->constrained('societies')->nullOnDelete();
            $table->string('name', 100);
            $table->timestamps();
        });

        // 12. Complaints
        Schema::create('complaints', function (Blueprint $table) {
            $table->id();
            $table->foreignId('society_id')->constrained('societies')->cascadeOnDelete();
            $table->foreignId('property_id')->nullable()->constrained('properties')->nullOnDelete();
            $table->foreignId('submitted_by')->constrained('users')->cascadeOnDelete();
            $table->string('submitter_role', 40); // house_owner, tenant
            $table->foreignId('category_id')->constrained('complaint_categories')->cascadeOnDelete();
            $table->string('title');
            $table->text('description');
            $table->string('photo_path')->nullable();
            $table->string('priority', 20)->default('medium'); // low, medium, high
            $table->string('status', 30)->default('Pending'); // Pending, In Progress, Resolved, Rejected
            $table->timestamps();
        });

        // 13. Complaint Comments
        Schema::create('complaint_comments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('complaint_id')->constrained('complaints')->cascadeOnDelete();
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();
            $table->text('remark');
            $table->string('status_changed_to', 30)->nullable();
            $table->timestamps();
        });

        // 9. Newsletters
        Schema::create('newsletters', function (Blueprint $table) {
            $table->id();
            $table->foreignId('society_id')->constrained('societies')->cascadeOnDelete();
            $table->foreignId('created_by')->constrained('users')->cascadeOnDelete();
            $table->string('title');
            $table->longText('content');
            $table->string('attachment_path')->nullable();
            $table->string('target_audience', 30)->default('both'); // owners_only, tenants_only, both
            $table->timestamp('published_at')->nullable();
            $table->string('status', 20)->default('draft'); // draft, published
            $table->timestamps();
        });

        // 10. Newsletter Recipients
        Schema::create('newsletter_recipients', function (Blueprint $table) {
            $table->id();
            $table->foreignId('newsletter_id')->constrained('newsletters')->cascadeOnDelete();
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();
            $table->timestamp('read_at')->nullable();
            $table->timestamps();

            $table->unique(['newsletter_id', 'user_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('newsletter_recipients');
        Schema::dropIfExists('newsletters');
        Schema::dropIfExists('complaint_comments');
        Schema::dropIfExists('complaints');
        Schema::dropIfExists('complaint_categories');
        Schema::dropIfExists('committee_members');
        Schema::dropIfExists('tenants');
        Schema::dropIfExists('owner_property');
        Schema::dropIfExists('properties');
        Schema::dropIfExists('society_members');
        Schema::dropIfExists('societies');
    }
};
