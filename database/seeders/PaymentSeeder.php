<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PaymentSeeder extends Seeder
{
    /**
     * Seeder ini TIDAK dijalankan standalone — payment sudah dibuat
     * di dalam EnrollmentSeeder bersamaan dengan enrollment.
     *
     * Gunakan seeder ini jika ingin menambahkan payment orphan
     * (payment tanpa enrollment yang berhasil) untuk testing edge cases.
     */
    public function run(): void
    {
        $users   = DB::table('users')->where('role', 'student')->pluck('id')->toArray();
        $methods = ['transfer_bank', 'gopay', 'ovo', 'dana', 'qris', 'kartu_kredit'];
        $statuses = ['pending', 'failed', 'refunded'];

        if (empty($users)) {
            $this->command->warn('⚠️  Tidak ada student user. Jalankan UserSeeder dulu.');
            return;
        }

        $batch = [];

        // Tambahkan 50 payment yang failed/pending/refunded untuk testing
        for ($i = 0; $i < 50; $i++) {
            $userId    = $users[array_rand($users)];
            $status    = $statuses[array_rand($statuses)];
            $createdAt = now()->subDays(rand(1, 180));

            $batch[] = [
                'user_id'        => $userId,
                'amount'         => rand(1, 10) * 50000, // Rp 50.000 - 500.000
                'currency'       => 'IDR',
                'method'         => $methods[array_rand($methods)],
                'status'         => $status,
                'transaction_id' => strtoupper('TXN-FAIL-' . uniqid()),
                'snap_token'     => null,
                'paid_at'        => null,
                'created_at'     => $createdAt,
                'updated_at'     => $createdAt,
            ];
        }

        DB::table('payments')->insert($batch);

        $this->command->info('✅ Payment edge cases seeded: 50 additional records (failed/pending/refunded)');
    }
}
