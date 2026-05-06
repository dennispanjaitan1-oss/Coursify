<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('certificates', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('course_id')->nullable()->constrained()->onDelete('set null');
            $table->foreignId('program_id')->nullable()->constrained()->onDelete('set null');
            $table->string('certificate_number')->unique();        // CERT-2025-XXXXX
            $table->string('file_path')->nullable();               // path PDF tersimpan
            $table->timestamp('issued_at');
            $table->timestamps();
        });
    }
    public function down(): void { Schema::dropIfExists('certificates'); }
};
