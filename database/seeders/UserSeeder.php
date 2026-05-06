<?php

namespace Database\Seeders;
 
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
 
class UserSeeder extends Seeder
{
    public function run(): void
    {
        // ── Akun tetap (untuk login saat demo) ──────────────────────
        User::create([
            'name'              => 'Admin Coursify',
            'email'             => 'admin@coursify.com',
            'password'          => Hash::make('password'),
            'role'              => 'admin',
            'email_verified_at' => now(),
        ]);
 
        User::create([
            'name'              => 'Budi Instruktur',
            'email'             => 'instructor@coursify.com',
            'password'          => Hash::make('password'),
            'role'              => 'instructor',
            'email_verified_at' => now(),
        ]);
 
        User::create([
            'name'              => 'Siti Mahasiswa',
            'email'             => 'student@coursify.com',
            'password'          => Hash::make('password'),
            'role'              => 'student',
            'email_verified_at' => now(),
        ]);
 
        // ── Instruktur tambahan ──────────────────────────────────────
        $instructorNames = [
            ['Andi Pratama',    'andi@coursify.com'],
            ['Dewi Rahayu',     'dewi@coursify.com'],
            ['Rizky Firmansyah','rizky@coursify.com'],
            ['Nadia Kusuma',    'nadia@coursify.com'],
            ['Hendra Wijaya',   'hendra@coursify.com'],
        ];
 
        foreach ($instructorNames as [$name, $email]) {
            User::create([
                'name'              => $name,
                'email'             => $email,
                'password'          => Hash::make('password'),
                'role'              => 'instructor',
                'email_verified_at' => now(),
            ]);
        }
 
        // ── 30 student dummy ─────────────────────────────────────────
        User::factory()->count(30)->student()->create();
    }
}
