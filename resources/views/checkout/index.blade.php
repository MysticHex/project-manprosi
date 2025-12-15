<x-store-layout>
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
        <h1 class="text-3xl font-bold text-gray-900 mb-8">Checkout</h1>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <div class="lg:col-span-2">
                <form action="{{ route('checkout.store') }}" method="POST" id="checkout-form">
                    @csrf
                    <div class="bg-white rounded-lg shadow-sm p-6 mb-6">
                        <h2 class="text-lg font-medium text-gray-900 mb-4">Shipping Information</h2>
                        <div class="grid grid-cols-1 gap-6">
                            <div>
                                <label for="address" class="block text-sm font-medium text-gray-700">Full Address</label>
                                <textarea name="address" id="address" rows="3" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-green-500 focus:ring-green-500" required></textarea>
                            </div>
                        </div>
                    </div>

                    <div class="bg-white rounded-lg shadow-sm p-6 mb-6">
                        <h2 class="text-lg font-medium text-gray-900 mb-4">Payment Method</h2>
                        <div class="space-y-4">
                            <div class="flex items-center">
                                <input id="cod" name="payment_method" type="radio" value="cod" class="focus:ring-green-500 h-4 w-4 text-green-600 border-gray-300" checked>
                                <label for="cod" class="ml-3 block text-sm font-medium text-gray-700">
                                    Cash on Delivery
                                </label>
                            </div>
                            <div class="flex items-center">
                                <input id="bank" name="payment_method" type="radio" value="bank_transfer" class="focus:ring-green-500 h-4 w-4 text-green-600 border-gray-300">
                                <label for="bank" class="ml-3 block text-sm font-medium text-gray-700">
                                    Bank Transfer
                                </label>
                            </div>
                        </div>
                    </div>
                </form>
            </div>

            <div class="lg:col-span-1">
                <div class="bg-white rounded-lg shadow-sm p-6">
                    <h2 class="text-lg font-medium text-gray-900 mb-4">Order Summary</h2>
                    <div class="space-y-4 mb-6">
                        @foreach($cart->items as $item)
                            <div class="flex justify-between text-sm">
                                <div>
                                    <div class="text-gray-600">{{ $item->product->name }} x {{ $item->quantity }}</div>
                                    <div class="text-xs text-gray-500 mt-1">Stok: {{ $item->product->stock }}</div>
                                </div>
                                <span class="font-medium text-gray-900">Rp {{ number_format($item->product->price * $item->quantity, 0, ',', '.') }}</span>
                            </div>
                        @endforeach
                    </div>
                    <div class="border-t border-gray-200 pt-4 mb-6">
                        <div class="flex justify-between">
                            <span class="text-lg font-bold text-gray-900">Total</span>
                            <span class="text-lg font-bold text-gray-900">Rp {{ number_format($cart->items->sum(fn($item) => $item->product->price * $item->quantity) + ($shippingCost ?? 15000), 0, ',', '.') }}</span>
                        </div>
                    </div>
                    <button type="submit" form="checkout-form" class="block w-full bg-green-600 text-white text-center px-4 py-3 rounded-md font-semibold hover:bg-green-700 transition-colors">
                        Place Order
                    </button>
                </div>
            </div>
        </div>
    </div>
</x-store-layout>
