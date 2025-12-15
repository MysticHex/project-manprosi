@extends('layouts.app')

@section('content')
<div class="max-w-4xl mx-auto py-8">
    <h1 class="text-2xl font-bold mb-6">My Orders</h1>

    @if($orders->isEmpty())
        <div class="bg-yellow-50 border-l-4 border-yellow-400 p-4">You have no orders yet.</div>
    @else
        <div class="space-y-4">
            @foreach($orders as $order)
                <div class="border rounded p-4 flex justify-between items-center">
                    <div>
                        <div class="text-sm text-gray-500">Order #: <span class="font-semibold">{{ $order->order_number }}</span></div>
                        <div class="mt-1">Placed: {{ $order->created_at->format('d M Y H:i') }}</div>
                        <div class="mt-1">Total: Rp {{ number_format($order->total, 0, ',', '.') }}</div>
                    </div>
                    <div class="text-right">
                        <div class="mb-2">Status: <span class="font-medium">{{ ucfirst($order->status) }}</span></div>
                        <a href="{{ route('orders.track', $order) }}" class="inline-block bg-blue-600 text-white px-3 py-2 rounded">Track</a>
                    </div>
                </div>
            @endforeach

            <div>
                {{ $orders->links() }}
            </div>
        </div>
    @endif
</div>
@endsection
