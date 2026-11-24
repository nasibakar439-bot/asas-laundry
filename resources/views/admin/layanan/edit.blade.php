<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Edit Data Layanan</h2>
    </x-slot>

    <div class="py-12 max-w-2xl mx-auto sm:px-6 lg:px-8">
        <form action="{{ route('layanan.update', $layanan->id) }}" method="POST" class="bg-white p-6 rounded-lg shadow-sm border">
            @csrf
            @method('PUT')
            <div class="mb-4">
                <label class="block font-medium mb-1">Nama Layanan</label>
                <input type="text" name="name" value="{{ $layanan->name }}" class="w-full border rounded p-2" required>
            </div>
            <div class="mb-4">
                <label class="block font-medium mb-1">Kategori</label>
                <select name="category" class="w-full border rounded p-2" required>
                    <option value="Reguler" {{ $layanan->category == 'Reguler' ? 'selected' : '' }}>Reguler</option>
                    <option value="Ekspress" {{ $layanan->category == 'Ekspress' ? 'selected' : '' }}>Ekspress</option>
                    <option value="Superkilat" {{ $layanan->category == 'Superkilat' ? 'selected' : '' }}>Superkilat</option>
                </select>
            </div>
            <div class="mb-4">
                <label class="block font-medium mb-1">Harga per kg (Rp)</label>
                <input type="number" name="price" value="{{ $layanan->price }}" class="w-full border rounded p-2" required>
            </div>
            <div class="mb-4">
                <label class="block font-medium mb-1">Deskripsi</label>
                <textarea name="description" class="w-full border rounded p-2" rows="3" required>{{ $layanan->description }}</textarea>
            </div>
            <div class="flex items-center gap-3">
                <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-2.5 rounded font-semibold">
                    Update Data
                </button>
                <a href="{{ route('layanan.index') }}" class="text-sm text-gray-600 hover:underline">Batal</a>
            </div>
        </form>
    </div>
</x-app-layout>


