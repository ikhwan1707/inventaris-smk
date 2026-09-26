<?php

namespace App\Http\Controllers;

use App\Condition;
use App\Item;
use App\Loan;
use App\LoanReturn;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PengembalianController extends Controller
{
   public function index(Request $request)
    {
        $query = LoanReturn::with(['loan.item', 'condition'])
                    ->orderBy('tanggal_kembali', 'desc');

        $kondisi = Condition::orderBy('nama_kondisi')->get();
                    
        if ($request->filled('tanggal_awal') && $request->filled('tanggal_akhir')) {
            $query->whereBetween('tanggal_kembali', [$request->tanggal_awal, $request->tanggal_akhir]);
        }
        if ($request->filled('condition_id')) {
            $query->where('condition_id', $request->condition_id);
        }

        $data = $query->paginate(20)->appends($request->query());

        return view('pengembalian.index', compact('data','kondisi'));
    }

    public function create(Request $request)
    {
        // Jika dipanggil dari detail peminjaman, langsung isi loan_id
        $loan_id = $request->get('loan_id');

        // Daftar peminjaman yang masih "Dipinjam"
        $peminjaman = Loan::with('item')
            ->where('status', 'Dipinjam')
            ->orderBy('tanggal_pinjam', 'desc')
            ->get();

        $kondisi = Condition::orderBy('nama_kondisi')->get();

        return view('pengembalian.create', compact('peminjaman', 'kondisi', 'loan_id'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'loan_id'          => 'required|exists:loans,id',
            'tanggal_kembali'  => 'required|date',
            'condition_id'     => 'required|exists:conditions,id',
            'keterangan'       => 'nullable|string',
        ], [
            'loan_id.required'         => 'Peminjaman wajib dipilih.',
            'tanggal_kembali.required' => 'Tanggal kembali wajib diisi.',
            'condition_id.required'    => 'Kondisi barang wajib dipilih.',
        ]);

        $loan = Loan::findOrFail($request->loan_id);

        if ($loan->status === 'Kembali') {
            return redirect()->route('pengembalian.index')
                ->with('error', 'Peminjaman ini sudah dikembalikan sebelumnya.');
        }

        DB::beginTransaction();
        try {
            // Simpan pengembalian
            LoanReturn::create([
                'loan_id'         => $loan->id,
                'tanggal_kembali' => $request->tanggal_kembali,
                'condition_id'    => $request->condition_id,
                'keterangan'      => $request->keterangan,
            ]);

            // Update status peminjaman
            $loan->update(['status' => 'Kembali']);

            // Tambahkan stok barang
            $item = Item::findOrFail($loan->item_id);
            $item->increment('jumlah', $loan->jumlah);

            // Update kondisi barang jika berubah
            if ($item->condition_id != $request->condition_id) {
                $item->update(['condition_id' => $request->condition_id]);
            }

            DB::commit();

            return redirect()->route('pengembalian.index')
                ->with('success', 'Pengembalian berhasil dicatat dan stok telah diperbarui.');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()
                ->with('error', 'Gagal menyimpan pengembalian: ' . $e->getMessage())
                ->withInput();
        }
    }

    public function show($id)
    {
        $data = LoanReturn::with(['loan.item', 'condition'])->findOrFail($id);
        return view('pengembalian.show', compact('data'));
    }

    public function edit($id)
    {
        $data      = LoanReturn::findOrFail($id);
        $peminjaman = Loan::with('item')->orderBy('tanggal_pinjam', 'desc')->get();
        $kondisi   = Condition::orderBy('nama_kondisi')->get();

        return view('pengembalian.edit', compact('data', 'peminjaman', 'kondisi'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'tanggal_kembali' => 'required|date',
            'condition_id'    => 'required|exists:conditions,id',
            'keterangan'      => 'nullable|string',
        ]);

        $data = LoanReturn::findOrFail($id);

        DB::beginTransaction();
        try {
            $data->update([
                'tanggal_kembali' => $request->tanggal_kembali,
                'condition_id'    => $request->condition_id,
                'keterangan'      => $request->keterangan,
            ]);

            // Update kondisi barang
            $item = Item::findOrFail($data->loan->item_id);
            $item->update(['condition_id' => $request->condition_id]);

            DB::commit();

            return redirect()->route('pengembalian.index')
                ->with('success', 'Data pengembalian berhasil diperbarui.');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()
                ->with('error', 'Gagal memperbarui pengembalian: ' . $e->getMessage())
                ->withInput();
        }
    }

    public function destroy($id)
    {
        $data = LoanReturn::findOrFail($id);
        $loan = $data->loan;

        DB::beginTransaction();
        try {
            // Kembalikan status peminjaman menjadi Dipinjam
            $loan->update(['status' => 'Dipinjam']);

            // Kurangi stok kembali
            $item = Item::findOrFail($loan->item_id);

            if ($item->jumlah < $loan->jumlah) {
                DB::rollBack();
                return redirect()->route('pengembalian.index')
                    ->with('error', 'Stok tidak cukup untuk membatalkan pengembalian.');
            }

            $item->decrement('jumlah', $loan->jumlah);

            $data->delete();

            DB::commit();

            return redirect()->route('pengembalian.index')
                ->with('success', 'Pengembalian dibatalkan, status peminjaman kembali "Dipinjam".');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->route('pengembalian.index')
                ->with('error', 'Gagal menghapus pengembalian: ' . $e->getMessage());
        }
    }
}