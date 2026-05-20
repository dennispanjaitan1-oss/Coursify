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
        Schema::table('users', function (Blueprint $table) {
            $table->string('language')->nullable()->default('id');
            $table->string('timezone')->nullable()->default('Asia/Jakarta');
            $table->string('theme')->nullable()->default('light');
            $table->string('playback_speed')->nullable()->default('1');
            $table->string('video_quality')->nullable()->default('auto');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['language', 'timezone', 'theme', 'playback_speed', 'video_quality']);
        });
    }
};
