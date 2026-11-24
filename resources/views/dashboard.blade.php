<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-wrap justify-between items-center gap-3">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Rekap Transaksi Laundry') }}
            </h2>
            <div class="flex items-center gap-3">
                <a href="{{ route('layanan.index') }}" class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700 shadow-sm transition">
                    Data Layanan
                </a>
                <a href="{{ route('kasir.index') }}" target="_blank" class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 shadow-sm transition">
                    Input Transaksi Baru
                </a>
            </div>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">

            @if(session('success'))
                <div class="p-4 bg-green-100 border-l-4 border-green-500 text-green-700 rounded shadow-sm font-medium">
                    {{ session('success') }}
                </div>
            @endif

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
                <div class="bg-white p-5 rounded-lg shadow-sm border">
                    <p class="text-xs font-semibold text-gray-500 uppercase">Total Transaksi</p>
                    <p class="text-2xl font-bold text-gray-800 mt-1">{{ $totalTransaksi }}</p>
                </div>
                <div class="bg-white p-5 rounded-lg shadow-sm border">
                    <p class="text-xs font-semibold text-gray-500 uppercase">Sedang Proses</p>
                    <p class="text-2xl font-bold text-yellow-600 mt-1">{{ $transaksiProses }}</p>
                </div>
                <div class="bg-white p-5 rounded-lg shadow-sm border">
                    <p class="text-xs font-semibold text-gray-500 uppercase">Selesai</p>
                    <p class="text-2xl font-bold text-green-600 mt-1">{{ $transaksiSelesai }}</p>
                </div>
                <div class="bg-white p-5 rounded-lg shadow-sm border">
                    <p class="text-xs font-semibold text-gray-500 uppercase">Total Pendapatan (Selesai)</p>
                    <p class="text-2xl font-bold text-indigo-600 mt-1">Rp {{ number_format($totalPendapatan) }}</p>
                </div>
            </div>

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg border border-gray-200">
                <div class="p-6 text-gray-900 overflow-x-auto">
                    <table class="w-full text-left border-collapse">
                        <thead class="bg-gray-100 text-gray-700 uppercase text-xs">
                            <tr>
                                <th class="p-4 border-b"># ID</th>
                                <th class="p-4 border-b">Pelanggan</th>
                                <th class="p-4 border-b">No. HP</th>
                                <th class="p-4 border-b">Rincian Layanan</th>
                                <th class="p-4 border-b">Total Harga</th>
                                <th class="p-4 border-b">Status</th>
                                <th class="p-4 border-b text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y text-sm">
                            @forelse($transaksi as $transaksi)
                                <tr class="hover:bg-gray-50">
                                    <td class="p-4 font-bold text-gray-700">#{{ $transaksi->id }}</td>
                                    <td class="p-4 font-medium">{{ $transaksi->customer_name }}</td>
                                    <td class="p-4 text-gray-600">{{ $transaksi->no_hp }}</td>
                                    <td class="p-4">
                                        <ul class="list-disc list-inside space-y-1 text-gray-600">
                                            @foreach($transaksi->detailTransaksi as $detail)
                                                <li>
                                                    <strong>{{ $detail->layanan->name ?? 'Layanan' }}</strong>
                                                    ({{ $detail->layanan->category ?? '-' }}) — {{ $detail->quantity }} kg
                                                    <span class="text-xs text-gray-400">(Rp {{ number_format($detail->price) }})</span>
                                                </li>
                                            @endforeach
                                        </ul>
                                    </td>
                                    <td class="p-4 font-bold text-green-600 whitespace-nowrap">
                                        Rp {{ number_format($transaksi->total_price) }}
                                    </td>
                                    <td class="p-4">
                                        @if($transaksi->status == 'Proses')
                                            <span class="bg-yellow-100 text-yellow-800 text-xs font-bold px-2.5 py-1 rounded">PROSES</span>
                                        @elseif($transaksi->status == 'Selesai')
                                            <span class="bg-green-100 text-green-800 text-xs font-bold px-2.5 py-1 rounded">SELESAI</span>
                                        @else
                                            <span class="bg-red-100 text-red-800 text-xs font-bold px-2.5 py-1 rounded">{{ strtoupper($transaksi->status) }}</span>
                                        @endif
                                    </td>
                                    <td class="p-4 text-center space-y-2 whitespace-nowrap">
                                        <form action="{{ route('admin.transaksi.updateStatus', $transaksi->id) }}" method="POST">
                                            @csrf
                                            @method('PATCH')
                                            <select name="status" onchange="this.form.submit()" class="text-xs border border-gray-300 rounded p-1.5 bg-white shadow-sm font-semibold">
                                                <option value="Proses" {{ $transaksi->status == 'Proses' ? 'selected' : '' }}>Proses</option>
                                                <option value="Selesai" {{ $transaksi->status == 'Selesai' ? 'selected' : '' }}>Selesai</option>
                                                <option value="Batal" {{ $transaksi->status == 'Batal' ? 'selected' : '' }}>Batal</option>
                                            </select>
                                        </form>
                                        <a href="{{ route('transaksi.receipt', $transaksi->id) }}" target="_blank" class="inline-block text-xs bg-gray-800 hover:bg-gray-900 text-white px-3 py-1.5 rounded font-semibold transition">
                                            Cetak Struk
                                        </a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="p-6 text-center text-gray-500">Belum ada transaksi masuk.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

        </div>
    </div>
</x-app-layout>