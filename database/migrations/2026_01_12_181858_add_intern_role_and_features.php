<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // 1. Add 'intern' to role enum
        DB::statement("ALTER TABLE users MODIFY COLUMN role ENUM('admin','hr','staff','manager','hod','intern') NOT NULL DEFAULT 'staff'");
        
        // 2. Add profile photo column
        Schema::table('users', function (Blueprint $table) {
            $table->string('profile_photo')->nullable()->after('email');
        });
        
        // 3. Add internship duration columns
        Schema::table('users', function (Blueprint $table) {
            $table->date('internship_start_date')->nullable()->after('date_confirmed');
            $table->date('internship_end_date')->nullable()->after('internship_start_date');
        });
        
        // 4. Allow custom leave entitlements (already flexible in your current table)
        // No changes needed - admin can already set custom values
    }

    public function down(): void
    {
        DB::statement("ALTER TABLE users MODIFY COLUMN role ENUM('admin','hr','staff','manager','hod') NOT NULL DEFAULT 'staff'");
        
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['profile_photo', 'internship_start_date', 'internship_end_date']);
        });
    }
};