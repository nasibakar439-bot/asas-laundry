<?php

namespace App\Http\Controllers;

use App\Models\Layanan;
use Illuminate\Http\Request;

class LayananController extends Controller
{

    public function index()
    {
        $layanan = Layanan::latest()->paginate(10);
        return view('admin.layanan.index', compact('layanan'));
    }

    public function create()
    {
        return view('admin.layanan.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name'        => 'required|string|max:255',
            'category'    => 'required|in:Reguler,Ekspress,Superkilat',
            'price'       => 'required|numeric|min:0',
            'description' => 'required|string',
        ]);

        Layanan::create([
            'name'        => $request->name,
            'category'    => $request->category,
            'price'       => $request->price,
            'description' => $request->description,
        ]);

        return redirect()->route('layanan.index')->with('success', 'Data layanan berhasil ditambahkan!');
    }

    public function edit(Layanan $layanan)
    {
        return view('admin.layanan.edit', compact('layanan'));
    }

    public function update(Request $request, Layanan $layanan)
    {
        $request->validate([
            'name'        => 'required|string|max:255',
            'category'    => 'required|in:Reguler,Ekspress,Superkilat',
            'price'       => 'required|numeric|min:0',
            'description' => 'required|string',
        ]);

        $layanan->update([
            'name'        => $request->name,
            'category'    => $request->category,
            'price'       => $request->price,
            'description' => $request->description,
        ]);

        return redirect()->route('layanan.index')->with('success', 'Data layanan berhasil diperbarui!');
    }

    public function destroy(Layanan $layanan)
    {
        $layanan->delete();

        return redirect()->route('layanan.index')->with('success', 'Data layanan berhasil dihapus!');
    }
}