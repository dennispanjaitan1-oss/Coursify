<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('courses', function (Blueprint $table) {
            $table->boolean('has_audit_track')->default(true)->after('has_certificate');
            $table->decimal('certificate_price', 10, 2)->nullable()->after('price');
            $table->date('upgrade_deadline')->nullable()->after('enroll_deadline');
            $table->integer('audit_access_weeks')->nullable()->after('has_audit_track');
            $table->string('currency', 5)->default('USD')->after('certificate_price');
        });
    }

    public function down(): void
    {
        Schema::table('courses', function (Blueprint $table) {
            $table->dropColumn([
                'has_audit_track',
                'certificate_price',
                'upgrade_deadline',
                'audit_access_weeks',
                'currency',
            ]);
        });
    }
};
