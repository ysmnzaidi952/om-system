<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Step 1: Modify leave_applications table
        Schema::table('leave_applications', function (Blueprint $table) {
            // Add half-day columns
            $table->boolean('is_half_day')->default(false)->after('total_days');
            $table->enum('half_day_period', ['AM', 'PM'])->nullable()->after('is_half_day');
        });

        // Step 2: Update leave_type enum to include MRL
        DB::statement("ALTER TABLE `leave_applications` MODIFY `leave_type` ENUM('AL','EL','MC','CL','WFH','ML','PL','RL','MRL','HALF_DAY_AL','HALF_DAY_EL') NOT NULL");

        // Step 3: Update status enum to include waiting_list and special_case_approved
        DB::statement("ALTER TABLE `leave_applications` MODIFY `status` ENUM('pending','hod_approved','approved','rejected','cancelled','waiting_list','special_case_approved') NOT NULL DEFAULT 'pending'");

        // Step 4: Make email required in users table (remove nullable)
        Schema::table('users', function (Blueprint $table) {
            $table->string('email', 150)->nullable(false)->change();
        });

        // Step 5: Remove email_verified_at column
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('email_verified_at');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Rollback changes
        Schema::table('leave_applications', function (Blueprint $table) {
            $table->dropColumn(['is_half_day', 'half_day_period']);
        });

        DB::statement("ALTER TABLE `leave_applications` MODIFY `leave_type` ENUM('AL','EL','MC','CL','WFH','ML','PL','RL') NOT NULL");

        DB::statement("ALTER TABLE `leave_applications` MODIFY `status` ENUM('pending','hod_approved','approved','rejected','cancelled') NOT NULL DEFAULT 'pending'");

        Schema::table('users', function (Blueprint $table) {
            $table->string('email', 150)->nullable()->change();
            $table->timestamp('email_verified_at')->nullable();
        });
    }
};