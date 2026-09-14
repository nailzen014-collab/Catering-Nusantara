<?php

namespace App\Http\Controllers;

use App\Models\Menu;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\PaymentMethod;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class CustomerOrderController extends Controller
{
    public function index()
    {
        $customer = Auth::user()->customer;

        $orders = Order::with([
            'orderItems.menu.category',
            'paymentMethod',
            'courier',
        ])
            ->where('customer_id', $customer->id)
            ->latest()
            ->paginate(10);

        return view('customer.orders.index', compact('orders'));
    }

   public function create()
{
    $customer = Auth::user()->customer;

    $menus = Menu::with('category')
        ->orderBy('name')
        ->get();

    $paymentMethods = PaymentMethod::orderBy('id')->get();

    return view('customer.checkout', compact(
        'customer',
        'menus',
        'paymentMethods'
    ));
}

    public function loadMoreMenus(Request $request)
{
    $menus = Menu::with('category')
        ->orderBy('name')
        ->paginate(12, ['*'], 'page', $request->page ?? 1);

    return response()->json([
        'html' => view('customer.partials.menu-cards', compact('menus'))->render(),
        'hasMore' => $menus->hasMorePages(),
    ]);
}

    public function store(Request $request)
    {
        $customer = Auth::user()->customer;

        $request->validate([
            'qty' => ['required', 'array'],
            'qty.*' => ['nullable', 'integer', 'min:0', 'max:99'],
            'payment_method_id' => ['required', 'exists:payment_methods,id'],
            'payment_proof' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:2048'],
        ]);

        $selectedMenus = collect($request->qty)
            ->filter(fn ($qty) => (int) $qty > 0);

        if ($selectedMenus->isEmpty()) {
            return back()
                ->withInput()
                ->withErrors(['qty' => 'Pilih minimal satu menu.']);
        }

        $paymentMethod = PaymentMethod::findOrFail(
            $request->payment_method_id
        );

        $paymentName = strtolower($paymentMethod->name);

        $requiresProof = str_contains($paymentName, 'transfer')
            || str_contains($paymentName, 'qris');

        if ($requiresProof && !$request->hasFile('payment_proof')) {
            return back()
                ->withInput()
                ->withErrors([
                    'payment_proof' => 'Bukti pembayaran wajib diupload.'
                ]);
        }

        $paymentProof = null;

        if ($request->hasFile('payment_proof')) {
            $paymentProof = $request->file('payment_proof')
                ->store('payment-proofs', 'public');
        }

        DB::transaction(function () use (
            $selectedMenus,
            $customer,
            $request,
            $paymentProof
        ) {
            $menus = Menu::whereIn('id', $selectedMenus->keys())
                ->get()
                ->keyBy('id');

            $total = 0;

            foreach ($selectedMenus as $menuId => $qty) {
                if (!isset($menus[$menuId])) {
                    continue;
                }

                $total += $menus[$menuId]->price * (int) $qty;
            }

            $order = Order::create([
                'customer_id' => $customer->id,
                'payment_method_id' => $request->payment_method_id,
                'courier_id' => null,
                'status' => 'pending',
                'delivery_address' => $customer->address . ', ' . $customer->city->name,
                'payment_proof' => $paymentProof,
            ]);

            foreach ($selectedMenus as $menuId => $qty) {
                if (!isset($menus[$menuId])) {
                    continue;
                }

                $qty = (int) $qty;

                OrderItem::create([
                    'order_id' => $order->id,
                    'menu_id' => $menuId,
                    'qty' => $qty,
                    'subtotal' => $menus[$menuId]->price * $qty,
                ]);
            }
        });

        return redirect()
            ->route('pesanan-saya')
            ->with('success', 'Pesanan berhasil dibuat!');
    }

   public function checkout()
{
    $user = Auth::user();
    $customer = $user->customer;

    $addresses = $customer->addresses()
        ->with('city')
        ->get();

    $menus = Menu::with('category')
        ->orderBy('name')
        ->get();

    $paymentMethods = PaymentMethod::all();

    return view('customer.checkout', compact(
        'customer',
        'addresses',
        'menus',
        'paymentMethods'
    ));
}
}