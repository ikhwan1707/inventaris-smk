<?php

namespace App\Http\Controllers;

use App\Item;
use App\ItemIn;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class BarangMasukController extends Controller
{
    public function index(Request $request)
    {
        $query = ItemIn::with('item')->orderBy('tanggal_masuk', 'desc');

        if ($request->filled('tanggal_awal') && $request->filled('tanggal_akhir')) {
            $query->whereBetween('tanggal_masuk', [$request->tanggal_awal, $request->tanggal_akhir]);
        }
        if ($request->filled('item_id')) {
            $query->where('item_id', $request->item_id);
        }

        $data   = $query->paginate(20)->appends($request->query());
        $barang = Item::orderBy('nama_barang')->get();

        return view('barang-masuk.index', compact('data', 'barang'));
    }

    public function create()
    {
        $barang = Item::orderBy('nama_barang')->get();
        return view('barang-masuk.create', compact('barang'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'item_id'        => 'required|exists:items,id',
            'tanggal_masuk'  => 'required|date',
            'jumlah'         => 'required|integer|min:1',
            'sumber'         => 'nullable|string|max:150',
            'keterangan'     => 'nullable|string',
        ], [
            'item_id.required'       => 'Barang wajib dipilih.',
            'tanggal_masuk.required' => 'Tanggal masuk wajib diisi.',
            'jumlah.required'        => 'Jumlah wajib diisi.',
            'jumlah.min'             => 'Jumlah minimal 1.',
        ]);

        DB::beginTransaction();
        try {
            // Simpan transaksi
            ItemIn::create($request->all());

            // Update stok barang
            $item = Item::findOrFail($request->item_id);
            $item->increment('jumlah', $request->jumlah);

            DB::commit();

            return redirect()->route('barang-masuk.index')
                ->with('success', 'Transaksi barang masuk berhasil disimpan dan stok telah diperbarui.');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()
                ->with('error', 'Gagal menyimpan transaksi: ' . $e->getMessage())
                ->withInput();
        }
    }

    public function show($id)
    {
        $data = ItemIn::with('item')->findOrFail($id);
        return view('barang-masuk.show', compact('data'));
    }

    public function edit($id)
    {
        $data = ItemIn::findOrFail($id);
        $barang = Item::orderBy('nama_barang')->get();
        return view('barang-masuk.edit', compact('data', 'barang'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'item_id'        => 'required|exists:items,id',
            'tanggal_masuk'  => 'required|date',
            'jumlah'         => 'required|integer|min:1',
            'sumber'         => 'nullable|string|max:150',
            'keterangan'     => 'nullable|string',
        ]);

        $data = ItemIn::findOrFail($id);

        DB::beginTransaction();
        try {
            // Kembalikan stok lama
            $itemLama = Item::findOrFail($data->item_id);
            $itemLama->decrement('jumlah', $data->jumlah);

            // Update data transaksi
            $data->update($request->all());

            // Tambahkan stok baru
            $itemBaru = Item::findOrFail($request->item_id);
            $itemBaru->increment('jumlah', $request->jumlah);

            DB::commit();

            return redirect()->route('barang-masuk.index')
                ->with('success', 'Transaksi barang masuk berhasil diperbarui.');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()
                ->with('error', 'Gagal memperbarui transaksi: ' . $e->getMessage())
                ->withInput();
        }
    }

    public function destroy($id)
    {
        $data = ItemIn::findOrFail($id);

        DB::beginTransaction();
        try {
            // Kurangi stok karena transaksi dibatalkan
            $item = Item::findOrFail($data->item_id);

            if ($item->jumlah < $data->jumlah) {
                DB::rollBack();
                return redirect()->route('barang-masuk.index')
                    ->with('error', 'Stok tidak cukup untuk dibatalkan. Stok saat ini: ' . $item->jumlah);
            }

            $item->decrement('jumlah', $data->jumlah);
            $data->delete();

            DB::commit();

            return redirect()->route('barang-masuk.index')
                ->with('success', 'Transaksi barang masuk berhasil dihapus dan stok telah dikurangi.');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->route('barang-masuk.index')
                ->with('error', 'Gagal menghapus transaksi: ' . $e->getMessage());
        }
    }
}