<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Tambah Data Layanan</h2>
    </x-slot>

    <div class="py-12 max-w-2xl mx-auto sm:px-6 lg:px-8">
        <form action="{{ route('layanan.store') }}" method="POST" class="bg-white p-6 rounded-lg shadow-sm border">
            @csrf
            <div class="mb-4">
                <label class="block font-medium mb-1">Nama Layanan</label>
                <input type="text" name="name" class="w-full border rounded p-2" placeholder="Contoh: Cuci Reguler" required>
            </div>
            <div class="mb-4">
                <label class="block font-medium mb-1">Kategori</label>
                <select name="category" class="w-full border rounded p-2" required>
                    <option value="Reguler">Reguler</option>
                    <option value="Ekspress">Ekspress</option>
                    <option value="Superkilat">Superkilat</option>
                </select>
            </div>
            <div class="mb-4">
                <label class="block font-medium mb-1">Harga per kg (Rp)</label>
                <input type="number" name="price" class="w-full border rounded p-2" placeholder="Contoh: 7000" required>
            </div>
            <div class="mb-4">
                <label class="block font-medium mb-1">Deskripsi</label>
                <textarea name="description" class="w-full border rounded p-2" rows="3" placeholder="Estimasi pengerjaan dan keterangan layanan" required></textarea>
            </div>
            <div class="flex items-center gap-3">
                <button type="submit" class="bg-green-600 hover:bg-green-700 text-white px-6 py-2.5 rounded font-semibold">
                    Simpan Data
                </button>
                <a href="{{ route('layanan.index') }}" class="text-sm text-gray-600 hover:underline">Batal</a>
            </div>
        </form>
    </div>
</x-app-layout>