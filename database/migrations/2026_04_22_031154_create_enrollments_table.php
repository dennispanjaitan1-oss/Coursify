<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('enrollments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('course_id')->constrained()->onDelete('cascade');
            $table->foreignId('payment_id')->nullable()->constrained()->onDelete('set null');
            $table->enum('type', ['audit', 'verified'])->default('audit');
            $table->enum('status', ['active', 'completed', 'refunded'])->default('active');
            $table->decimal('progress_percent', 5, 2)->default(0.00);
            $table->timestamp('completed_at')->nullable();
            $table->timestamps();

            // Satu user hanya bisa enroll sekali per course (3NF: tidak ada duplikasi)
            $table->unique(['user_id', 'course_id']);
        });
    }
    public function down(): void { Schema::dropIfExists('enrollments'); }
};
