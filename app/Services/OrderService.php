<?php

namespace App\Services;

use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class OrderService
{
    const SHIPPING_COST = 15000; // Flat rate shipping

    public function createOrder($user, $cart, $data)
    {
        return DB::transaction(function () use ($user, $cart, $data) {
            $subtotal = $cart->items->sum(fn($item) => $item->product->price * $item->quantity);
            $totalPrice = $subtotal + self::SHIPPING_COST;

            // generate a unique order number
            $orderNumber = 'ORD-' . now()->format('YmdHis') . '-' . random_int(1000, 9999);

            $order = Order::create([
                'user_id' => $user->id,
                'order_number' => $orderNumber,
                'total' => $totalPrice,
                'status' => 'pending',
                'shipping_address' => ['address' => $data['address']],
                'payment_method' => $data['payment_method'] ?? null,
            ]);

            foreach ($cart->items as $item) {
                OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $item->product_id,
                    'quantity' => $item->quantity,
                    'price' => $item->product->price,
                ]);
            }

            $cart->items()->delete();

            return $order;
        });
    }

    public function confirmPayment(Order $order)
    {
        return DB::transaction(function () use ($order) {
            // Only decrease stock if not already paid/processed
            if ($order->status === 'pending') {
                foreach ($order->items as $item) {
                    $product = $item->product;
                    if ($product->stock >= $item->quantity) {
                        $product->decrement('stock', $item->quantity);
                    } else {
                        throw new \Exception("Insufficient stock for product: {$product->name}");
                    }
                }
                
                $order->update(['status' => 'paid']);
            }
            return $order;
        });
    }
}
