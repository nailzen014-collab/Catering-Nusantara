<?php

namespace Database\Factories;

use App\Models\Menu;
use Illuminate\Database\Eloquent\Factories\Factory;

class OrderItemFactory extends Factory
{
    public function definition(): array
    {
        $menu = Menu::inRandomOrder()->first();
        $qty  = fake()->numberBetween(1, 10);

        return [
            'menu_id'  => $menu->id,
            'qty'      => $qty,
            'subtotal' => $menu->price * $qty, // dihitung otomatis dari harga menu
            // 'order_id' diisi manual di seeder (loop per order)
        ];
    }
}