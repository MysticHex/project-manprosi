<x-store-layout>
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
        <div class="bg-white rounded-2xl shadow-sm overflow-hidden">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-8 p-8">
                <div class="aspect-w-1 aspect-h-1 bg-gray-200 rounded-lg overflow-hidden">
                    <img src="https://via.placeholder.com/600" alt="{{ $product->name }}" class="w-full h-full object-center object-cover">
                </div>
                <div class="flex flex-col justify-center">
                    <h1 class="text-3xl font-bold text-gray-900 mb-4">{{ $product->name }}</h1>
                    <div class="flex items-center mb-4">
                        <div class="flex text-yellow-400">
                            @for($i = 0; $i < 5; $i++)
                                <svg class="w-5 h-5 fill-current" viewBox="0 0 20 20"><path d="M10 15l-5.878 3.09 1.123-6.545L.489 6.91l6.572-.955L10 0l2.939 5.955 6.572.955-4.756 4.635 1.123 6.545z"/></svg>
                            @endfor
                        </div>
                        <span class="text-gray-500 ml-2">(120 reviews)</span>
                    </div>
                    <p class="text-2xl font-bold text-green-600 mb-6">Rp {{ number_format($product->price, 0, ',', '.') }}</p>
                    <p class="text-gray-600 mb-8">{{ $product->description }}</p>
                    
                    <form action="{{ route('cart.store') }}" method="POST" class="flex items-center space-x-4">
                        @csrf
                        <input type="hidden" name="product_id" value="{{ $product->id }}">
                        <div class="flex items-center border border-gray-300 rounded-md">
                            <button type="button" onclick="decrement()" class="px-4 py-2 text-gray-600 hover:bg-gray-100">-</button>
                            <input type="number" name="quantity" id="quantity" value="1" min="1" class="w-16 text-center border-none focus:ring-0">
                            <button type="button" onclick="increment()" class="px-4 py-2 text-gray-600 hover:bg-gray-100">+</button>
                        </div>
                        <button type="submit" class="flex-1 bg-green-600 text-white px-8 py-3 rounded-md font-semibold hover:bg-green-700 transition-colors">
                            Add to Cart
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        function increment() {
            const input = document.getElementById('quantity');
            input.value = parseInt(input.value) + 1;
        }
        function decrement() {
            const input = document.getElementById('quantity');
            if (parseInt(input.value) > 1) {
                input.value = parseInt(input.value) - 1;
            }
        }
    </script>
</x-store-layout>
