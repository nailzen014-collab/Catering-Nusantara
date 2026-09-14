<?php

namespace Database\Factories;

use App\Models\Category;
use Illuminate\Database\Eloquent\Factories\Factory;

class MenuFactory extends Factory
{
    public function definition(): array
    {
        return [
            'name'        => fake()->randomElement([
                'Nasi Liwet', 'Ayam Bakar Bumbu Rujak', 'Rendang Sapi', 'Sayur Asem',
                'Perkedel Kentang', 'Tumpeng Mini Kuning', 'Kue Lapis', 'Es Cendol',
                'Soto Ayam', 'Gado-Gado', 'Sate Ayam', 'Pisang Goreng',
            ]) . ' ' . fake()->numberBetween(1, 999), // biar unik
            'price'       => fake()->numberBetween(8, 60) * 1000,
            'category_id' => Category::inRandomOrder()->value('id'),
        ];
    }
}