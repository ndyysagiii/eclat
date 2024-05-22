<?php

namespace App\Http\Controllers;

use App\Models\Obat;
use App\Models\Transaksi;
use Illuminate\Http\Request;

class TransaksiController extends Controller
{
    public function index()
    {
        $transaksi = Transaksi::with(['detail'])->OrderByDesc('id')->get();
        $obat = Obat::all();
        $transaksiCount = Transaksi::count();
        return view('layouts.pages.transaksi', compact('transaksi', 'obat', 'transaksiCount'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'tanggal_transaksi' => 'required|date',
            'obat' => 'required|array',
            'obat.*' => 'required|exists:obat,id',
        ]);

        $transaksi = Transaksi::create([
            'tanggal_transaksi' => $request->tanggal_transaksi,
        ]);

        foreach ($request->obat as $obatId) {
            $transaksi->detail()->create([
                'obat_id' => $obatId,
            ]);
        }

        return redirect()->route('transaksi')->with('message', 'Transaksi berhasil disimpan.');
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'tanggal_transaksi' => 'required|date',
            'obat' => 'required|array',
            'obat.*' => 'required|exists:obat,id',
        ]);

        $transaksi = Transaksi::findOrFail($id);
        $transaksi->update([
            'tanggal_transaksi' => $request->tanggal_transaksi,
        ]);

        // Delete existing details
        $transaksi->detail()->delete();

        // Add new details
        foreach ($request->obat as $obatId) {
            $transaksi->detail()->create([
                'obat_id' => $obatId,
            ]);
        }

        return redirect()->route('transaksi')->with('message', 'Transaksi berhasil diperbarui.');
    }

    public function delete($id)
    {
        $transaksi = Transaksi::findOrFail($id);
        $transaksi->delete();
        return redirect()->route('transaksi')->with('message', 'Data berhasil dihapus.');
    }
}
