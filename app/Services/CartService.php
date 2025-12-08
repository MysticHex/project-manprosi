<?php

namespace App\Services;

use App\Models\Cart;
use App\Models\CartItem;
use App\Models\Product;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Auth;

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

        if ($cartItem) {
            $cartItem->increment('quantity', $quantity);
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
