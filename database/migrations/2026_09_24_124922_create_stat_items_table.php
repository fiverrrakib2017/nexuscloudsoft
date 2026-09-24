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
        Schema::create('stat_items', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->integer('count');
            $table->string('icon')->default('bi bi-emoji-smile');
            $table->string('color')->default('#4154f1'); // Icon color code (HEX)
            $table->tinyInteger('status')->default(1); // 1 = Active, 0 = Inactive
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('stat_items');
    }
};
