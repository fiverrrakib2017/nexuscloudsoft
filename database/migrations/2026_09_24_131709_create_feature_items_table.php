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
        Schema::create('feature_items', function (Blueprint $table) {
           $table->id();
            $table->string('title');
            $table->string('icon')->default('bi bi-check-circle-fill');
            $table->tinyInteger('status')->default(1); // 1 = Active, 0 = Inactive
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('feature_items');
    }
};
