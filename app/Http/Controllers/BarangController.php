<?php

namespace App\Http\Controllers;

use App\Item;
use App\Category;
use App\Location;
use App\Condition;
use Illuminate\Http\Request;

class BarangController extends Controller
{
    public function index()
    {
        $data = Item::with(['category', 'location', 'condition'])
            ->orderBy('nama_barang')
            ->get();

        return view('barang.index', compact('data'));
    }

    public function create()
    {
        $kategori  = Category::orderBy('nama_kategori')->get();
        $ruangan   = Location::orderBy('nama_ruangan')->get();
        $kondisi   = Condition::orderBy('nama_kondisi')->get();

        return view('barang.create', compact('kategori', 'ruangan', 'kondisi'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'kode_barang'     => 'required|string|max:50|unique:items,kode_barang',
            'nama_barang'     => 'required|string|max:150',
            'category_id'     => 'required|exists:categories,id',
            'location_id'     => 'required|exists:locations,id',
            'condition_id'    => 'required|exists:conditions,id',
            'jumlah'          => 'required|integer|min:0',
            'satuan'          => 'required|string|max:30',
            'tahun_pengadaan' => 'nullable|digits:4',
            'keterangan'      => 'nullable|string',
        ], [
            'kode_barang.required'  => 'Kode barang wajib diisi.',
            'kode_barang.unique'    => 'Kode barang sudah dipakai.',
            'nama_barang.required'  => 'Nama barang wajib diisi.',
            'category_id.required'  => 'Kategori wajib dipilih.',
            'location_id.required'  => 'Ruangan wajib dipilih.',
            'condition_id.required' => 'Kondisi wajib dipilih.',
            'jumlah.required'       => 'Jumlah wajib diisi.',
            'satuan.required'       => 'Satuan wajib diisi.',
        ]);

        Item::create($request->all());

        return redirect()->route('barang.index')
            ->with('success', 'Data barang berhasil ditambahkan.');
    }

    public function show($id)
    {
        $data = Item::with(['category', 'location', 'condition'])->findOrFail($id);
        return view('barang.show', compact('data'));
    }

    public function edit($id)
    {
        $data      = Item::findOrFail($id);
        $kategori  = Category::orderBy('nama_kategori')->get();
        $ruangan   = Location::orderBy('nama_ruangan')->get();
        $kondisi   = Condition::orderBy('nama_kondisi')->get();

        return view('barang.edit', compact('data', 'kategori', 'ruangan', 'kondisi'));
    }

    public function update(Request $request, $id)
    {
        $data = Item::findOrFail($id);

        $request->validate([
            'kode_barang'     => 'required|string|max:50|unique:items,kode_barang,' . $id,
            'nama_barang'     => 'required|string|max:150',
            'category_id'     => 'required|exists:categories,id',
            'location_id'     => 'required|exists:locations,id',
            'condition_id'    => 'required|exists:conditions,id',
            'jumlah'          => 'required|integer|min:0',
            'satuan'          => 'required|string|max:30',
            'tahun_pengadaan' => 'nullable|digits:4',
            'keterangan'      => 'nullable|string',
        ]);

        $data->update($request->all());

        return redirect()->route('barang.index')
            ->with('success', 'Data barang berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $data = Item::findOrFail($id);

        // Cegah hapus jika masih ada relasi transaksi
        if (
            $data->itemIns()->count() > 0
            || $data->itemOuts()->count() > 0
            || $data->loans()->count() > 0
        ) {
            return redirect()->route('barang.index')
                ->with('error', 'Barang tidak bisa dihapus karena sudah memiliki transaksi.');
        }

        $data->delete();

        return redirect()->route('barang.index')
            ->with('success', 'Data barang berhasil dihapus.');
    }
}