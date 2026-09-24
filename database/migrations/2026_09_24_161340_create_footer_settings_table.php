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
        Schema::create('footer_settings', function (Blueprint $table) {
           $table->id();
            
            // CTA Section
            $table->string('cta_title')->nullable()->default('Ready to Grow Your ISP Business?');
            $table->text('cta_description')->nullable();
            $table->string('cta_btn1_text')->nullable()->default('View Pricing');
            $table->string('cta_btn1_url')->nullable()->default('#pricing');
            $table->string('cta_btn2_text')->nullable()->default('Contact Us');
            $table->string('cta_btn2_url')->nullable()->default('#contact');

            // About & Contact Section
            $table->string('site_name')->nullable()->default('ISP Billing');
            $table->text('about_text')->nullable();
            $table->string('phone')->nullable()->default('+880 1700-000000');
            $table->string('email')->nullable()->default('support@yourdomain.com');

            // Social Media Section
            $table->text('social_description')->nullable();
            $table->string('facebook')->nullable();
            $table->string('youtube')->nullable();
            $table->string('linkedin')->nullable();
            $table->string('github')->nullable();

            // Copyright Section
            $table->string('copyright_text')->nullable()->default('ISP Billing Management Software');
            $table->string('developed_by')->nullable()->default('Your Company Name');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('footer_settings');
    }
};
