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
        Schema::table('inquiries', function (Blueprint $table) {
            $table->json('selected_size')->nullable()->after('quantity');
            $table->json('selected_images')->nullable()->after('selected_size');
            $table->json('variant_details')->nullable()->after('selected_images');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('inquiries', function (Blueprint $table) {
            $table->dropColumn(['selected_size', 'selected_images', 'variant_details']);
        });
    }
};
