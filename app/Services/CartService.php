<?php

namespace App\Services;

use App\Models\Cart;
use App\Models\CartItem;
use App\Models\Product;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class CartService
{
    public function getCart()
    {
        if (Auth::check()) {
            $cart = Cart::firstOrCreate(['user_id' => Auth::id()]);
        } else {
            $sessionId = Session::getId();
            $cart = Cart::firstOrCreate(['session_id' => $sessionId]);
        }
        return $cart->load('items.product');
    }

    public function addToCart($productId, $quantity = 1)
    {
        $cart = $this->getCart();
        $product = Product::findOrFail($productId);

        $cartItem = $cart->items()->where('product_id', $productId)->first();

        $currentQty = $cartItem ? $cartItem->quantity : 0;
        $desiredQty = $currentQty + $quantity;

        if ($desiredQty > $product->stock) {
            throw ValidationException::withMessages(['quantity' => "Cannot add more than available stock ({$product->stock})."]);
        }

        if ($cartItem) {
            $cartItem->update(['quantity' => $desiredQty]);
        } else {
            $cart->items()->create([
                'product_id' => $productId,
                'quantity' => $quantity
            ]);
        }

        return $cart;
    }

    public function updateQuantity($itemId, $quantity)
    {
        $cartItem = CartItem::findOrFail($itemId);
        $product = $cartItem->product;

        if ($quantity > $product->stock) {
            throw ValidationException::withMessages(['quantity' => "Requested quantity exceeds available stock ({$product->stock})."]);
        }

        $cartItem->update(['quantity' => $quantity]);
        return $cartItem;
    }

    public function removeItem($itemId)
    {
        return CartItem::destroy($itemId);
    }

    public function clearCart()
    {
        $cart = $this->getCart();
        $cart->items()->delete();
    }
}
