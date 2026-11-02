<?php

namespace Tests\Feature;

use App\Models\Category;
use App\Models\City;
use App\Models\Courier;
use App\Models\Customer;
use App\Models\Menu;
use App\Models\Order;
use App\Models\PaymentMethod;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class DisplaySmokeTest extends TestCase
{
    use RefreshDatabase;

    public function test_guest_auth_pages_render_content(): void
    {
        foreach (['/login', '/register', '/forgot-password'] as $url) {
            $this->get($url)
                ->assertOk()
                ->assertSee('auth-card')
                ->assertSee('Rasa Nusantara');
        }
    }

    public function test_authenticated_pages_render_content(): void
    {
        $city = City::factory()->create();
        $user = User::factory()->unverified()->create(['role' => 'customer']);
        Customer::factory()->create(['user_id' => $user->id, 'city_id' => $city->id]);

        $this->actingAs($user)->get('/profile')
            ->assertOk()
            ->assertSee('Profil');

        $this->actingAs($user)->get('/confirm-password')
            ->assertOk()
            ->assertSee('Konfirmasi Password');

        $this->actingAs($user)->get('/verify-email')
            ->assertOk()
            ->assertSee('Verifikasi Email');

        $this->actingAs($user)->get('/checkout')
            ->assertOk()
            ->assertSee('Checkout')
            ->assertSee('delivery_address');

        $this->actingAs($user)->get('/pesanan-saya')
            ->assertOk()
            ->assertSee('Pesanan Saya');
    }

    public function test_admin_orders_page_renders_with_tailwind_assets(): void
    {
        $city = City::factory()->create();
        $category = Category::factory()->create();
        $payment = PaymentMethod::factory()->create();
        $courier = Courier::factory()->create();
        $customer = Customer::factory()->create(['city_id' => $city->id]);
        $menu = Menu::factory()->create(['category_id' => $category->id]);

        $order = Order::create([
            'customer_id' => $customer->id,
            'payment_method_id' => $payment->id,
            'courier_id' => $courier->id,
            'status' => 'pending',
            'delivery_address' => 'Jl. Uji 1',
        ]);

        $order->orderItems()->create([
            'menu_id' => $menu->id,
            'qty' => 2,
            'subtotal' => $menu->price * 2,
        ]);

        $admin = User::factory()->create(['role' => 'admin']);

        $this->actingAs($admin)->get('/orders')
            ->assertOk()
            ->assertSee('Pesanan Masuk')
            ->assertSee('min-w-[900px]', false)
            ->assertSee('.css');
    }
}
