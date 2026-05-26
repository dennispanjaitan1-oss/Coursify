<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration {
    public function up(): void
    {
        $courseIds = DB::table('courses')
            ->orderBy('id')
            ->pluck('id')
            ->values();

        if ($courseIds->isEmpty()) {
            return;
        }

        $auditLimit = (int) ceil($courseIds->count() / 2);

        foreach ($courseIds as $index => $courseId) {
            $hasAudit = $index < $auditLimit;
            $verifiedPrice = 149000 + (($index % 5) * 50000);

            DB::table('courses')
                ->where('id', $courseId)
                ->update([
                    'has_audit_track' => $hasAudit,
                    'audit_access_weeks' => $hasAudit ? 4 + (($index % 5) * 2) : null,
                    'certificate_price' => $hasAudit ? $verifiedPrice : null,
                    'price' => $hasAudit ? 0 : $verifiedPrice,
                    'currency' => 'IDR',
                    'upgrade_deadline' => $hasAudit ? now()->addDays(30)->toDateString() : null,
                    'updated_at' => now(),
                ]);
        }
    }

    public function down(): void
    {
        DB::table('courses')->update([
            'has_audit_track' => true,
            'audit_access_weeks' => null,
            'certificate_price' => null,
            'price' => 0,
            'currency' => 'IDR',
            'upgrade_deadline' => null,
            'updated_at' => now(),
        ]);
    }
};
