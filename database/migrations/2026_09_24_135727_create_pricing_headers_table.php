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
        Schema::create('pricing_headers', function (Blueprint $table) {
            $table->id();
            $table->string('title')->default('Pricing');
            $table->string('sub_title')->nullable()->default('Choose the Perfect Plan for Your ISP Business');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pricing_headers');
    }
};
