<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    {{ __("You're logged in!") }}
                </div>
                @if(isset($adminStats) && $adminStats)
                    <div class="p-6 border-t">
                        <h3 class="text-lg font-bold mb-4">Admin Overview</h3>
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                            <div class="bg-white border rounded p-4">
                                <div class="text-sm text-gray-500">Total Products</div>
                                <div class="text-2xl font-bold">{{ $adminStats['total_products'] }}</div>
                            </div>
                            <div class="bg-white border rounded p-4">
                                <div class="text-sm text-gray-500">Pending Orders</div>
                                <div class="text-2xl font-bold">{{ $adminStats['pending_orders'] }}</div>
                            </div>
                            <div class="bg-white border rounded p-4">
                                <div class="text-sm text-gray-500">Recent Orders</div>
                                <div class="space-y-2 mt-2">
                                    @foreach($adminStats['recent_orders'] as $ro)
                                        <div class="text-sm">
                                            <a href="{{ route('admin.orders.show', $ro->id) }}" class="text-blue-600">{{ $ro->order_number }}</a>
                                            — {{ $ro->user->name }} ({{ ucfirst($ro->status) }})
                                        </div>
                                    @endforeach
                                </div>
                                <div class="mt-4 flex gap-2">
                                    <a href="{{ route('admin.products.index') }}" class="inline-block bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded">Manage Products</a>
                                    <a href="{{ route('admin.orders.index') }}" class="inline-block bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded">Manage Orders</a>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>
