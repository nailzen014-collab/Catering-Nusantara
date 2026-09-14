<?php

namespace Database\Seeders;

use App\Models\City;
use App\Models\Category;
use App\Models\PaymentMethod;
use App\Models\Courier;
use App\Models\Customer;
use App\Models\Menu;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Urutan WAJIB mengikuti dependensi foreign key (§5.4 PRD)

        City::factory(50)->create();
        Category::factory(10)->create();
        PaymentMethod::factory(3)->create();
        Courier::factory(10)->create();

        Customer::factory(200)->create();
        Menu::factory(150)->create();

        Order::factory(150)->create()->each(function (Order $order) {
            $itemCount = rand(3, 5);

            OrderItem::factory($itemCount)->create([
                'order_id' => $order->id,
            ]);
        });

        // Akun admin (dibuat manual, bukan lewat form register — §13.5)
        $this->call(UserSeeder::class);
    }
}