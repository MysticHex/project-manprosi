@extends('layouts.app')

@section('content')
<div class="max-w-3xl mx-auto py-8">
    <h1 class="text-2xl font-bold mb-6">Track Order <span class="text-indigo-600">{{ $order->order_number }}</span></h1>

    <div class="bg-white rounded-lg shadow p-6">
        <div class="mb-4">
            <div class="text-sm text-gray-600">Placed: {{ $order->created_at->format('d M Y H:i') }}</div>
            <div class="text-sm text-gray-600">Total: Rp {{ number_format($order->total, 0, ',', '.') }}</div>
        </div>

        <div class="mb-6">
            <h3 class="font-semibold mb-2">Shipping Address</h3>
            <div class="text-sm text-gray-700">{{ is_array($order->shipping_address) ? ($order->shipping_address['address'] ?? json_encode($order->shipping_address)) : $order->shipping_address }}</div>
        </div>

        <div>
            <h3 class="font-semibold mb-2">Progress</h3>
            <div class="space-y-3">
                @foreach($steps as $step)
                    @php $active = array_search($step, $steps) <= array_search($order->status, $steps); @endphp
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
    </div>
</div>
@endsection
