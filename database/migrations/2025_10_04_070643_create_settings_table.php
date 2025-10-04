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
        Schema::create('settings', function (Blueprint $table) {
            $table->id();
            $table->string('site_name')->nullable();
            $table->string('logo')->nullable();
            $table->string('email')->nullable();
            $table->string('phone')->nullable();
            $table->string('address')->nullable();
            $table->string('footer_brand_name')->nullable();
            $table->text('footer_brand_desc')->nullable();
            $table->string('footer_facebook')->nullable();
            $table->string('footer_instagram')->nullable();
            $table->string('footer_linkedin')->nullable();
            $table->string('footer_address')->nullable();
            $table->string('footer_phone')->nullable();
            $table->string('footer_email')->nullable();
            $table->string('footer_copyright')->nullable();
            $table->timestamps();
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('settings');
    }
};
