<?php

namespace App\Http\Controllers;

use App\Services\CartService;
use App\Services\OrderService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CheckoutController extends Controller
{
    protected $cartService;
    protected $orderService;

    public function __construct(CartService $cartService, OrderService $orderService)
    {
        $this->cartService = $cartService;
        $this->orderService = $orderService;
    }

    public function index()
    {
        $cart = $this->cartService->getCart();
        if ($cart->items->isEmpty()) {
            return redirect()->route('cart.index');
        }
        $shippingCost = OrderService::SHIPPING_COST;
        return view('checkout.index', compact('cart', 'shippingCost'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'address' => 'required|string',
            'payment_method' => 'required|string',
        ]);

        $cart = $this->cartService->getCart();
        $order = $this->orderService->createOrder(Auth::user(), $cart, $request->all());

        if ($request->input('payment_method') === 'bank_transfer') {
            // redirect user to bank transfer page to show QRIS and upload proof
            return redirect()->route('checkout.bank.show', $order->id);
        }

        return redirect()->route('orders.success', $order->id);
    }

    public function bankShow($orderId)
    {
        $order = \App\Models\Order::findOrFail($orderId);
        return view('checkout.bank', compact('order'));
    }

    public function uploadProof(Request $request, $orderId)
    {
        $request->validate([
            'payment_proof' => 'required|image|max:5120',
        ]);

        $order = \App\Models\Order::findOrFail($orderId);
        $path = $request->file('payment_proof')->store('payments', 'public');
        $order->update(['payment_proof' => $path, 'status' => 'pending']);

        return redirect()->route('checkout.bank.show', $order->id)->with('success', 'Payment proof uploaded. Preview below and confirm.');
    }

    public function confirmUpload(Request $request, $orderId)
    {
        $order = \App\Models\Order::findOrFail($orderId);
        // Keep status as pending; admins will mark as paid after verification.
        return redirect()->route('orders.success', $order->id)->with('success', 'Payment proof confirmed — awaiting verification.');
    }
    
    public function success($id)
    {
        return view('checkout.success', compact('id'));
    }
}
