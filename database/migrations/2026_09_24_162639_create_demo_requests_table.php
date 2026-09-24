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
        Schema::create('demo_requests', function (Blueprint $table) {
            $table->id();
            $table->string('company_name'); // ISP / Company Name
            $table->string('name');         // Contact Person Name
            $table->string('phone');        // Phone Number
            $table->string('email');        // Email Address
            $table->string('district')->nullable(); // Location / District
            $table->string('user_count')->nullable(); // Estimated Active Users (e.g. 100-500)
            $table->text('message')->nullable();      // Additional Requirements
            $table->enum('status', ['pending', 'contacted', 'completed', 'rejected'])->default('pending');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('demo_requests');
    }
};
