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
            $table->string('hours_per_week')->nullable()->after('duration_weeks');
            $table->date('start_date')->nullable()->after('hours_per_week');
            $table->date('enroll_deadline')->nullable()->after('start_date');
            $table->boolean('is_self_paced')->default(false)->after('enroll_deadline');
            $table->boolean('has_certificate')->default(true)->after('is_self_paced');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('courses', function (Blueprint $table) {
            $table->dropColumn(['hours_per_week', 'start_date', 'enroll_deadline', 'is_self_paced', 'has_certificate']);
        });
    }
};
