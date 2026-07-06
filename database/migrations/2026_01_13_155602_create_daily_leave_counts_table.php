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
        Schema::create('daily_leave_counts', function (Blueprint $table) {
            $table->id();
            $table->date('leave_date')->unique();
            $table->integer('total_count')->default(0);
            $table->integer('customer_support_count')->default(0);
            $table->integer('other_staff_count')->default(0);
            $table->timestamps();
            
            $table->index('leave_date');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('daily_leave_counts');
    }
};