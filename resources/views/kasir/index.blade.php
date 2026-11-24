<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Transaksi Laundry</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 min-h-screen p-6 font-sans">
    <div class="max-w-5xl mx-auto">

        <div class="flex flex-wrap justify-between items-center gap-3 bg-white px-6 py-4 rounded-xl shadow-sm border mb-6">
            <div class="font-bold text-lg text-blue-600">Sistem Manajemen Laundry</div>
            <div class="flex items-center gap-3">
                @auth
                    <span class="text-sm text-gray-700">
                        Halo, <strong>{{ Auth::user()->name }}</strong>
                        <span class="text-xs bg-gray-100 text-gray-600 px-2 py-0.5 rounded uppercase">{{ Auth::user()->role }}</span>
                    </span>
                    @if(Auth::user()->role === 'admin')
                        <a href="{{ route('dashboard') }}" class="text-xs bg-indigo-600 hover:bg-indigo-700 text-white px-3 py-2 rounded-lg font-semibold transition">
                            Rekap Transaksi
                        </a>
                        <a href="{{ route('layanan.index') }}" class="text-xs bg-blue-600 hover:bg-blue-700 text-white px-3 py-2 rounded-lg font-semibold transition">
                            Data Layanan
                        </a>
                    @endif
                    <form action="{{ route('logout') }}" method="POST" class="inline">
                        @csrf
                        <button type="submit" class="text-xs bg-red-500 hover:bg-red-600 text-white px-3 py-2 rounded-lg font-semibold transition">
                            Logout
                        </button>
                    </form>
                @else
                    <a href="{{ route('login') }}" class="text-sm bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg font-semibold transition">
                        Login
                    </a>
                    <a href="{{ route('register') }}" class="text-sm bg-gray-800 hover:bg-gray-900 text-white px-4 py-2 rounded-lg font-semibold transition">
                        Register
                    </a>
                @endauth
            </div>
        </div>

        <div class="text-center mb-8">
            <h1 class="text-3xl font-bold text-gray-800">Pencatatan Transaksi Laundry</h1>
            <p class="text-gray-500 text-sm mt-1">Masukkan data pelanggan dan pilih jenis layanan cuci</p>
        </div>

        @if(session('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded-xl mb-6 text-center font-semibold">
                {{ session('success') }}
                @if(session('transaksi_id'))
                    <div class="mt-2">
                        <a href="{{ route('transaksi.receipt', session('transaksi_id')) }}" target="_blank" class="inline-block bg-green-600 hover:bg-green-700 text-white text-sm px-4 py-2 rounded-lg shadow transition">
                            Cetak Struk Transaksi
                        </a>
                    </div>
                @endif
            </div>
        @endif

        @if(session('error'))
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded-xl mb-6 text-center font-semibold">
                {{ session('error') }}
            </div>
        @endif

        @if($errors->any())
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded-xl mb-6 font-semibold">
                <ul class="list-disc list-inside text-sm">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('kasir.checkout') }}" method="POST">
            @csrf

            <div class="bg-white p-6 rounded-xl shadow-sm border mb-6">
                <div class="flex flex-wrap justify-between items-center gap-2 mb-4 pb-3 border-b">
                    <div>
                        <h2 class="text-lg font-bold text-gray-800">1. Data Pelanggan</h2>
                        <p class="text-xs text-gray-500">Pastikan nama dan nomor HP aktif untuk konfirmasi saat cucian selesai.</p>
                    </div>
                    <span class="text-xs bg-blue-50 text-blue-700 font-semibold px-3 py-1 rounded-full border border-blue-100">
                        Status Awal: Proses
                    </span>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-1.5">Nama Pelanggan</label>
                        <input type="text" name="customer_name" value="{{ old('customer_name') }}" required placeholder="Contoh: Budi Santoso" class="w-full border border-gray-300 rounded-lg px-4 py-2.5 text-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none">
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-1.5">No. HP Pelanggan</label>
                        <input type="text" name="no_hp" value="{{ old('no_hp') }}" required placeholder="Contoh: 081234567890" class="w-full border border-gray-300 rounded-lg px-4 py-2.5 text-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none">
                    </div>
                </div>
            </div>

            <div class="flex flex-wrap justify-between items-center mb-4">
                <h2 class="text-lg font-bold text-gray-800">2. Pilih Jenis Layanan</h2>
                <span class="text-xs text-gray-500">Isi berat cucian (kg) pada layanan yang dipilih</span>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                @foreach($layanan as $layanan)
                    <div class="bg-white rounded-xl shadow-sm border overflow-hidden flex flex-col justify-between hover:shadow-md transition">
                        <div class="p-5">
                            <div class="flex justify-between items-center mb-3">
                                <span class="text-xs bg-blue-100 text-blue-700 font-semibold px-2.5 py-0.5 rounded">{{ $layanan->category }}</span>
                                <span class="font-bold text-green-600">Rp {{ number_format($layanan->price) }}/kg</span>
                            </div>
                            <h3 class="font-bold text-gray-800 text-lg">{{ $layanan->name }}</h3>
                            <p class="text-xs text-gray-500 mt-1.5 leading-relaxed">{{ $layanan->description }}</p>
                        </div>

                        <div class="p-4 bg-gray-50 border-t">
                            <label class="block text-xs font-semibold text-gray-600 mb-1.5">Berat/Jumlah (kg)</label>
                            <input type="number" name="items[{{ $layanan->id }}]" min="0" value="{{ old('items.' . $layanan->id, 0) }}" class="w-full border border-gray-300 rounded-lg px-3 py-2 text-center font-bold text-gray-700 bg-white focus:ring-2 focus:ring-blue-500 outline-none">
                        </div>
                    </div>
                @endforeach
            </div>

            <div class="mt-8 flex justify-end">
                @auth
                    <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-bold px-8 py-3 rounded-xl shadow-md transition">
                        Simpan Transaksi
                    </button>
                @else
                    <a href="{{ route('login') }}" class="inline-block bg-gray-800 hover:bg-gray-900 text-white font-bold px-8 py-3 rounded-xl shadow-md transition">
                        Login Terlebih Dahulu untuk Mencatat Transaksi
                    </a>
                @endauth
            </div>
        </form>
    </div>
</body>
</html>