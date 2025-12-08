<x-store-layout>
    <!-- Hero Section -->
    <div class="bg-green-50 py-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <div class="md:col-span-2 bg-green-600 rounded-2xl p-8 text-white h-96 flex flex-col justify-center relative overflow-hidden">
                    <div class="relative z-10">
                        <h1 class="text-4xl font-bold mb-4">Fresh Groceries<br>Delivered Daily</h1>
                        <p class="mb-6 text-green-100">Get the best quality products from local farmers.</p>
                        <a href="{{ route('products.index') }}" class="inline-block bg-white text-green-600 px-6 py-3 rounded-full font-semibold hover:bg-green-50 transition-colors">Shop Now</a>
                    </div>
                    <!-- Decorative circle -->
                    <div class="absolute -right-20 -bottom-40 w-80 h-80 bg-green-500 rounded-full opacity-50"></div>
                </div>
                <div class="space-y-6">
                    <div class="bg-orange-100 rounded-2xl p-6 h-44 flex flex-col justify-center">
                        <h3 class="text-xl font-bold text-orange-800 mb-2">Fresh Fruits</h3>
                        <a href="#" class="text-orange-600 font-medium hover:underline">View Collection &rarr;</a>
                    </div>
                    <div class="bg-blue-100 rounded-2xl p-6 h-44 flex flex-col justify-center">
                        <h3 class="text-xl font-bold text-blue-800 mb-2">Daily Essentials</h3>
                        <a href="#" class="text-blue-600 font-medium hover:underline">View Collection &rarr;</a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Trending Products -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
        <div class="flex justify-between items-center mb-8">
            <h2 class="text-2xl font-bold text-gray-900">Trending Products</h2>
            <a href="{{ route('products.index') }}" class="text-green-600 hover:text-green-700 font-medium">View All</a>
        </div>
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
            @foreach($trendingProducts as $product)
                <x-product-card :product="$product" />
            @endforeach
        </div>
    </div>

    <!-- Best Sellers -->
    <div class="bg-white py-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center mb-8">
                <h2 class="text-2xl font-bold text-gray-900">Best Sellers</h2>
                <a href="{{ route('products.index') }}" class="text-green-600 hover:text-green-700 font-medium">View All</a>
            </div>
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
                @foreach($bestSellers as $product)
                    <x-product-card :product="$product" />
                @endforeach
            </div>
        </div>
    </div>
</x-store-layout>
