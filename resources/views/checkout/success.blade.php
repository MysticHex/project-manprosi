<x-store-layout>
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12 text-center">
        <div class="bg-white rounded-lg shadow-sm p-12 max-w-2xl mx-auto">
            <div class="w-16 h-16 bg-green-100 rounded-full flex items-center justify-center mx-auto mb-6">
                <svg class="w-8 h-8 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
            </div>
            <h1 class="text-3xl font-bold text-gray-900 mb-4">Order Placed Successfully!</h1>
            <p class="text-gray-600 mb-8">Thank you for your purchase. Your order ID is #{{ $id }}. We will email you the order details shortly.</p>
            <a href="{{ route('home') }}" class="inline-block bg-green-600 text-white px-8 py-3 rounded-md font-semibold hover:bg-green-700 transition-colors">
                Continue Shopping
            </a>
        </div>
    </div>
</x-store-layout>
