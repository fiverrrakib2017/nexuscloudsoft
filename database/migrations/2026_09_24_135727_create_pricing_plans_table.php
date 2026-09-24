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
        Schema::create('pricing_plans', function (Blueprint $table) {
            $table->id();
            $table->string('name'); // e.g. Basic, Standard, Premium
            $table->string('icon')->default('bi bi-box');
            $table->string('setup_fee')->default('৳2,000');
            $table->string('setup_label')->default('One-time Setup Charge');
            $table->string('theme_color')->default('#0d6efd'); // #0d6efd, #20c997, #6f42c1
            $table->boolean('is_featured')->default(false);
            $table->string('badge_text')->nullable()->default('Most Popular');
            $table->string('btn_text')->default('Get Started');
            $table->string('btn_link')->nullable()->default('#');
            $table->integer('sort_order')->default(0);
            $table->tinyInteger('status')->default(1);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pricing_plans');
    }
};
