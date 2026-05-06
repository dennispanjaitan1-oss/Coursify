<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('lessons', function (Blueprint $table) {
            $table->id();
            $table->foreignId('section_id')->constrained()->onDelete('cascade');
            $table->string('title');
            $table->enum('type', ['video', 'article', 'quiz'])->default('video');
            $table->string('video_url')->nullable();
            $table->longText('content')->nullable();             // untuk tipe article
            $table->integer('duration_seconds')->default(0);
            $table->integer('order_index')->default(0);
            $table->boolean('is_free_preview')->default(false);  // bisa dilihat tanpa enroll
            $table->timestamps();
        });
    }
    public function down(): void { Schema::dropIfExists('lessons'); }
};
