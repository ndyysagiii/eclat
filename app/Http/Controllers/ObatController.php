<?php

namespace App\Http\Controllers;

use App\Models\Obat;
use Illuminate\Http\Request;

class ObatController extends Controller
{
    public function index()
    {
        $obat = Obat::OrderByDesc('id')->get();
        $obatCount = Obat::count();
        return view('layouts.pages.obat', compact('obat', 'obatCount'));
    }

    public function store(Request $request)
    {
        $validateData = $request->validate([
            'nama' => 'required',
        ]);

        Obat::create($validateData);
        return redirect()->back()->with('message', 'Data berhasil ditambahkan');
    }

    public function delete($id)
    {
        $obat = Obat::findOrFail($id);
        $obat->delete();
        return redirect()->route('obat')->with('message', 'Data berhasil dihapus.');
    }

    public function update(Request $request, $id)
    {
        $validatedData = $request->validate([
            'nama' => 'required',
        ]);

        $obat = Obat::findOrFail($id);
        $obat->update($validatedData);
        return redirect()->route('obat')->with('message', 'Data berhasil diperbarui.');
    }
}
