<x-store-layout>
    <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
        <h1 class="text-2xl font-bold mb-6">Bank Transfer - QRIS & Upload Proof</h1>

        @if(session('success'))
            <div class="mb-4 p-4 bg-green-100 text-green-800 rounded">{{ session('success') }}</div>
        @endif

        <div class="bg-white shadow rounded-lg p-6 mb-6">
            <p class="text-gray-700 mb-4">Scan the QRIS below to pay via your banking / e-wallet app.</p>
            <div class="flex items-center justify-center mb-6">
                {{-- Replace with real QRIS image in public/images/qris.png --}}
                <img src="{{ asset('images/qris.png') }}" alt="QRIS" class="w-64 h-64 object-contain bg-gray-100 p-4 rounded" onerror="this.src='data:image/svg+xml;utf8,<svg xmlns=\'http://www.w3.org/2000/svg\' width=\'256\' height=\'256\'><rect width=\'100%\' height=\'100%\' fill=\'%23f3f4f6\' /><text x=\'50%\' y=\'50%\' dominant-baseline=\'middle\' text-anchor=\'middle\' fill=\'%23999\' font-family=\'Arial\' font-size=\'14\'>QRIS image not found</text></svg>'" />
            </div>

            @if($order->payment_proof)
                <p class="text-gray-700 mb-4">You have uploaded a payment proof. Preview it below and confirm when ready.</p>
                <div class="mb-4">
                    <img src="{{ asset('storage/' . $order->payment_proof) }}" class="w-64 h-auto object-contain rounded shadow" />
                </div>

                <form action="{{ route('checkout.bank.confirm', $order->id) }}" method="POST">
                    @csrf
                    <button type="submit" class="bg-green-600 text-white px-4 py-2 rounded hover:bg-green-700">Confirm Upload</button>
                </form>
            @else
                <p class="text-gray-700 mb-4">After payment, upload your payment proof below.</p>

                <form action="{{ route('checkout.bank.upload', $order->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700 mb-2">Upload Payment Proof (JPG, PNG)</label>
                        <input type="file" name="payment_proof" accept="image/*" required>
                        @error('payment_proof')<div class="text-sm text-red-600">{{ $message }}</div>@enderror
                    </div>
                    <div class="flex">
                        <button type="submit" class="bg-green-600 text-white px-4 py-2 rounded hover:bg-green-700">Upload Proof</button>
                    </div>
                </form>
            @endif
        </div>

        <div class="bg-white shadow rounded-lg p-6">
            <h2 class="font-semibold mb-2">Order Summary</h2>
            <div class="text-sm text-gray-700">Order #: {{ $order->order_number }}</div>
            <div class="text-sm text-gray-700">Total: Rp {{ number_format($order->total,0,',','.') }}</div>
        </div>
    </div>
</x-store-layout>
