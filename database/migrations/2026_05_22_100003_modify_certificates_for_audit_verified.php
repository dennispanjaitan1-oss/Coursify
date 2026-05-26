<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('certificates', function (Blueprint $table) {
            // Link certificate to enrollment
            $table->foreignId('enrollment_id')
                  ->nullable()
                  ->after('course_id')
                  ->constrained('enrollments')
                  ->nullOnDelete();

            // Certificate type (verified, honor, professional)
            $table->enum('certificate_type', ['verified', 'honor', 'professional'])
                  ->default('verified')
                  ->after('certificate_number');

            // Status tracking
            $table->enum('status', ['downloadable', 'notpassing', 'generating'])
                  ->default('downloadable')
                  ->after('certificate_type');

            // Grade at time of certificate issuance
            $table->decimal('grade', 5, 2)->nullable()->after('status');

            // Soft revoke
            $table->timestamp('revoked_at')->nullable()->after('issued_at');
        });
    }

    public function down(): void
    {
        Schema::table('certificates', function (Blueprint $table) {
            $table->dropForeign(['enrollment_id']);
            $table->dropColumn([
                'enrollment_id',
                'certificate_type',
                'status',
                'grade',
                'revoked_at',
            ]);
        });
    }
};
