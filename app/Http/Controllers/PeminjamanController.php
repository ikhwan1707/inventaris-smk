<?php

namespace App\Http\Controllers;

use App\Item;
use App\Loan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class PeminjamanController extends Controller
{
    public function index(Request $request)
    {
        $query = Loan::with('item')->orderBy('tanggal_pinjam', 'desc');

        if ($request->filled('tanggal_awal') && $request->filled('tanggal_akhir')) {
            $query->whereBetween('tanggal_pinjam', [$request->tanggal_awal, $request->tanggal_akhir]);
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('item_id')) {
            $query->where('item_id', $request->item_id);
        }

        $data   = $query->paginate(20)->appends($request->query());
        $barang = Item::orderBy('nama_barang')->get();

        return view('peminjaman.index', compact('data', 'barang'));
    }

    public function create()
    {
        $barang = Item::where('jumlah', '>', 0)->orderBy('nama_barang')->get();

        // Generate kode peminjaman otomatis
        $kode = $this->generateKodePeminjaman();

        return view('peminjaman.create', compact('barang', 'kode'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'item_id'          => 'required|exists:items,id',
            'nama_peminjam'    => 'required|string|max:100',
            'kelas_atau_unit'  => 'nullable|string|max:100',
            'tanggal_pinjam'   => 'required|date',
            'rencana_kembali'  => 'required|date|after_or_equal:tanggal_pinjam',
            'jumlah'           => 'required|integer|min:1',
            'keterangan'       => 'nullable|string',
        ], [
            'item_id.required'         => 'Barang wajib dipilih.',
            'nama_peminjam.required'   => 'Nama peminjam wajib diisi.',
            'tanggal_pinjam.required'  => 'Tanggal pinjam wajib diisi.',
            'rencana_kembali.required' => 'Rencana kembali wajib diisi.',
            'rencana_kembali.after_or_equal' => 'Rencana kembali tidak boleh sebelum tanggal pinjam.',
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
            // Generate kode unik
            $kode = $this->generateKodePeminjaman();

            Loan::create([
                'kode_peminjaman' => $kode,
                'item_id'         => $request->item_id,
                'nama_peminjam'   => $request->nama_peminjam,
                'kelas_atau_unit' => $request->kelas_atau_unit,
                'tanggal_pinjam'  => $request->tanggal_pinjam,
                'rencana_kembali' => $request->rencana_kembali,
                'jumlah'          => $request->jumlah,
                'status'          => 'Dipinjam',
                'keterangan'      => $request->keterangan,
            ]);

            // Kurangi stok
            $item->decrement('jumlah', $request->jumlah);

            DB::commit();

            return redirect()->route('peminjaman.index')
                ->with('success', 'Peminjaman berhasil dicatat dengan kode ' . $kode);
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()
                ->with('error', 'Gagal menyimpan peminjaman: ' . $e->getMessage())
                ->withInput();
        }
    }

    public function show($id)
    {
        $data = Loan::with(['item', 'returns.condition'])->findOrFail($id);
        return view('peminjaman.show', compact('data'));
    }

    public function edit($id)
    {
        $data = Loan::findOrFail($id);

        // Hanya boleh edit jika status masih Dipinjam
        if ($data->status === 'Kembali') {
            return redirect()->route('peminjaman.index')
                ->with('error', 'Peminjaman yang sudah dikembalikan tidak bisa diedit.');
        }

        $barang = Item::orderBy('nama_barang')->get();

        return view('peminjaman.edit', compact('data', 'barang'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'item_id'          => 'required|exists:items,id',
            'nama_peminjam'    => 'required|string|max:100',
            'kelas_atau_unit'  => 'nullable|string|max:100',
            'tanggal_pinjam'   => 'required|date',
            'rencana_kembali'  => 'required|date|after_or_equal:tanggal_pinjam',
            'jumlah'           => 'required|integer|min:1',
            'keterangan'       => 'nullable|string',
        ]);

        $data = Loan::findOrFail($id);

        if ($data->status === 'Kembali') {
            return redirect()->route('peminjaman.index')
                ->with('error', 'Peminjaman yang sudah dikembalikan tidak bisa diedit.');
        }

        DB::beginTransaction();
        try {
            // Kembalikan stok lama
            $itemLama = Item::findOrFail($data->item_id);
            $itemLama->increment('jumlah', $data->jumlah);

            // Cek stok baru
            $itemBaru = Item::findOrFail($request->item_id);

            if ($itemBaru->jumlah < $request->jumlah) {
                DB::rollBack();
                return redirect()->back()
                    ->with('error', 'Stok tidak mencukupi. Stok tersedia: ' . $itemBaru->jumlah . ' ' . $itemBaru->satuan)
                    ->withInput();
            }

            // Update data
            $data->update([
                'item_id'         => $request->item_id,
                'nama_peminjam'   => $request->nama_peminjam,
                'kelas_atau_unit' => $request->kelas_atau_unit,
                'tanggal_pinjam'  => $request->tanggal_pinjam,
                'rencana_kembali' => $request->rencana_kembali,
                'jumlah'          => $request->jumlah,
                'keterangan'      => $request->keterangan,
            ]);

            // Kurangi stok baru
            $itemBaru->decrement('jumlah', $request->jumlah);

            DB::commit();

            return redirect()->route('peminjaman.index')
                ->with('success', 'Peminjaman berhasil diperbarui.');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()
                ->with('error', 'Gagal memperbarui peminjaman: ' . $e->getMessage())
                ->withInput();
        }
    }

    public function destroy($id)
    {
        $data = Loan::findOrFail($id);

        if ($data->status === 'Kembali') {
            return redirect()->route('peminjaman.index')
                ->with('error', 'Peminjaman yang sudah dikembalikan tidak bisa dihapus.');
        }

        DB::beginTransaction();
        try {
            // Kembalikan stok
            $item = Item::findOrFail($data->item_id);
            $item->increment('jumlah', $data->jumlah);

            $data->delete();

            DB::commit();

            return redirect()->route('peminjaman.index')
                ->with('success', 'Data peminjaman berhasil dihapus dan stok dikembalikan.');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->route('peminjaman.index')
                ->with('error', 'Gagal menghapus peminjaman: ' . $e->getMessage());
        }
    }

    /**
     * Generate kode peminjaman otomatis
     * Format: PJM-YYYYMMDD-XXX
     */
    private function generateKodePeminjaman()
    {
        $tanggal = Carbon::now()->format('Ymd');
        $prefix  = 'PJM-' . $tanggal . '-';

        $last = Loan::where('kode_peminjaman', 'like', $prefix . '%')
            ->orderBy('kode_peminjaman', 'desc')
            ->first();

        if ($last) {
            $lastNumber = (int) substr($last->kode_peminjaman, -3);
            $newNumber  = str_pad($lastNumber + 1, 3, '0', STR_PAD_LEFT);
        } else {
            $newNumber = '001';
        }

        return $prefix . $newNumber;
    }
}