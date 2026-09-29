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
            // 1. Simpan pengembalian
            LoanReturn::create([
                'loan_id'         => $loan->id,
                'tanggal_kembali' => $request->tanggal_kembali,
                'condition_id'    => $request->condition_id,
                'keterangan'      => $request->keterangan,
            ]);

            // 2. Update status peminjaman
            $loan->update(['status' => 'Kembali']);

            // 3. Handle stok berdasarkan kondisi
            $item = Item::findOrFail($loan->item_id);

            if ($item->condition_id == $request->condition_id) {
                // ✅ Kondisi SAMA → cukup tambah stok item asli
                $item->increment('jumlah', $loan->jumlah);
            } else {
                // ⚠️ Kondisi BERBEDA → cari/buat item dengan kondisi baru

                $existingItem = Item::where('kode_barang', 'like', $item->kode_barang . '-R%')
                    ->where('condition_id', $request->condition_id)
                    ->where('location_id', $item->location_id)
                    ->where('category_id', $item->category_id)
                    ->first();

                if ($existingItem) {
                    // Sudah ada item dengan kondisi ini → tambah stoknya
                    $existingItem->increment('jumlah', $loan->jumlah);
                } else {
                    // Buat item baru dengan kode unik
                    $suffix = 1;
                    do {
                        $newCode = $item->kode_barang . '-R' . str_pad($suffix, 2, '0', STR_PAD_LEFT);
                        $suffix++;
                    } while (Item::where('kode_barang', $newCode)->exists());

                    Item::create([
                        'kode_barang'     => $newCode,
                        'nama_barang'     => $item->nama_barang,
                        'category_id'     => $item->category_id,
                        'location_id'     => $item->location_id,
                        'condition_id'    => $request->condition_id,
                        'jumlah'          => $loan->jumlah,
                        'satuan'          => $item->satuan,
                        'tahun_pengadaan' => $item->tahun_pengadaan,
                        'keterangan'      => 'Auto-generated dari return ' . $loan->kode_peminjaman,
                    ]);
                }
            }

            DB::commit();

            return redirect()->route('pengembalian.index')
                ->with('success', 'Return recorded successfully. Condition differences are tracked separately.');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()
                ->with('error', 'Failed to save: ' . $e->getMessage())
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
        $loan = $data->loan;

        if (!$loan) {
            return redirect()->back()
                ->with('error', 'Loan data not found.')
                ->withInput();
        }

        DB::beginTransaction();
        try {
            $masterItem = Item::findOrFail($loan->item_id);
            $oldConditionId = $data->condition_id;
            $newConditionId = $request->condition_id;
            $qty = $loan->jumlah;

            /* ==========================================
           LANGKAH 1: Revert efek pengembalian lama
           ========================================== */
            if ($oldConditionId == $masterItem->condition_id) {
                // Efek lama menambah ke item master → kurangi kembali
                if ($masterItem->jumlah < $qty) {
                    DB::rollBack();
                    return redirect()->back()
                        ->with('error', 'Cannot revert: master item stock is insufficient.')
                        ->withInput();
                }
                $masterItem->decrement('jumlah', $qty);
            } else {
                // Efek lama menambah ke varian → kurangi varian
                $oldVariant = Item::where('kode_barang', 'like', $masterItem->kode_barang . '-R%')
                    ->where('condition_id', $oldConditionId)
                    ->where('location_id', $masterItem->location_id)
                    ->where('category_id', $masterItem->category_id)
                    ->first();

                if ($oldVariant) {
                    if ($oldVariant->jumlah < $qty) {
                        DB::rollBack();
                        return redirect()->back()
                            ->with('error', 'Cannot revert: variant item stock is insufficient.')
                            ->withInput();
                    }

                    $oldVariant->decrement('jumlah', $qty);

                    // Jika varian jadi kosong → hapus
                    if ($oldVariant->jumlah <= 0) {
                        $oldVariant->delete();
                    }
                }
            }

            /* ==========================================
           LANGKAH 2: Terapkan efek kondisi baru
           ========================================== */
            if ($newConditionId == $masterItem->condition_id) {
                // Kondisi baru = kondisi master → tambah ke master
                $masterItem->increment('jumlah', $qty);
            } else {
                // Kondisi baru berbeda → cari/buat varian
                $newVariant = Item::where('kode_barang', 'like', $masterItem->kode_barang . '-R%')
                    ->where('condition_id', $newConditionId)
                    ->where('location_id', $masterItem->location_id)
                    ->where('category_id', $masterItem->category_id)
                    ->first();

                if ($newVariant) {
                    $newVariant->increment('jumlah', $qty);
                } else {
                    // Generate kode unik varian baru
                    $suffix = 1;
                    do {
                        $newCode = $masterItem->kode_barang . '-R' . str_pad($suffix, 2, '0', STR_PAD_LEFT);
                        $suffix++;
                    } while (Item::where('kode_barang', $newCode)->exists());

                    Item::create([
                        'kode_barang'     => $newCode,
                        'nama_barang'     => $masterItem->nama_barang,
                        'category_id'     => $masterItem->category_id,
                        'location_id'     => $masterItem->location_id,
                        'condition_id'    => $newConditionId,
                        'jumlah'          => $qty,
                        'satuan'          => $masterItem->satuan,
                        'tahun_pengadaan' => $masterItem->tahun_pengadaan,
                        'keterangan'      => 'Auto-generated from return ' . $loan->kode_peminjaman,
                    ]);
                }
            }

            /* ==========================================
           LANGKAH 3: Update data pengembalian
           ========================================== */
            $data->update([
                'tanggal_kembali' => $request->tanggal_kembali,
                'condition_id'    => $newConditionId,
                'keterangan'      => $request->keterangan,
            ]);

            DB::commit();

            return redirect()->route('pengembalian.index')
                ->with('success', 'Return updated successfully. Item stock and condition have been adjusted.');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()
                ->with('error', 'Failed to update: ' . $e->getMessage())
                ->withInput();
        }
    }

    public function destroy($id)
    {
        $data = LoanReturn::findOrFail($id);
        $loan = $data->loan;

        if (!$loan) {
            return redirect()->route('pengembalian.index')
                ->with('error', 'Loan data not found.');
        }

        DB::beginTransaction();
        try {
            $masterItem = Item::findOrFail($loan->item_id);
            $oldConditionId = $data->condition_id;
            $qty = $loan->jumlah;

            /* ==========================================
           Revert efek pengembalian
           ========================================== */
            if ($oldConditionId == $masterItem->condition_id) {
                // Efek lama menambah ke master → kurangi kembali
                if ($masterItem->jumlah < $qty) {
                    DB::rollBack();
                    return redirect()->route('pengembalian.index')
                        ->with('error', 'Cannot delete: master item stock is insufficient.');
                }
                $masterItem->decrement('jumlah', $qty);
            } else {
                // Efek lama menambah ke varian → kurangi/hapus varian
                $variant = Item::where('kode_barang', 'like', $masterItem->kode_barang . '-R%')
                    ->where('condition_id', $oldConditionId)
                    ->where('location_id', $masterItem->location_id)
                    ->where('category_id', $masterItem->category_id)
                    ->first();

                if ($variant) {
                    if ($variant->jumlah < $qty) {
                        DB::rollBack();
                        return redirect()->route('pengembalian.index')
                            ->with('error', 'Cannot delete: variant item stock is insufficient.');
                    }

                    $variant->decrement('jumlah', $qty);

                    if ($variant->jumlah <= 0) {
                        $variant->delete();
                    }
                }
            }

            /* ==========================================
           Revert status loan ke "Dipinjam"
           ========================================== */
            $loan->update(['status' => 'Dipinjam']);

            /* ==========================================
           Hapus data pengembalian
           ========================================== */
            $data->delete();

            DB::commit();

            return redirect()->route('pengembalian.index')
                ->with('success', 'Return cancelled. Loan status reverted to Borrowed and item stock restored.');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->route('pengembalian.index')
                ->with('error', 'Failed to delete: ' . $e->getMessage());
        }
    }
}