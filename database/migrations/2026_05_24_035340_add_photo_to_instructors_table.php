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
    Schema::table('instructors', function (Blueprint $table) {
        $table->string('photo_url')->nullable()->after('title');
        $table->string('institution_logo_url')->nullable()->after('photo_url');
    });
}

public function down(): void
{
    Schema::table('instructors', function (Blueprint $table) {
        $table->dropColumn(['photo_url', 'institution_logo_url']);
    });
}
};
