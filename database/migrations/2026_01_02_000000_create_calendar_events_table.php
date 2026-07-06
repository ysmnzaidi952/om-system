<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('calendar_events', function (Blueprint $table) {
            $table->id();
            $table->string('title'); // Event title (e.g., "Husna last day intern")
            $table->date('event_date'); // Date of the event
            $table->text('description')->nullable(); // Optional description
            $table->string('color', 20)->default('green'); // Color for the event
            $table->unsignedBigInteger('created_by'); // Admin who created it
            $table->timestamps();
            
            $table->foreign('created_by')->references('id')->on('users')->onDelete('cascade');
            $table->index('event_date');
        });
    }

    public function down()
    {
        Schema::dropIfExists('calendar_events');
    }
};