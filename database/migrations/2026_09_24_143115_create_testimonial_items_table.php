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
        Schema::create('testimonial_items', function (Blueprint $table) {
            $table->id();
            $table->string('client_name'); // e.g. Alpha Net
            $table->string('designation')->default('Trusted ISP Partner'); // e.g. Trusted ISP Partner
            $table->text('review');
            $table->unsignedTinyInteger('rating')->default(5); // 1 to 5 Stars
            $table->string('avatar_letter')->nullable(); // e.g. A, B, N, S
            $table->tinyInteger('status')->default(1);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('testimonial_items');
    }
};
