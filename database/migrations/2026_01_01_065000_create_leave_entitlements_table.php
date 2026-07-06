<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        // Check if table already exists (since we created it manually before)
        if (!Schema::hasTable('leave_entitlements')) {
            Schema::create('leave_entitlements', function (Blueprint $table) {
                $table->id();
                $table->unsignedBigInteger('user_id');
                $table->year('year');
                $table->integer('annual_leave_total')->default(14);
                $table->integer('medical_leave_total')->default(14);
                $table->decimal('annual_leave_used', 5, 1)->default(0.0);
                $table->decimal('medical_leave_used', 5, 1)->default(0.0);
                $table->timestamps();

                $table->unique(['user_id', 'year'], 'leave_entitlements_user_year_unique');
                $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            });
        }
    }

    public function down()
    {
        Schema::dropIfExists('leave_entitlements');
    }
};