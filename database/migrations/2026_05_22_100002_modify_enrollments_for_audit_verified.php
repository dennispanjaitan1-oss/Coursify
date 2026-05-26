<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        // Change enum type to include 'honor'
        DB::statement("ALTER TABLE enrollments MODIFY COLUMN `type` ENUM('audit','verified','honor') NOT NULL DEFAULT 'audit'");

        Schema::table('enrollments', function (Blueprint $table) {
            $table->timestamp('upgraded_at')->nullable()->after('completed_at');
        });
    }

    public function down(): void
    {
        // Revert 'honor' enrollments to 'audit' before removing enum value
        DB::table('enrollments')->where('type', 'honor')->update(['type' => 'audit']);
        DB::statement("ALTER TABLE enrollments MODIFY COLUMN `type` ENUM('audit','verified') NOT NULL DEFAULT 'audit'");

        Schema::table('enrollments', function (Blueprint $table) {
            $table->dropColumn('upgraded_at');
        });
    }
};
