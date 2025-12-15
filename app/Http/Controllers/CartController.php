<?php

namespace App\Http\Controllers;

use App\Services\CartService;
use App\Models\Product;
use App\Models\CartItem;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class CartController extends Controller
{
    protected $cartService;

    public function __construct(CartService $cartService)
    {
        $this->cartService = $cartService;
    }

    public function index()
    {
        $cart = $this->cartService->getCart();
        return view('cart.index', compact('cart'));
    }

    public function store(Request $request)
    {
        if (!auth()->check()) {
            return redirect()->route('login')->with('error', 'Please login to add items to your cart.');
        }

        $request->validate([
            'product_id' => 'required|exists:products,id',
            'quantity' => 'integer|min:1'
        ]);

        try {
            $this->cartService->addToCart($request->product_id, $request->quantity ?? 1);
            return redirect()->back()->with('success', 'Product added to cart!');
        } catch (ValidationException $e) {
            $product = Product::find($request->product_id);
            $cart = $this->cartService->getCart();
            $cartItem = $cart->items()->where('product_id', $product->id)->first();

            if ($product && $product->stock > 0) {
                if ($cartItem) {
                    $cartItem->update(['quantity' => $product->stock]);
                } else {
                    $cart->items()->create(['product_id' => $product->id, 'quantity' => $product->stock]);
                }
                return redirect()->back()->with('success', "Requested quantity exceeds stock — set to max available ({$product->stock}).");
            }

            return redirect()->back()->with('error', 'Product is out of stock.');
        }
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'quantity' => 'required|integer|min:1'
        ]);

        try {
            $this->cartService->updateQuantity($id, $request->quantity);
            return redirect()->route('cart.index')->with('success', 'Cart updated!');
        } catch (ValidationException $e) {
            $cartItem = CartItem::findOrFail($id);
            $product = $cartItem->product;
            if ($product && $product->stock > 0) {
                $cartItem->update(['quantity' => $product->stock]);
                return redirect()->route('cart.index')->with('success', "Requested quantity exceeds stock — set to max available ({$product->stock}).");
            }
            return redirect()->route('cart.index')->with('error', 'Product is out of stock.');
        }
    }

    public function destroy($id)
    {
        $this->cartService->removeItem($id);
        return redirect()->route('cart.index')->with('success', 'Item removed!');
    }
}
