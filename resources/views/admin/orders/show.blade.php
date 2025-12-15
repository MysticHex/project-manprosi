<x-store-layout>
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
        <div class="flex justify-between items-center mb-8">
            <h1 class="text-3xl font-bold text-gray-900">Order #{{ $order->id }}</h1>
            <a href="{{ route('admin.orders.index') }}" class="text-gray-600 hover:text-gray-900">Back to Orders</a>
        </div>

        @if(session('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
                <span class="block sm:inline">{{ session('success') }}</span>
            </div>
        @endif

        @if(session('error'))
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4" role="alert">
                <span class="block sm:inline">{{ session('error') }}</span>
            </div>
        @endif

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <div class="lg:col-span-2">
                <div class="bg-white shadow overflow-hidden sm:rounded-lg mb-6">
                    <div class="px-4 py-5 sm:px-6">
                        <h3 class="text-lg leading-6 font-medium text-gray-900">Order Items</h3>
                    </div>
                    <div class="border-t border-gray-200">
                        <ul class="divide-y divide-gray-200">
                            @foreach($order->items as $item)
                                <li class="px-4 py-4 sm:px-6 flex items-center">
                                    <div class="flex-1">
                                        <div class="flex justify-between">
                                            <p class="text-sm font-medium text-indigo-600 truncate">{{ $item->product->name }}</p>
                                            <p class="text-sm text-gray-500">Rp {{ number_format($item->price, 0, ',', '.') }}</p>
                                        </div>
                                        <div class="flex justify-between">
                                            <p class="text-sm text-gray-500">Qty: {{ $item->quantity }}</p>
                                            <p class="text-sm text-gray-900 font-semibold">Rp {{ number_format($item->price * $item->quantity, 0, ',', '.') }}</p>
                                        </div>
                                    </div>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>

            <div class="lg:col-span-1">
                <div class="bg-white shadow overflow-hidden sm:rounded-lg p-6">
                    <h3 class="text-lg font-medium text-gray-900 mb-4">Order Details</h3>
                    <dl class="grid grid-cols-1 gap-x-4 gap-y-6 sm:grid-cols-2">
                        <div class="sm:col-span-2">
                            <dt class="text-sm font-medium text-gray-500">Customer</dt>
                            <dd class="mt-1 text-sm text-gray-900">{{ $order->user->name }} ({{ $order->user->email }})</dd>
                        </div>
                        <div class="sm:col-span-2">
                            <dt class="text-sm font-medium text-gray-500">Shipping Address</dt>
                            @if(is_array($order->shipping_address))
                                <dd class="mt-1 text-sm text-gray-900">{!! nl2br(e($order->shipping_address['address'] ?? json_encode($order->shipping_address))) !!}</dd>
                            @else
                                <dd class="mt-1 text-sm text-gray-900">{{ $order->shipping_address }}</dd>
                            @endif
                        </div>
                        <div class="sm:col-span-2">
                            <dt class="text-sm font-medium text-gray-500">Payment Method</dt>
                            <dd class="mt-1 text-sm text-gray-900">{{ $order->payment_method ? ucfirst($order->payment_method) : 'Not specified' }}</dd>
                        </div>
                        <div class="sm:col-span-2">
                            <dt class="text-sm font-medium text-gray-500">Total Amount</dt>
                            <dd class="mt-1 text-2xl font-bold text-green-600">Rp {{ number_format($order->total, 0, ',', '.') }}</dd>
                        </div>
                    </dl>

                    <hr class="my-6">

                    <h3 class="text-lg font-medium text-gray-900 mb-4">Update Status</h3>
                    <form action="{{ route('admin.orders.update-status', $order->id) }}" method="POST">
                        @csrf
                        @method('PATCH')
                        <div class="mb-4">
                            <select name="status" class="mt-1 block w-full pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm rounded-md">
                                <option value="pending" {{ $order->status === 'pending' ? 'selected' : '' }}>Pending</option>
                                <option value="paid" {{ $order->status === 'paid' ? 'selected' : '' }}>Paid (Confirm Payment)</option>
                                <option value="shipped" {{ $order->status === 'shipped' ? 'selected' : '' }}>Shipped</option>
                                <option value="delivered" {{ $order->status === 'delivered' ? 'selected' : '' }}>Delivered</option>
                                <option value="cancelled" {{ $order->status === 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                            </select>
                        </div>
                        <button type="submit" class="w-full bg-indigo-600 text-white px-4 py-2 rounded-md hover:bg-indigo-700">Update Status</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-store-layout>
