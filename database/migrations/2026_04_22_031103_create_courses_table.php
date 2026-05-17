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
        Schema::create('courses', function (Blueprint $table) {

            $table->id();

            // BASIC INFO
            $table->string('title');
            $table->string('slug')->unique();

            // RELATION
            $table->foreignId('category_id')
                  ->constrained()
                  ->cascadeOnDelete();

            $table->foreignId('institution_id')
                  ->constrained()
                  ->cascadeOnDelete();

            $table->foreignId('program_id')
                  ->nullable()
                  ->constrained()
                  ->nullOnDelete();

            // DESCRIPTION
            $table->string('short_description', 500)->nullable();
            $table->longText('description')->nullable();

            // COURSE DETAIL
            $table->decimal('price', 10, 2)->default(0);
            $table->integer('duration_weeks')->default(1);

            $table->enum('difficulty', [
                'beginner',
                'intermediate',
                'advanced'
            ]);

            $table->string('language', 10)->default('id');

            // MEDIA
            $table->string('thumbnail_url')->nullable();
            $table->string('preview_video_url')->nullable();

            // STATUS
            $table->boolean('is_published')->default(false);

            // SORTING
            $table->integer('order_index')->default(0);

            // SOFT DELETE
            $table->softDeletes();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('courses');
    }
};