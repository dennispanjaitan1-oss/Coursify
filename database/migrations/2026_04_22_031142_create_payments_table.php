<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('payments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->decimal('amount', 12, 2);
            $table->string('currency', 3)->default('IDR');
            $table->enum('method', [
                'transfer_bank', 'kartu_kredit', 'gopay', 'ovo', 'dana', 'qris', 'free'
            ])->nullable();
            $table->enum('status', ['pending', 'paid', 'failed', 'refunded'])->default('pending');
            $table->string('transaction_id')->nullable()->unique(); // dari payment gateway
            $table->string('snap_token')->nullable();              // untuk Midtrans Snap
            $table->timestamp('paid_at')->nullable();
            $table->timestamps();
        });
    }
    public function down(): void { Schema::dropIfExists('payments'); }
};
