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
    Schema::table('courses', function (Blueprint $table) {
        $table->text('short_description')->nullable()->change();  // hapus batas 500 char
        $table->longText('description')->nullable()->change();    // pastikan longtext
    });
}

public function down(): void
{
    Schema::table('courses', function (Blueprint $table) {
        $table->string('short_description', 500)->nullable()->change();
        $table->longText('description')->nullable()->change();
    });
}
};
