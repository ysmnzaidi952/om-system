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
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('ic', 20)->unique();
            $table->string('name', 150);
            $table->string('email', 150)->nullable();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            // REMOVED reset_token and reset_token_expires_at from here
            // because they're added in separate migration file
            $table->rememberToken();
            $table->enum('role', ['admin', 'hr', 'staff', 'manager'])->default('staff');
            $table->enum('status', ['active', 'inactive', 'pending'])->default('pending');
            $table->date('date_joined')->nullable();
            $table->date('date_confirmed')->nullable();
            $table->string('shirt_size', 10)->nullable();
            $table->string('staff_status', 50)->nullable();              // THIS IS THE IMPORTANT ONE!
            $table->string('position', 100)->nullable();
            $table->date('date_of_birth')->nullable();
            $table->text('academic_qualification')->nullable();
            $table->string('years_of_experience', 50)->nullable();       // Changed from smallInteger
            $table->string('epf_number', 30)->nullable();
            $table->string('phone_number', 20)->nullable();
            $table->string('secondary_phone_number', 20)->nullable();
            $table->string('bank_name', 50)->nullable();
            $table->string('bank_account_number', 30)->nullable();
            $table->text('ic_address')->nullable();
            $table->text('current_address')->nullable();
            $table->timestamps();
        });

        Schema::create('password_reset_tokens', function (Blueprint $table) {
            $table->string('email')->primary();
            $table->string('token');
            $table->timestamp('created_at')->nullable();
        });

        Schema::create('sessions', function (Blueprint $table) {
            $table->string('id')->primary();
            $table->foreignId('user_id')->nullable()->index();
            $table->string('ip_address', 45)->nullable();
            $table->text('user_agent')->nullable();
            $table->longText('payload');
            $table->integer('last_activity')->index();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
        Schema::dropIfExists('password_reset_tokens');
        Schema::dropIfExists('sessions');
    }
};