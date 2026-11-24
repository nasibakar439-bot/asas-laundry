<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Struk Transaksi #{{ $transaksi->id }}</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 p-6 font-mono">
    <div class="max-w-md mx-auto bg-white p-6 rounded-xl shadow border border-gray-200">

        <div class="text-center border-b border-dashed border-gray-400 pb-4 mb-4">
            <h1 class="text-xl font-bold text-gray-800">LAUNDRY APP</h1>
            <p class="text-xs text-gray-500">Struk Bukti Transaksi Laundry</p>
        </div>

        <div class="text-xs space-y-1.5 border-b border-dashed border-gray-400 pb-4 mb-4 text-gray-700">
            <div class="flex justify-between">
                <span>No. Transaksi</span>
                <span class="font-bold">#{{ $transaksi->id }}</span>
            </div>
            <div class="flex justify-between">
                <span>Tanggal</span>
                <span>{{ $transaksi->created_at->format('d/m/Y H:i') }}</span>
            </div>
            <div class="flex justify-between">
                <span>Pelanggan</span>
                <span class="font-bold">{{ $transaksi->customer_name }}</span>
            </div>
            <div class="flex justify-between">
                <span>No. HP</span>
                <span>{{ $transaksi->no_hp }}</span>
            </div>
            <div class="flex justify-between">
                <span>Status</span>
                <span class="font-bold">{{ strtoupper($transaksi->status) }}</span>
            </div>
        </div>

        <div class="border-b border-dashed border-gray-400 pb-4 mb-4">
            <p class="text-xs font-bold text-gray-700 mb-2">RINCIAN LAYANAN:</p>
            <div class="space-y-2 text-xs text-gray-700">
                @foreach($transaksi->detailTransaksi as $detail)
                    <div class="flex justify-between items-start">
                        <div>
                            <div class="font-bold">{{ $detail->layanan->name ?? 'Layanan' }}</div>
                            <div class="text-gray-500">
                                {{ $detail->quantity }} kg x Rp {{ number_format($detail->layanan->price ?? 0) }}
                            </div>
                        </div>
                        <div class="font-bold">
                            Rp {{ number_format($detail->price) }}
                        </div>
                    </div>
                @endforeach
            </div>
        </div>

        <div class="flex justify-between items-center text-base font-bold text-gray-900 mb-6">
            <span>TOTAL BAYAR</span>
            <span>Rp {{ number_format($transaksi->total_price) }}</span>
        </div>

        <p class="text-center text-xs text-gray-500 mb-6">
            Terima kasih telah menggunakan layanan kami!
        </p>

        <div class="flex gap-3 print:hidden">
            <button type="button" onclick="window.print()" class="w-1/2 bg-blue-600 hover:bg-blue-700 text-white font-sans font-bold py-2.5 rounded-lg text-sm transition">
                Print Struk
            </button>
            <a href="{{ Auth::user()->role === 'admin' ? route('dashboard') : route('kasir.index') }}" class="w-1/2 bg-gray-200 hover:bg-gray-300 text-gray-800 font-sans font-bold py-2.5 rounded-lg text-sm text-center transition">
                Kembali
            </a>
        </div>

    </div>
</body>
</html>