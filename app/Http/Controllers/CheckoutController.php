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

        return redirect()->route('orders.success', $order->id);
    }
    
    public function success($id)
    {
        return view('checkout.success', compact('id'));
    }
}
