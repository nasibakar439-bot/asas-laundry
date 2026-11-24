<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-wrap justify-between items-center gap-3">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Data Layanan</h2>
            <div class="flex items-center gap-3">
                <a href="{{ route('dashboard') }}" class="inline-flex items-center px-4 py-2 bg-gray-800 rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 transition">
                    Rekap Transaksi Laundry
                </a>
                <a href="{{ route('layanan.create') }}" class="inline-flex items-center px-4 py-2 bg-blue-600 rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700 transition">
                    + Tambah Layanan
                </a>
            </div>
        </div>
    </x-slot>

    <div class="py-12 max-w-7xl mx-auto sm:px-6 lg:px-8">
        @if(session('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 p-3 rounded mb-4 font-medium">
                {{ session('success') }}
            </div>
        @endif

        <div class="bg-white overflow-x-auto shadow-sm sm:rounded-lg border">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-gray-100 border-b text-gray-600 text-xs uppercase">
                        <th class="p-3">Nama Layanan</th>
                        <th class="p-3">Kategori</th>
                        <th class="p-3">Harga / kg</th>
                        <th class="p-3">Deskripsi</th>
                        <th class="p-3 text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y text-sm">
                    @forelse($layanan as $layananItem)
                        <tr class="hover:bg-gray-50">
                            <td class="p-3 font-semibold text-gray-800">{{ $layananItem->name }}</td>
                            <td class="p-3">
                                <span class="bg-blue-100 text-blue-800 text-xs font-bold px-2.5 py-1 rounded">
                                    {{ $layananItem->category }}
                                </span>
                            </td>
                            <td class="p-3 font-bold text-green-600">Rp {{ number_format($layananItem->price) }}</td>
                            <td class="p-3 text-gray-600">{{ $layananItem->description }}</td>
                            <td class="p-3 text-center whitespace-nowrap">
                                <a href="{{ route('layanan.edit', $layananItem->id) }}" class="text-blue-600 hover:underline mr-3 font-semibold">Edit</a>
                                <form action="{{ route('layanan.destroy', $layananItem->id) }}" method="POST" class="inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" onclick="return confirm('Yakin hapus data layanan ini?')" class="text-red-600 hover:underline font-semibold">
                                        Hapus
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="p-6 text-center text-gray-500">Belum ada data layanan.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="mt-4">{{ $layanan->links() }}</div>
    </div>
</x-app-layout>
