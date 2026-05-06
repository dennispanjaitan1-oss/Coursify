<?php

namespace Database\Seeders;
 
use App\Models\Institution;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
 
class InstitutionSeeder extends Seeder
{
    public function run(): void
    {
        $institutions = [
            [
                'name'        => 'Coursify Team',
                'description' => 'Tim internal Coursify yang membuat kursus berkualitas tinggi.',
                'is_verified' => true,
            ],
            [
                'name'        => 'Institut Teknologi Nusantara',
                'description' => 'Institusi pendidikan teknologi terkemuka di Indonesia.',
                'is_verified' => true,
            ],
            [
                'name'        => 'Universitas Digital Indonesia',
                'description' => 'Universitas berbasis digital untuk era modern.',
                'is_verified' => true,
            ],
            [
                'name'        => 'Google Developer Experts',
                'description' => 'Program developer experts dari Google Indonesia.',
                'is_verified' => true,
            ],
            [
                'name'        => 'Microsoft Learn Indonesia',
                'description' => 'Platform belajar resmi Microsoft untuk Indonesia.',
                'is_verified' => true,
            ],
            [
                'name'        => 'Komunitas Open Source Indonesia',
                'description' => 'Komunitas developer open source terbesar di Indonesia.',
                'is_verified' => false,
            ],
        ];
 
        foreach ($institutions as $inst) {
            Institution::create([
                'name'        => $inst['name'],
                'slug'        => Str::slug($inst['name']),
                'description' => $inst['description'],
                'is_verified' => $inst['is_verified'],
            ]);
        }
    }
}
