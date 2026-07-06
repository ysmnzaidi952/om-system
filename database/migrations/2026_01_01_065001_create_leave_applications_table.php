<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        // Check if table already exists
        if (!Schema::hasTable('leave_applications')) {
            Schema::create('leave_applications', function (Blueprint $table) {
                $table->id();
                $table->unsignedBigInteger('user_id');
                $table->enum('leave_type', ['AL', 'MC']); // We'll expand this later
                $table->date('start_date');
                $table->date('end_date');
                $table->decimal('total_days', 5, 1);
                $table->text('reason');
                $table->string('attachment')->nullable()->comment('For MC certificate');
                $table->enum('status', ['pending', 'approved', 'rejected', 'cancelled'])->default('pending');
                $table->unsignedBigInteger('approved_by')->nullable();
                $table->timestamp('approved_at')->nullable();
                $table->text('rejection_reason')->nullable();
                $table->timestamps();

                $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
                $table->foreign('approved_by')->references('id')->on('users')->onDelete('set null');
                
                $table->index('status');
                $table->index('leave_type');
            });
        }
    }

    public function down()
    {
        Schema::dropIfExists('leave_applications');
    }
};