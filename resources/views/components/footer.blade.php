<footer class="bg-gray-800 text-white pt-12 pb-8">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 md:grid-cols-4 gap-8">
            <div>
                <h3 class="text-xl font-bold mb-4">DapurNurasa</h3>
                <p class="text-gray-400 text-sm">Fresh groceries delivered to your doorstep.</p>
            </div>
            <div>
                <h4 class="font-semibold mb-4">Quick Links</h4>
                <ul class="space-y-2 text-sm text-gray-400">
                    <li><a href="#" class="hover:text-white">About Us</a></li>
                    <li><a href="#" class="hover:text-white">Contact</a></li>
                    <li><a href="#" class="hover:text-white">Terms & Conditions</a></li>
                </ul>
            </div>
            <div>
                <h4 class="font-semibold mb-4">Categories</h4>
                <ul class="space-y-2 text-sm text-gray-400">
                    @if(isset($categories) && $categories->count())
                        @foreach($categories as $category)
                            <li>
                                <a href="{{ url('categories/' . ($category->slug ?? $category->id)) }}" class="hover:text-white">{{ $category->name }}</a>
                            </li>
                        @endforeach
                    @else
                        <li><a href="#" class="hover:text-white">Vegetables</a></li>
                        <li><a href="#" class="hover:text-white">Fruits</a></li>
                        <li><a href="#" class="hover:text-white">Meat</a></li>
                    @endif
                </ul>
            </div>
            <div>
                <h4 class="font-semibold mb-4">Newsletter</h4>
                <div class="flex">
                    <input type="email" placeholder="Enter your email" class="px-4 py-2 rounded-l-md w-full text-gray-900 focus:outline-none">
                    <button class="bg-green-600 px-4 py-2 rounded-r-md hover:bg-green-700">Subscribe</button>
                </div>
            </div>
        </div>
        <div class="border-t border-gray-700 mt-8 pt-8 text-center text-sm text-gray-400">
            &copy; {{ date('Y') }} DapurNurasa. All rights reserved.
        </div>
    </div>
</footer>
