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
        Schema::create('featured_collections', function (Blueprint $table) {
            $table->id();
            $table->string('main_title');     // Section main title (eg: "Featured Collections")
            $table->string('main_subtitle')->nullable(); // Section main subtitle
            $table->string('title');          // Each collection card title
            $table->string('subtitle')->nullable(); // Each collection card subtitle
            $table->string('image');          // Path to image
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('featured_collections');
    }
};
