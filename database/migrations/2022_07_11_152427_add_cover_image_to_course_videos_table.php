<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(): void
    {
        Schema::table('course_videos', function (Blueprint $table) {
            $table->string('cover_image', 250)->nullable()->after('info');
            $table->string('duration', 50)->nullable()->after('cover_image');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down(): void
    {
        Schema::table('course_videos', function (Blueprint $table) {
            $table->dropColumn('cover_image');
            $table->dropColumn('duration');
        });
    }
};
