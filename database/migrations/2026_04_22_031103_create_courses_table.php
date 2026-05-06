<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('courses', function (Blueprint $table) {
            $table->id();
            $table->foreignId('program_id')->nullable()->constrained()->onDelete('set null');
            $table->foreignId('institution_id')->constrained()->onDelete('cascade');
            $table->foreignId('category_id')->constrained()->onDelete('cascade');
            $table->string('title');
            $table->string('slug')->unique();
            $table->text('short_description')->nullable();
            $table->longText('description')->nullable();
            $table->decimal('price', 12, 2)->default(0);        // 0 = gratis
            $table->integer('duration_weeks')->default(4);
            $table->enum('difficulty', ['beginner', 'intermediate', 'advanced'])->default('beginner');
            $table->string('thumbnail_url')->nullable();
            $table->string('preview_video_url')->nullable();     // video trailer kursus
            $table->string('language')->default('id');
            $table->boolean('is_published')->default(false);
            $table->integer('order_index')->default(0);          // urutan dalam program
            $table->timestamps();
            $table->softDeletes();
        });
    }
    public function down(): void { Schema::dropIfExists('courses'); }
};
