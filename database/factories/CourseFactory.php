<?php

namespace Database\Factories;
 
use App\Models\Category;
use App\Models\Institution;
use App\Models\Program;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
 
class CourseFactory extends Factory
{
    public function definition(): array
    {
        $title = fake()->unique()->sentence(rand(3, 6));
        $title = rtrim($title, '.');
 
        return [
            'institution_id'    => Institution::inRandomOrder()->first()?->id ?? 1,
            'category_id'       => Category::whereNull('parent_id')->inRandomOrder()->first()?->id ?? 1,
            'program_id'        => null,
            'title'             => $title,
            'slug'              => Str::slug($title) . '-' . Str::random(4),
            'short_description' => fake()->sentence(12),
            'description'       => fake()->paragraphs(4, true),
            'price'             => fake()->randomElement([0, 0, 0, 99000, 149000, 199000, 299000, 499000]),
            'duration_weeks'    => fake()->randomElement([2, 4, 6, 8, 12]),
            'difficulty'        => fake()->randomElement(['beginner', 'intermediate', 'advanced']),
            'language'          => 'id',
            'is_published'      => true,
            'order_index'       => 0,
        ];
    }
 
    public function free(): static
    {
        return $this->state(['price' => 0]);
    }
 
    public function paid(): static
    {
        return $this->state(['price' => fake()->randomElement([99000, 149000, 199000, 299000])]);
    }
 
    public function unpublished(): static
    {
        return $this->state(['is_published' => false]);
    }
}
