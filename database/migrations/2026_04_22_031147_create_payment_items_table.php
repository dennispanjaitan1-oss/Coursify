<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('payment_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('payment_id')->constrained()->onDelete('cascade');
            $table->foreignId('course_id')->nullable()->constrained()->onDelete('set null');
            $table->foreignId('program_id')->nullable()->constrained()->onDelete('set null');
            $table->enum('item_type', ['course', 'program']);
            $table->decimal('price', 12, 2);   // harga saat transaksi (snapshot)
            $table->timestamps();
        });
    }
    public function down(): void { Schema::dropIfExists('payment_items'); }
};
