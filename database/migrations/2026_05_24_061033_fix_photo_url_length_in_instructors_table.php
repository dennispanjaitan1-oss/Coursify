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
        $table->text('photo_url')->nullable()->change();
        $table->text('institution_logo_url')->nullable()->change();
    });
}

public function down(): void
{
    Schema::table('instructors', function (Blueprint $table) {
        $table->string('photo_url', 255)->nullable()->change();
        $table->string('institution_logo_url', 255)->nullable()->change();
    });
}
};
