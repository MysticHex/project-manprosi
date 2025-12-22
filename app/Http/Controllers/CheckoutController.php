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
        $baseRules = [
            'address' => 'required|string',
            'payment_method' => 'required|string',
        ];

        // If API client sends a cart payload, validate its structure
        if ($request->has('cart')) {
            $request->validate(array_merge($baseRules, [
                'cart' => 'required|array|min:1',
                'cart.*.product_id' => 'required|exists:products,id',
                'cart.*.quantity' => 'integer|min:1'
            ]));

            $order = $this->orderService->createOrderFromItems(Auth::user(), $request->input('cart'), $request->all());
        } else {
            $request->validate($baseRules);
            $cart = $this->cartService->getCart();
            $order = $this->orderService->createOrder(Auth::user(), $cart, $request->all());
        }

        if ($request->expectsJson()) {
            if ($request->input('payment_method') === 'bank_transfer') {
                return response()->json([
                    'order' => $order,
                    'redirect' => route('checkout.bank.show', $order->id)
                ], 201);
            }

            return response()->json([
                'order' => $order,
                'redirect' => route('orders.success', $order->id)
            ], 201);
        }

        if ($request->input('payment_method') === 'bank_transfer') {
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
