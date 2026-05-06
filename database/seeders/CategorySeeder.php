<?php

namespace Database\Seeders;
 
use App\Models\Category;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
 
class CategorySeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            ['icon' => '💻', 'name' => 'Computer Science', 'children' => [
                'Algoritma & Struktur Data',
                'Sistem Operasi',
                'Jaringan Komputer',
            ]],
            ['icon' => '📊', 'name' => 'Data Science', 'children' => [
                'Machine Learning',
                'Data Visualization',
                'Big Data',
            ]],
            ['icon' => '🌐', 'name' => 'Web Development', 'children' => [
                'Frontend Development',
                'Backend Development',
                'Full Stack',
            ]],
            ['icon' => '📱', 'name' => 'Mobile Development', 'children' => [
                'Android',
                'iOS',
                'Flutter & React Native',
            ]],
            ['icon' => '🤖', 'name' => 'Artificial Intelligence', 'children' => [
                'Deep Learning',
                'Natural Language Processing',
                'Computer Vision',
            ]],
            ['icon' => '🔒', 'name' => 'Cybersecurity', 'children' => [
                'Ethical Hacking',
                'Network Security',
            ]],
            ['icon' => '☁️', 'name' => 'Cloud Computing', 'children' => [
                'AWS',
                'Google Cloud',
                'DevOps',
            ]],
            ['icon' => '🎨', 'name' => 'UI/UX Design', 'children' => [
                'Figma',
                'User Research',
            ]],
            ['icon' => '💼', 'name' => 'Business & Finance', 'children' => [
                'Manajemen Proyek',
                'Kewirausahaan',
                'Akuntansi Digital',
            ]],
            ['icon' => '📈', 'name' => 'Digital Marketing', 'children' => [
                'SEO & SEM',
                'Social Media Marketing',
                'Content Marketing',
            ]],
            ['icon' => '🌍', 'name' => 'Bahasa & Sastra', 'children' => [
                'Bahasa Inggris',
                'Bahasa Jepang',
                'Public Speaking',
            ]],
            ['icon' => '🏥', 'name' => 'Kesehatan', 'children' => [
                'Kesehatan Mental',
                'Gizi & Nutrisi',
            ]],
        ];
 
        foreach ($categories as $cat) {
            $parent = Category::create([
                'name'      => $cat['name'],
                'slug'      => Str::slug($cat['name']),
                'parent_id' => null,
                'icon'      => $cat['icon'],
            ]);
 
            foreach ($cat['children'] as $childName) {
                Category::create([
                    'name'      => $childName,
                    'slug'      => Str::slug($childName) . '-' . Str::random(4),
                    'parent_id' => $parent->id,
                    'icon'      => $cat['icon'],
                ]);
            }
        }
    }
}
