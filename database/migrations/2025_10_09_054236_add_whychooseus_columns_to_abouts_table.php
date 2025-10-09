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
        Schema::table('abouts', function (Blueprint $table) {
            $table->longText('why_choose_us_1')->nullable()->after('testimonial_author');
            $table->longText('why_choose_us_2')->nullable()->after('why_choose_us_1');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('abouts', function (Blueprint $table) {
            $table->dropColumn(['why_choose_us_1', 'why_choose_us_2']);
        });
    }
};
