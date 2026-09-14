<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class CategoryFactory extends Factory
{
    public function definition(): array
    {
        return [
            'name' => fake()->unique()->randomElement([
                'Nasi Box', 'Prasmanan', 'Snack Box', 'Tumpeng Mini',
                'Pembuka', 'Utama', 'Penutup', 'Minuman', 'Sambal & Lauk', 'Kue Tradisional',
            ]),
        ];
    }
}