<?php

namespace Database\Factories;

use App\Models\Customer;
use App\Models\PaymentMethod;
use App\Models\Courier;
use Illuminate\Database\Eloquent\Factories\Factory;

class OrderFactory extends Factory
{
    public function definition(): array
    {
        return [
            'customer_id'        => Customer::inRandomOrder()->value('id'),
            'payment_method_id'  => PaymentMethod::inRandomOrder()->value('id'),
            'courier_id'         => Courier::inRandomOrder()->value('id'),
            'status'             => fake()->randomElement(['pending', 'processing', 'delivered', 'cancelled']),
        ];
    }
}