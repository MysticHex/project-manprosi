@props(['product'])

<div class="bg-white rounded-lg shadow-sm hover:shadow-md transition-shadow duration-200 overflow-hidden border border-gray-100">
    <a href="{{ route('products.show', $product->slug) }}">
        <div class="aspect-w-1 aspect-h-1 w-full overflow-hidden bg-gray-200 xl:aspect-w-7 xl:aspect-h-8">
            @if($product->images->first())
                <img src="{{ asset('storage/' . $product->images->first()->image_path) }}" alt="{{ $product->name }}" class="h-48 w-full object-cover object-center group-hover:opacity-75">
            @else
                <img src="https://via.placeholder.com/300" alt="{{ $product->name }}" class="h-48 w-full object-cover object-center group-hover:opacity-75">
            @endif
        </div>
    </a>
    <div class="p-4">
        <p class="text-sm text-gray-500 mb-1">{{ $product->category->name ?? 'Category' }}</p>
        <h3 class="text-lg font-medium text-gray-900 truncate">
            <a href="{{ route('products.show', $product->slug) }}">
                {{ $product->name }}
            </a>
        </h3>
        <div class="flex items-center mt-2 mb-4">
            <div class="flex text-yellow-400 text-sm">
                @for($i = 0; $i < 5; $i++)
                    <svg class="w-4 h-4 fill-current" viewBox="0 0 20 20"><path d="M10 15l-5.878 3.09 1.123-6.545L.489 6.91l6.572-.955L10 0l2.939 5.955 6.572.955-4.756 4.635 1.123 6.545z"/></svg>
                @endfor
            </div>
            <span class="text-xs text-gray-500 ml-2">(4.5)</span>
        </div>
        <div class="flex items-center justify-between">
            <span class="text-xl font-bold text-gray-900">Rp {{ number_format($product->price, 0, ',', '.') }}</span>
            <form action="{{ route('cart.store') }}" method="POST">
                @csrf
                <input type="hidden" name="product_id" value="{{ $product->id }}">
                <button type="submit" class="p-2 rounded-full bg-green-100 text-green-600 hover:bg-green-200 transition-colors">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path></svg>
                </button>
            </form>
        </div>
    </div>
</div>
