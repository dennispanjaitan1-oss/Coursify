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
            $table->string('avatar_url')->nullable()->after('role');
            $table->string('headline', 100)->nullable()->after('avatar_url');
            $table->text('bio')->nullable()->after('headline');
            $table->string('website_url')->nullable()->after('bio');
            $table->string('linkedin_url')->nullable()->after('website_url');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['avatar_url', 'headline', 'bio', 'website_url', 'linkedin_url']);
        });
    }
};
