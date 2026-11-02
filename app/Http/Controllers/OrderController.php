<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function index()
    {
        $orders = Order::with([
            'customer.city',
            'orderItems.menu.category',
            'paymentMethod',
            'courier',
        ])->latest()->paginate(15);

        return view('orders.index', compact('orders'));
    }

    public function updateStatus(Request $request, Order $order)
    {
        $request->validate([
            'status' => [
                'required',
                'in:pending,waiting_verification,processing,delivered,completed,cancelled'
            ],
        ]);

        $order->update([
            'status' => $request->status,
        ]);

        return back()->with(
            'success',
            'Status pesanan berhasil diperbarui.'
        );
    }
}