@extends('layouts.app')

@section('content')
<div class="max-w-3xl mx-auto py-8">
    <h1 class="text-2xl font-bold mb-6">Track Order <span class="text-indigo-600">{{ $order->order_number }}</span></h1>

    <div class="bg-white rounded-lg shadow p-6">
        @php
            $status = strtolower($order->status);
            if ($status === 'cancelled') {
                $statusClass = 'text-red-700 bg-red-100';
            } elseif (in_array($status, ['paid','processing','shipped','delivered'])) {
                $statusClass = 'text-green-700 bg-green-100';
            } elseif ($status === 'pending') {
                $statusClass = 'text-yellow-700 bg-yellow-100';
            } else {
                $statusClass = 'text-gray-600 bg-gray-100';
            }
        @endphp

        <div class="mb-4 flex items-center justify-between">
            <div>
                <div class="text-sm text-gray-600">Placed: {{ $order->created_at->format('d M Y H:i') }}</div>
                <div class="text-sm text-gray-600">Total: Rp {{ number_format($order->total, 0, ',', '.') }}</div>
            </div>
            <div>
                <span class="px-3 py-1 rounded text-sm {{ $statusClass }}">{{ ucfirst($order->status) }}</span>
            </div>
        </div>

        <div class="mb-6">
            <h3 class="font-semibold mb-2">Shipping Address</h3>
            <div class="text-sm text-gray-700">{{ is_array($order->shipping_address) ? ($order->shipping_address['address'] ?? json_encode($order->shipping_address)) : $order->shipping_address }}</div>
        </div>

        @if(strtolower($order->status) === 'cancelled')
            <div class="mb-6">
                <div class="p-4 rounded bg-red-50 border border-red-100 text-red-700 font-semibold">Pesanan dibatalkan</div>
            </div>
            <div>
                <h3 class="font-semibold mb-2">Progress</h3>
                <div class="space-y-3 opacity-60">
                    @foreach($steps as $step)
                        @php $active = false; @endphp
                        <div class="flex items-center">
                            <div class="h-8 w-8 rounded-full flex items-center justify-center mr-3 bg-gray-200 text-gray-600">{{ ucfirst(substr($step,0,1)) }}</div>
                            <div>
                                <div class="font-medium">{{ ucfirst($step) }}</div>
                                <div class="text-xs text-gray-400">Cancelled</div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        @else
            <div>
                <h3 class="font-semibold mb-2">Progress</h3>
                <div class="space-y-3">
                    @foreach($steps as $step)
                        @php
                            if (in_array($order->status, $steps)) {
                                $active = array_search($step, $steps) <= array_search($order->status, $steps);
                            } else {
                                $active = false;
                            }
                        @endphp
                        <div class="flex items-center">
                            <div class="h-8 w-8 rounded-full flex items-center justify-center mr-3 {{ $active ? 'bg-green-600 text-white' : 'bg-gray-200 text-gray-600' }}">{{ ucfirst(substr($step,0,1)) }}</div>
                            <div>
                                <div class="font-medium">{{ ucfirst($step) }}</div>
                                @if($active)
                                    <div class="text-xs text-gray-500">Completed</div>
                                @else
                                    <div class="text-xs text-gray-400">Pending</div>
                                @endif
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        @endif
    </div>
</div>
@endsection
