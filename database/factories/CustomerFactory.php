<?php

namespace Database\Factories;

use App\Models\City;
use Illuminate\Database\Eloquent\Factories\Factory;

class CustomerFactory extends Factory
{
    public function definition(): array
    {
        return [
            'name'    => fake()->name(),
            'phone'   => fake()->numerify('08##########'),
            'city_id' => City::inRandomOrder()->value('id'),
        ];
    }
}