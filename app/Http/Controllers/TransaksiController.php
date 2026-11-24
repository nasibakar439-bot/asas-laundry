<?php

namespace App\Http\Controllers;

use App\Models\Layanan;
use App\Models\Transaksi;
use App\Models\DetailTransaksi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TransaksiController extends Controller
{
    public function index()
    {
        $layanan = Layanan::all();
        return view('kasir.index', compact('layanan'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'customer_name' => 'required|string|max:255',
            'no_hp'         => 'required|string|max:20',
            'items'         => 'required|array',
            'items.*'       => 'nullable|integer|min:0',
        ]);

        $orderedItems = array_filter($request->items, fn ($qty) => $qty > 0);

        if (empty($orderedItems)) {
            return back()->withInput()->with('error', 'Pilih minimal satu jenis layanan!');
        }

        DB::beginTransaction();
        try {
            $transaksi = Transaksi::create([
                'customer_name' => $request->customer_name,
                'no_hp'         => $request->no_hp,
                'total_price'   => 0,
                'status'        => 'Proses',
            ]);

            $totalPrice = 0;

            foreach ($orderedItems as $layananId => $quantity) {
                $layanan = Layanan::findOrFail($layananId);
                $subtotal = $layanan->price * $quantity;
                $totalPrice += $subtotal;

                DetailTransaksi::create([
                    'transaksi_id'        => $transaksi->id,
                    'layanan_id' => $layanan->id,
                    'quantity'        => $quantity,
                    'price'           => $subtotal,
                ]);
            }

            $transaksi->update(['total_price' => $totalPrice]);
            DB::commit();

            return redirect()->route('kasir.index')
                ->with('success', 'Transaksi berhasil dicatat!')
                ->with('transaksi_id', $transaksi->id);
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withInput()->with('error', 'Gagal memproses transaksi: ' . $e->getMessage());
        }
    }

    public function adminDashboard()
    {
        // Pembeda hak akses role: Kasir/non-admin diarahkan ke halaman transaksi
        if (auth()->user()->role !== 'admin') {
            return redirect()->route('kasir.index');
        }

        $transaksi = Transaksi::with('detailTransaksi.layanan')->latest()->get();
        $totalTransaksi = $transaksi->count();
        $transaksiProses = $transaksi->where('status', 'Proses')->count();
        $transaksiSelesai = $transaksi->where('status', 'Selesai')->count();
        $totalPendapatan = $transaksi->where('status', 'Selesai')->sum('total_price');

        return view('dashboard', compact(
            'transaksi',
            'totalTransaksi',
            'transaksiProses',
            'transaksiSelesai',
            'totalPendapatan'
        ));
    }

    public function updateStatus(Request $request, $id)
    {
        if (auth()->user()->role !== 'admin') {
            abort(403, 'Akses ditolak.');
        }

        $request->validate([
            'status' => 'required|in:Proses,Selesai,Batal',
        ]);

        $transaksi = Transaksi::findOrFail($id);
        $transaksi->update(['status' => $request->status]);

        return back()->with('success', 'Status transaksi #' . $transaksi->id . ' diperbarui menjadi ' . $request->status . '.');
    }

    public function receipt($id)
    {
        $transaksi = Transaksi::with('detailTransaksi.layanan')->findOrFail($id);
        return view('transaksi.receipt', compact('transaksi'));
    }
}