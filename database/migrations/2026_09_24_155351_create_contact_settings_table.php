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
        Schema::create('contact_settings', function (Blueprint $table) {
            $table->id();
            $table->string('title')->default('Contact');
            $table->string('sub_title')->default('Contact Us');
            $table->string('address_line1')->nullable()->default('A108 Adam Street');
            $table->string('address_line2')->nullable()->default('New York, NY 535022');
            $table->string('phone1')->nullable()->default('+1 5589 55488 55');
            $table->string('phone2')->nullable()->default('+1 6678 254445 41');
            $table->string('email1')->nullable()->default('info@example.com');
            $table->string('email2')->nullable()->default('contact@example.com');
            $table->string('open_hours_days')->nullable()->default('Monday - Friday');
            $table->string('open_hours_time')->nullable()->default('9:00AM - 05:00PM');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('contact_settings');
    }
};
