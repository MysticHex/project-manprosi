<nav class="bg-white shadow-sm sticky top-0 z-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <div class="flex items-center">
                <a href="{{ route('home') }}" class="flex-shrink-0 flex items-center">
                    <span class="text-2xl font-bold text-green-600">DapurNurasa</span>
                </a>
                <div class="hidden sm:ml-6 sm:flex sm:space-x-8">
                    <a href="{{ route('home') }}" class="border-transparent text-gray-500 hover:border-green-500 hover:text-gray-700 inline-flex items-center px-1 pt-1 border-b-2 text-sm font-medium">
                        Home
                    </a>
                    <a href="{{ route('products.index') }}" class="border-transparent text-gray-500 hover:border-green-500 hover:text-gray-700 inline-flex items-center px-1 pt-1 border-b-2 text-sm font-medium">
                        Shop
                    </a>
                    <a href="#" class="border-transparent text-gray-500 hover:border-green-500 hover:text-gray-700 inline-flex items-center px-1 pt-1 border-b-2 text-sm font-medium">
                        Blog
                    </a>
                </div>
            </div>
            <div class="flex items-center space-x-4">
                <div class="relative">
                    <form action="{{ route('products.index') }}" method="GET">
                        <div class="relative">
                            <input name="search" type="search" placeholder="Search products..." value="{{ request('search') }}" class="w-64 pl-10 pr-4 py-2 rounded-full border border-gray-300 focus:outline-none focus:border-green-500 focus:ring-1 focus:ring-green-500">
                            <button type="submit" class="absolute left-3 top-2.5 text-gray-400">
                                <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                            </button>
                        </div>
                    </form>
                </div>
                
                @auth
                    <a href="{{ route('cart.index') }}" class="text-gray-500 hover:text-green-600 relative">
                        <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                        @if(auth()->user()->cart && auth()->user()->cart->items->count() > 0)
                            <span class="absolute -top-2 -right-2 bg-red-500 text-white text-xs rounded-full h-5 w-5 flex items-center justify-center">
                                {{ auth()->user()->cart->items->count() }}
                            </span>
                        @endif
                    </a>

                    <div class="relative ml-3">
                        <div class="flex items-center space-x-2">
                            @if(!auth()->user()->isAdmin())
                                <a href="{{ route('orders.index') }}" class="text-sm text-gray-600 hover:text-green-600">My Orders</a>
                            @endif
                            @if(auth()->user()->isAdmin())
                                <div class="relative inline-block text-left">
                                    <button id="admin-menu-button" type="button" class="text-sm text-gray-600 hover:text-green-600 focus:outline-none">Admin</button>
                                    <div id="admin-menu" class="origin-top-right absolute right-0 mt-2 w-48 rounded-md shadow-lg bg-white ring-1 ring-black ring-opacity-5 hidden">
                                        <div class="py-1">
                                            <a href="{{ route('admin.products.index') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Manage Products</a>
                                            <a href="{{ route('admin.categories.index') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Manage Categories</a>
                                            <a href="{{ route('admin.orders.index') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Manage Orders</a>
                                        </div>
                                    </div>
                                </div>
                            @endif
                            <div class="relative">
                                <button id="user-menu-button" type="button" class="flex items-center text-gray-600 hover:text-green-600 focus:outline-none">
                                    <span class="sr-only">Open user menu</span>
                                    <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                                </button>
                                <div id="user-menu" class="origin-top-right absolute right-0 mt-2 w-48 rounded-md shadow-lg bg-white ring-1 ring-black ring-opacity-5 hidden">
                                    <div class="py-1" role="menu" aria-orientation="vertical" aria-labelledby="user-menu-button">
                                        <a href="{{ route('profile.edit') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Profile</a>
                                        @if(!auth()->user()->isAdmin())
                                            <a href="{{ route('orders.index') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Order History</a>
                                        @endif
                                        <form method="POST" action="{{ route('logout') }}">
                                            @csrf
                                            <button type="submit" class="w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Logout</button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @else
                    <a href="{{ route('login') }}" class="text-sm font-medium text-gray-500 hover:text-green-600">Log in</a>
                    <a href="{{ route('register') }}" class="ml-4 text-sm font-medium text-white bg-green-600 hover:bg-green-700 px-4 py-2 rounded-md">Register</a>
                @endauth
            </div>
        </div>
    </div>
</nav>
<script>
    (function(){
        const btn = document.getElementById('user-menu-button');
        const menu = document.getElementById('user-menu');
        if (!btn || !menu) return;
        btn.addEventListener('click', function(e){
            e.preventDefault();
            menu.classList.toggle('hidden');
        });
        document.addEventListener('click', function(e){
            if (!btn.contains(e.target) && !menu.contains(e.target)) {
                if (!menu.classList.contains('hidden')) menu.classList.add('hidden');
            }
        });
    })();
</script>
<script>
    (function(){
        const btn = document.getElementById('admin-menu-button');
        const menu = document.getElementById('admin-menu');
        if (!btn || !menu) return;
        btn.addEventListener('click', function(e){
            e.preventDefault();
            menu.classList.toggle('hidden');
        });
        document.addEventListener('click', function(e){
            if (btn && menu && !btn.contains(e.target) && !menu.contains(e.target)) {
                if (!menu.classList.contains('hidden')) menu.classList.add('hidden');
            }
        });
    })();
</script>
