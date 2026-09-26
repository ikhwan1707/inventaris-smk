<?php

namespace App\Http\Controllers;

use App\Category;
use Illuminate\Http\Request;

class KategoriController extends Controller
{
    public function index()
    {
        $data = Category::orderBy('nama_kategori')->get();
        return view('kategori.index', compact('data'));
    }

    public function create()
    {
        return view('kategori.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_kategori' => 'required|string|max:100|unique:categories,nama_kategori',
        ], [
            'nama_kategori.required' => 'Nama kategori wajib diisi.',
            'nama_kategori.unique'   => 'Nama kategori sudah ada.',
        ]);

        Category::create($request->only('nama_kategori'));

        return redirect()->route('kategori.index')
            ->with('success', 'Data kategori berhasil ditambahkan.');
    }

    public function show($id)
    {
        $data = Category::findOrFail($id);
        return view('kategori.show', compact('data'));
    }

    public function edit($id)
    {
        $data = Category::findOrFail($id);
        return view('kategori.edit', compact('data'));
    }

    public function update(Request $request, $id)
    {
        $data = Category::findOrFail($id);

        $request->validate([
            'nama_kategori' => 'required|string|max:100|unique:categories,nama_kategori,' . $id,
        ]);

        $data->update($request->only('nama_kategori'));

        return redirect()->route('kategori.index')
            ->with('success', 'Data kategori berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $data = Category::findOrFail($id);

        // Cegah hapus jika masih dipakai barang
        if ($data->items()->count() > 0) {
            return redirect()->route('kategori.index')
                ->with('error', 'Kategori tidak bisa dihapus karena masih digunakan oleh data barang.');
        }

        $data->delete();

        return redirect()->route('kategori.index')
            ->with('success', 'Data kategori berhasil dihapus.');
    }
}