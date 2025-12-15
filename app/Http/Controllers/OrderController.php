<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{
    // List authenticated user's orders
    public function index()
    {
        $orders = Order::where('user_id', Auth::id())->latest()->paginate(10);
        return view('orders.index', compact('orders'));
    }

    // Show order tracking/progress for a single order
    public function track(Order $order)
    {
        // ensure the order belongs to the authenticated user
        if ($order->user_id !== Auth::id()) {
            abort(403);
        }

        // possible statuses in order
        $steps = ['pending', 'paid', 'processing', 'shipped', 'delivered'];

        return view('orders.track', compact('order', 'steps'));
    }

    // Cancel an order from user history (only when pending)
    public function cancel(Order $order)
    {
        if ($order->user_id !== Auth::id()) {
            abort(403);
        }

        if ($order->status !== 'pending') {
            return back()->with('error', 'Hanya pesanan dengan status pending yang dapat dibatalkan.');
        }

        $order->status = 'cancelled';
        $order->save();

        return back()->with('success', 'Pesanan dibatalkan.');
    }
}
