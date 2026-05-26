<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('payments', function (Blueprint $table) {
            $table->string('first_name')->nullable()->after('paid_at');
            $table->string('last_name')->nullable()->after('first_name');
            $table->string('country')->nullable()->after('last_name');
            $table->string('billing_email')->nullable()->after('country');
            $table->string('card_last4', 4)->nullable()->after('billing_email');
            $table->string('card_brand')->nullable()->after('card_last4');
            $table->string('card_expiry', 5)->nullable()->after('card_brand');
            $table->string('coupon_code')->nullable()->after('card_expiry');
            $table->decimal('discount_amount', 12, 2)->default(0)->after('coupon_code');
            $table->decimal('original_amount', 12, 2)->nullable()->after('discount_amount');
            $table->decimal('final_amount', 12, 2)->nullable()->after('original_amount');
            $table->string('ip_address', 45)->nullable()->after('final_amount');
        });
    }

    public function down(): void
    {
        Schema::table('payments', function (Blueprint $table) {
            $table->dropColumn([
                'first_name',
                'last_name',
                'country',
                'billing_email',
                'card_last4',
                'card_brand',
                'card_expiry',
                'coupon_code',
                'discount_amount',
                'original_amount',
                'final_amount',
                'ip_address',
            ]);
        });
    }
};
