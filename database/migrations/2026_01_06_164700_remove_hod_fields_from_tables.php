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
        // Remove HOD fields from users table (if exists)
        if (Schema::hasColumn('users', 'hod_id')) {
            Schema::table('users', function (Blueprint $table) {
                // Check if foreign key exists before dropping
                $foreignKeys = DB::select("
                    SELECT CONSTRAINT_NAME 
                    FROM information_schema.KEY_COLUMN_USAGE 
                    WHERE TABLE_NAME = 'users' 
                    AND COLUMN_NAME = 'hod_id' 
                    AND TABLE_SCHEMA = DATABASE()
                    AND REFERENCED_TABLE_NAME IS NOT NULL
                ");
                
                if (!empty($foreignKeys)) {
                    $table->dropForeign(['hod_id']);
                }
                
                $table->dropColumn('hod_id');
            });
        }

        // Remove HOD fields from leave_applications table (if exists)
        if (Schema::hasColumn('leave_applications', 'hod_approved_by') || 
            Schema::hasColumn('leave_applications', 'hod_approved_at') || 
            Schema::hasColumn('leave_applications', 'rejected_by_role')) {
            
            Schema::table('leave_applications', function (Blueprint $table) {
                // Check if foreign key exists before dropping
                $foreignKeys = DB::select("
                    SELECT CONSTRAINT_NAME 
                    FROM information_schema.KEY_COLUMN_USAGE 
                    WHERE TABLE_NAME = 'leave_applications' 
                    AND COLUMN_NAME = 'hod_approved_by' 
                    AND TABLE_SCHEMA = DATABASE()
                    AND REFERENCED_TABLE_NAME IS NOT NULL
                ");
                
                if (!empty($foreignKeys)) {
                    $table->dropForeign(['hod_approved_by']);
                }
                
                // Drop columns only if they exist
                if (Schema::hasColumn('leave_applications', 'hod_approved_by')) {
                    $table->dropColumn('hod_approved_by');
                }
                if (Schema::hasColumn('leave_applications', 'hod_approved_at')) {
                    $table->dropColumn('hod_approved_at');
                }
                if (Schema::hasColumn('leave_applications', 'rejected_by_role')) {
                    $table->dropColumn('rejected_by_role');
                }
            });
        }

        // Update any existing 'hod_approved' status to 'pending'
        DB::table('leave_applications')
            ->where('status', 'hod_approved')
            ->update(['status' => 'pending']);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Add back HOD fields to users table
        if (!Schema::hasColumn('users', 'hod_id')) {
            Schema::table('users', function (Blueprint $table) {
                $table->unsignedBigInteger('hod_id')->nullable()->after('status');
                $table->foreign('hod_id')->references('id')->on('users')->onDelete('set null');
            });
        }

        // Add back HOD fields to leave_applications table
        if (!Schema::hasColumn('leave_applications', 'hod_approved_by')) {
            Schema::table('leave_applications', function (Blueprint $table) {
                $table->unsignedBigInteger('hod_approved_by')->nullable()->after('status');
                $table->timestamp('hod_approved_at')->nullable()->after('hod_approved_by');
                $table->string('rejected_by_role', 20)->nullable()->after('rejection_reason');
                
                $table->foreign('hod_approved_by')->references('id')->on('users')->onDelete('set null');
            });
        }
    }
};