<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Employee Master Data foundation — Human Resources L1.
 *
 * Schema mirrors the SAP B1 Employee Master Data form layout received as
 * reference screenshots. Six tables in one migration: a wide flat employees
 * table holding header + Address (work/home) + Administration + Personal +
 * Finance + Flight Ops home base + Remarks; plus five child tables for the
 * Membership tab (roles, teams), Flight Ops (crew positions, employee
 * assignments), and Attachments.
 *
 * Address fields stay inline (work_* / home_* prefixed) following the same
 * pattern used by the warehouses table — keeps the SAP-flat shape and avoids
 * an early polymorphic addresses abstraction.
 *
 * Foreign-key columns kept as nullable strings or unconstrained foreign IDs
 * for now where the target table doesn't exist yet (manager self-reference,
 * user_code / linked_vendor / home_base). Constraints can be added in a
 * follow-up migration once the related models ship.
 */
return new class extends Migration
{
    public function up(): void
    {
        Schema::create('employees', function (Blueprint $table): void {
            $table->id();

            // -- Header (top of the form) ----------------------------------
            $table->string('first_name');
            $table->string('middle_name')->nullable();
            $table->string('last_name');
            $table->string('employee_no')->unique();
            $table->string('ext_employee_no')->nullable();
            $table->boolean('active_employee')->default(true);

            $table->string('job_title')->nullable();
            $table->string('position')->nullable();
            $table->string('department')->nullable();
            $table->string('branch')->nullable();
            // Self-reference; FK constraint deferred (chicken-and-egg in same migration).
            $table->unsignedBigInteger('manager_id')->nullable();
            $table->string('user_code')->nullable();         // FK to users when wired
            $table->string('sales_employee')->nullable();
            $table->string('cost_center')->nullable();

            $table->string('office_phone')->nullable();
            $table->string('office_phone_ext')->nullable();
            $table->string('mobile_phone')->nullable();
            $table->string('pager')->nullable();
            $table->string('home_phone')->nullable();
            $table->string('fax')->nullable();
            $table->string('email')->nullable();
            $table->string('linked_vendor')->nullable();    // FK to BPs when wired

            $table->string('photo_path')->nullable();

            // -- Address tab — Work ---------------------------------------
            $table->string('work_street')->nullable();
            $table->string('work_street_no')->nullable();
            $table->string('work_block')->nullable();
            $table->string('work_building_floor_room')->nullable();
            $table->string('work_zip_code')->nullable();
            $table->string('work_city')->nullable();
            $table->string('work_county')->nullable();
            $table->string('work_state')->nullable();
            $table->string('work_country')->nullable();

            // -- Address tab — Home ---------------------------------------
            $table->string('home_street')->nullable();
            $table->string('home_street_no')->nullable();
            $table->string('home_block')->nullable();
            $table->string('home_building_floor_room')->nullable();
            $table->string('home_zip_code')->nullable();
            $table->string('home_city')->nullable();
            $table->string('home_county')->nullable();
            $table->string('home_state')->nullable();
            $table->string('home_country')->nullable();

            // -- Administration tab ---------------------------------------
            $table->date('start_date')->nullable();
            $table->string('status')->nullable();           // Active / On Leave / Terminated / etc.
            $table->date('termination_date')->nullable();
            $table->string('termination_reason')->nullable();
            $table->string('reference_1')->nullable();
            $table->date('reference_1_from')->nullable();
            $table->date('reference_1_to')->nullable();
            $table->string('reference_2')->nullable();
            $table->date('reference_2_from')->nullable();
            $table->date('reference_2_to')->nullable();
            $table->text('admin_remarks')->nullable();
            $table->string('work_profile')->nullable();

            // -- Personal tab ---------------------------------------------
            $table->string('gender')->nullable();           // Male / Female / Other
            $table->date('date_of_birth')->nullable();
            $table->string('country_of_birth')->nullable();
            $table->string('marital_status')->nullable();   // Single / Married / Divorced / Widowed
            $table->unsignedSmallInteger('number_of_children')->nullable();
            $table->string('id_no')->nullable();
            $table->string('citizenship')->nullable();
            $table->string('passport_no')->nullable();
            $table->date('passport_expiration_date')->nullable();
            $table->date('passport_issue_date')->nullable();
            $table->string('passport_issuer')->nullable();

            // -- Finance tab ----------------------------------------------
            $table->decimal('salary_amount', 14, 2)->nullable();
            $table->string('salary_period')->nullable();    // Month / Year / Hour / etc.
            $table->decimal('employee_costs_amount', 14, 2)->nullable();
            $table->string('employee_costs_period')->nullable();
            $table->string('bank')->nullable();
            $table->string('bank_account_no')->nullable();
            $table->string('bank_branch')->nullable();

            // -- Flight Ops tab — header (sub-tab Crew Management) -------
            $table->string('home_base')->nullable();        // FK to FL when wired

            // -- Remarks tab ---------------------------------------------
            $table->text('remarks')->nullable();

            $table->timestamps();
        });

        // -- Membership tab — Roles ---------------------------------------
        Schema::create('employee_roles', function (Blueprint $table): void {
            $table->id();
            $table->foreignId('employee_id')->constrained('employees')->cascadeOnDelete();
            $table->string('role');
            $table->boolean('is_default')->default(false);
            $table->unsignedSmallInteger('sort_order')->default(0);
            $table->timestamps();

            $table->index(['employee_id', 'sort_order']);
        });

        // -- Membership tab — Teams ---------------------------------------
        Schema::create('employee_teams', function (Blueprint $table): void {
            $table->id();
            $table->foreignId('employee_id')->constrained('employees')->cascadeOnDelete();
            $table->string('team');
            $table->string('team_role')->nullable();
            $table->unsignedSmallInteger('sort_order')->default(0);
            $table->timestamps();

            $table->index(['employee_id', 'sort_order']);
        });

        // -- Flight Ops — Crew Management Positions list ------------------
        Schema::create('employee_crew_positions', function (Blueprint $table): void {
            $table->id();
            $table->foreignId('employee_id')->constrained('employees')->cascadeOnDelete();
            $table->string('position');
            $table->unsignedSmallInteger('sort_order')->default(0);
            $table->timestamps();

            $table->index(['employee_id', 'sort_order']);
        });

        // -- Flight Ops — Employee Assignment -----------------------------
        Schema::create('employee_assignments', function (Blueprint $table): void {
            $table->id();
            $table->foreignId('employee_id')->constrained('employees')->cascadeOnDelete();
            $table->text('assignment');
            $table->unsignedSmallInteger('sort_order')->default(0);
            $table->timestamps();

            $table->index(['employee_id', 'sort_order']);
        });

        // -- Attachments tab ----------------------------------------------
        Schema::create('employee_attachments', function (Blueprint $table): void {
            $table->id();
            $table->foreignId('employee_id')->constrained('employees')->cascadeOnDelete();
            $table->string('target_path');
            $table->string('file_name');
            $table->date('attachment_date')->nullable();
            $table->unsignedSmallInteger('sort_order')->default(0);
            $table->timestamps();

            $table->index(['employee_id', 'sort_order']);
        });
    }

    public function down(): void
    {
        // Drop in reverse order so FK constraints unwind cleanly.
        Schema::dropIfExists('employee_attachments');
        Schema::dropIfExists('employee_assignments');
        Schema::dropIfExists('employee_crew_positions');
        Schema::dropIfExists('employee_teams');
        Schema::dropIfExists('employee_roles');
        Schema::dropIfExists('employees');
    }
};
