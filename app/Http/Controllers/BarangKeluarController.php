<?php

namespace App\Http\Controllers;

use App\Item;
use App\ItemOut;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class BarangKeluarController extends Controller
{
    public function index(Request $request)
    {
        $query = ItemOut::with('item')->orderBy('tanggal_keluar', 'desc');

        if ($request->filled('tanggal_awal') && $request->filled('tanggal_akhir')) {
            $query->whereBetween('tanggal_keluar', [$request->tanggal_awal, $request->tanggal_akhir]);
        }
        if ($request->filled('item_id')) {
            $query->where('item_id', $request->item_id);
        }

        $data   = $query->paginate(20)->appends($request->query());
        $barang = Item::orderBy('nama_barang')->get();

        return view('barang-keluar.index', compact('data', 'barang'));
    }

    public function create()
    {
        $barang = Item::where('jumlah', '>', 0)->orderBy('nama_barang')->get();
        return view('barang-keluar.create', compact('barang'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'item_id'         => 'required|exists:items,id',
            'tanggal_keluar'  => 'required|date',
            'jumlah'          => 'required|integer|min:1',
            'tujuan'          => 'nullable|string|max:150',
            'keterangan'      => 'nullable|string',
        ], [
            'item_id.required'         => 'Barang wajib dipilih.',
            'tanggal_keluar.required'  => 'Tanggal keluar wajib diisi.',
            'jumlah.required'          => 'Jumlah wajib diisi.',
            'jumlah.min'               => 'Jumlah minimal 1.',
        ]);

        $item = Item::findOrFail($request->item_id);

        // Cek stok mencukupi
        if ($item->jumlah < $request->jumlah) {
            return redirect()->back()
                ->with('error', 'Stok tidak mencukupi. Stok tersedia: ' . $item->jumlah . ' ' . $item->satuan)
                ->withInput();
        }

        DB::beginTransaction();
        try {
            ItemOut::create($request->all());
            $item->decrement('jumlah', $request->jumlah);

            DB::commit();

            return redirect()->route('barang-keluar.index')
                ->with('success', 'Transaksi barang keluar berhasil disimpan dan stok telah dikurangi.');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()
                ->with('error', 'Gagal menyimpan transaksi: ' . $e->getMessage())
                ->withInput();
        }
    }

    public function show($id)
    {
        $data = ItemOut::with('item')->findOrFail($id);
        return view('barang-keluar.show', compact('data'));
    }

    public function edit($id)
    {
        $data = ItemOut::findOrFail($id);
        $barang = Item::orderBy('nama_barang')->get();
        return view('barang-keluar.edit', compact('data', 'barang'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'item_id'         => 'required|exists:items,id',
            'tanggal_keluar'  => 'required|date',
            'jumlah'          => 'required|integer|min:1',
            'tujuan'          => 'nullable|string|max:150',
            'keterangan'      => 'nullable|string',
        ]);

        $data = ItemOut::findOrFail($id);

        DB::beginTransaction();
        try {
            // Kembalikan stok lama
            $itemLama = Item::findOrFail($data->item_id);
            $itemLama->increment('jumlah', $data->jumlah);

            // Cek stok baru setelah dikembalikan
            $itemBaru = Item::findOrFail($request->item_id);

            if ($itemBaru->jumlah < $request->jumlah) {
                DB::rollBack();
                return redirect()->back()
                    ->with('error', 'Stok tidak mencukupi. Stok tersedia: ' . $itemBaru->jumlah . ' ' . $itemBaru->satuan)
                    ->withInput();
            }

            // Update transaksi
            $data->update($request->all());

            // Kurangi stok baru
            $itemBaru->decrement('jumlah', $request->jumlah);

            DB::commit();

            return redirect()->route('barang-keluar.index')
                ->with('success', 'Transaksi barang keluar berhasil diperbarui.');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()
                ->with('error', 'Gagal memperbarui transaksi: ' . $e->getMessage())
                ->withInput();
        }
    }

    public function destroy($id)
    {
        $data = ItemOut::findOrFail($id);

        DB::beginTransaction();
        try {
            // Kembalikan stok karena transaksi dibatalkan
            $item = Item::findOrFail($data->item_id);
            $item->increment('jumlah', $data->jumlah);

            $data->delete();

            DB::commit();

            return redirect()->route('barang-keluar.index')
                ->with('success', 'Transaksi barang keluar berhasil dihapus dan stok telah dikembalikan.');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->route('barang-keluar.index')
                ->with('error', 'Gagal menghapus transaksi: ' . $e->getMessage());
        }
    }
}