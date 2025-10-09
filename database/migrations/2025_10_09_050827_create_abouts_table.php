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
        Schema::create('abouts', function (Blueprint $table) {
            $table->id();
            // Hero / header
            $table->string('hero_image')->nullable();
            $table->integer('experience_years')->nullable();

            // Testimonial
            $table->text('testimonial_text')->nullable();
            $table->string('testimonial_author')->nullable();

            // About main content
            $table->string('about_title')->nullable();
            $table->string('about_subtitle')->nullable();
            $table->text('paragraph1')->nullable();
            $table->text('paragraph2')->nullable();

            // Why choose section
            $table->string('why_title')->nullable();
            $table->text('why_paragraph')->nullable();
            $table->json('why_list')->nullable(); // array of bullets

            // Stats (json array of {label, number, suffix})
            $table->json('stats')->nullable();

            // Team (json array of {name, designation, image})
            $table->json('team')->nullable();

            $table->boolean('status')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('abouts');
    }
};
