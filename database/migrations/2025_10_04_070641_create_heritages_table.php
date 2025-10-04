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
        Schema::create('heritages', function (Blueprint $table) {
            $table->id();
            $table->string('title')->nullable();
            $table->text('paragraph1')->nullable();
            $table->text('paragraph2')->nullable();
            $table->string('button_text')->nullable();
            $table->string('image')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('heritages');
    }
};
