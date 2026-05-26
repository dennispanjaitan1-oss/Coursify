<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration {
    public function up(): void
    {
        $courseIds = DB::table('courses')->orderBy('id')->pluck('id')->values();

        foreach ($courseIds as $index => $courseId) {
            $isPaid = $index < 10;
            $price = 149000 + (($index % 4) * 50000);

            DB::table('courses')
                ->where('id', $courseId)
                ->update([
                    'has_audit_track' => true,
                    'price' => $isPaid ? $price : 0,
                    'certificate_price' => $isPaid ? $price : null,
                    'audit_access_weeks' => $isPaid ? 6 : null,
                    'upgrade_deadline' => $isPaid ? now()->addDays(35)->toDateString() : null,
                    'currency' => 'IDR',
                    'updated_at' => now(),
                ]);
        }
    }

    public function down(): void
    {
        DB::table('courses')->update([
            'has_audit_track' => true,
            'price' => 0,
            'certificate_price' => null,
            'audit_access_weeks' => null,
            'upgrade_deadline' => null,
            'currency' => 'IDR',
            'updated_at' => now(),
        ]);
    }
};
