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
        Schema::table('products', function (Blueprint $table) {
        if (!Schema::hasColumn('products', 'colors')) {
            $table->json('colors')->nullable()->after('image_url');
        }

        if (!Schema::hasColumn('products', 'sizes')) {
            $table->json('sizes')->nullable()->after('colors');
        }
        // Add tags column for product tags like 'New', 'Best Seller'
        if (!Schema::hasColumn('products', 'tags')) {
                $table->json('tags')->nullable()->after('sizes');
        }
        if (!Schema::hasColumn('products', 'gallery')) {
                $table->json('gallery')->nullable()->after('sizes');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('products', function (Blueprint $table) {
             $table->dropColumn('colors');
             $table->dropColumn('sizes');
             $table->dropColumn('tags');
             $table->dropColumn('gallery');
        });
    }
};
