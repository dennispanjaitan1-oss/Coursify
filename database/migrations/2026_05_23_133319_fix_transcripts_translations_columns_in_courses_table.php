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
        $table->text('transcripts')->nullable()->change();
        $table->text('translations')->nullable()->change();
        $table->text('prerequisites')->nullable()->change();
    });
}

public function down(): void
{
    Schema::table('courses', function (Blueprint $table) {
        $table->string('transcripts')->nullable()->change();
        $table->string('translations')->nullable()->change();
        $table->string('prerequisites')->nullable()->change();
    });
}
};
