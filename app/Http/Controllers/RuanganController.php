<?php

namespace App\Http\Controllers;

use App\Location;
use Illuminate\Http\Request;

class RuanganController extends Controller
{
    public function index()
    {
        $data = Location::orderBy('nama_ruangan')->get();
        return view('ruangan.index', compact('data'));
    }

    public function create()
    {
        return view('ruangan.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_ruangan' => 'required|string|max:100|unique:locations,nama_ruangan',
        ], [
            'nama_ruangan.required' => 'Nama ruangan wajib diisi.',
            'nama_ruangan.unique'   => 'Nama ruangan sudah ada.',
        ]);

        Location::create($request->only('nama_ruangan'));

        return redirect()->route('ruangan.index')
            ->with('success', 'Data ruangan berhasil ditambahkan.');
    }

    public function show($id)
    {
        $data = Location::findOrFail($id);
        return view('ruangan.show', compact('data'));
    }

    public function edit($id)
    {
        $data = Location::findOrFail($id);
        return view('ruangan.edit', compact('data'));
    }

    public function update(Request $request, $id)
    {
        $data = Location::findOrFail($id);

        $request->validate([
            'nama_ruangan' => 'required|string|max:100|unique:locations,nama_ruangan,' . $id,
        ]);

        $data->update($request->only('nama_ruangan'));

        return redirect()->route('ruangan.index')
            ->with('success', 'Data ruangan berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $data = Location::findOrFail($id);

        if ($data->items()->count() > 0) {
            return redirect()->route('ruangan.index')
                ->with('error', 'Ruangan tidak bisa dihapus karena masih digunakan oleh data barang.');
        }

        $data->delete();

        return redirect()->route('ruangan.index')
            ->with('success', 'Data ruangan berhasil dihapus.');
    }
}