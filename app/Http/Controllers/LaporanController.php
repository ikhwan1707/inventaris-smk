<?php

namespace App\Http\Controllers;

use App\Item;
use App\ItemIn;
use App\ItemOut;
use App\Loan;
use App\Category;
use App\Location;
use App\Condition;
use Illuminate\Http\Request;
use Carbon\Carbon;
use PDF;

class LaporanController extends Controller
{
    /* =========================================================
     * 1. LAPORAN INVENTARIS
     * ========================================================= */
    public function inventaris(Request $request)
    {
        $query = Item::with(['category', 'location', 'condition']);

        if ($request->filled('category_id')) {
            $query->where('category_id', $request->category_id);
        }
        if ($request->filled('location_id')) {
            $query->where('location_id', $request->location_id);
        }
        if ($request->filled('condition_id')) {
            $query->where('condition_id', $request->condition_id);
        }
        if ($request->filled('keyword')) {
            $query->where(function ($q) use ($request) {
                $q->where('kode_barang', 'like', '%' . $request->keyword . '%')
                    ->orWhere('nama_barang', 'like', '%' . $request->keyword . '%');
            });
        }

        $data        = $query->orderBy('nama_barang')->get();
        $kategori    = Category::orderBy('nama_kategori')->get();
        $ruangan     = Location::orderBy('nama_ruangan')->get();
        $kondisi     = Condition::orderBy('nama_kondisi')->get();
        $totalJumlah = $data->sum('jumlah');

        return view('laporan.inventaris', compact(
            'data',
            'kategori',
            'ruangan',
            'kondisi',
            'totalJumlah'
        ));
    }

    public function inventarisPdf(Request $request)
    {
        $query = Item::with(['category', 'location', 'condition']);

        if ($request->filled('category_id')) {
            $query->where('category_id', $request->category_id);
        }
        if ($request->filled('location_id')) {
            $query->where('location_id', $request->location_id);
        }
        if ($request->filled('condition_id')) {
            $query->where('condition_id', $request->condition_id);
        }
        if ($request->filled('keyword')) {
            $query->where(function ($q) use ($request) {
                $q->where('kode_barang', 'like', '%' . $request->keyword . '%')
                    ->orWhere('nama_barang', 'like', '%' . $request->keyword . '%');
            });
        }

        $data        = $query->orderBy('nama_barang')->get();
        $totalJumlah = $data->sum('jumlah');
        $tanggal     = Carbon::now()->translatedFormat('d F Y');

        $pdf = PDF::loadView(
            'laporan.pdf.inventaris',
            compact('data', 'totalJumlah', 'tanggal')
        )
            ->setPaper('a4', 'landscape');

        return $pdf->download('laporan-inventaris-' . date('Ymd-His') . '.pdf');
    }

    /* =========================================================
     * 2. LAPORAN BARANG MASUK
     * ========================================================= */
    public function barangMasuk(Request $request)
    {
        $query = ItemIn::with('item.category', 'item.location');

        if ($request->filled('tanggal_awal') && $request->filled('tanggal_akhir')) {
            $query->whereBetween('tanggal_masuk', [$request->tanggal_awal, $request->tanggal_akhir]);
        }
        if ($request->filled('item_id')) {
            $query->where('item_id', $request->item_id);
        }

        $data   = $query->orderBy('tanggal_masuk', 'desc')->get();
        $barang = Item::orderBy('nama_barang')->get();
        $total  = $data->sum('jumlah');

        return view('laporan.barang-masuk', compact('data', 'barang', 'total'));
    }

    public function barangMasukPdf(Request $request)
    {
        $query = ItemIn::with('item.category', 'item.location');

        if ($request->filled('tanggal_awal') && $request->filled('tanggal_akhir')) {
            $query->whereBetween('tanggal_masuk', [$request->tanggal_awal, $request->tanggal_akhir]);
        }
        if ($request->filled('item_id')) {
            $query->where('item_id', $request->item_id);
        }

        $data    = $query->orderBy('tanggal_masuk', 'desc')->get();
        $total   = $data->sum('jumlah');
        $tanggal = Carbon::now()->translatedFormat('d F Y');
        $periode = $this->formatPeriode($request->tanggal_awal, $request->tanggal_akhir);

        $pdf = PDF::loadView(
            'laporan.pdf.barang-masuk',
            compact('data', 'total', 'tanggal', 'periode')
        )
            ->setPaper('a4', 'landscape');

        return $pdf->download('laporan-barang-masuk-' . date('Ymd-His') . '.pdf');
    }

    /* =========================================================
     * 3. LAPORAN BARANG KELUAR
     * ========================================================= */
    public function barangKeluar(Request $request)
    {
        $query = ItemOut::with('item.category', 'item.location');

        if ($request->filled('tanggal_awal') && $request->filled('tanggal_akhir')) {
            $query->whereBetween('tanggal_keluar', [$request->tanggal_awal, $request->tanggal_akhir]);
        }
        if ($request->filled('item_id')) {
            $query->where('item_id', $request->item_id);
        }

        $data   = $query->orderBy('tanggal_keluar', 'desc')->get();
        $barang = Item::orderBy('nama_barang')->get();
        $total  = $data->sum('jumlah');

        return view('laporan.barang-keluar', compact('data', 'barang', 'total'));
    }

    public function barangKeluarPdf(Request $request)
    {
        $query = ItemOut::with('item.category', 'item.location');

        if ($request->filled('tanggal_awal') && $request->filled('tanggal_akhir')) {
            $query->whereBetween('tanggal_keluar', [$request->tanggal_awal, $request->tanggal_akhir]);
        }
        if ($request->filled('item_id')) {
            $query->where('item_id', $request->item_id);
        }

        $data    = $query->orderBy('tanggal_keluar', 'desc')->get();
        $total   = $data->sum('jumlah');
        $tanggal = Carbon::now()->translatedFormat('d F Y');
        $periode = $this->formatPeriode($request->tanggal_awal, $request->tanggal_akhir);

        $pdf = PDF::loadView(
            'laporan.pdf.barang-keluar',
            compact('data', 'total', 'tanggal', 'periode')
        )
            ->setPaper('a4', 'landscape');

        return $pdf->download('laporan-barang-keluar-' . date('Ymd-His') . '.pdf');
    }

    /* =========================================================
     * 4. LAPORAN PEMINJAMAN
     * ========================================================= */
    public function peminjaman(Request $request)
    {
        $query = Loan::with('item.category', 'item.location', 'return.condition');

        if ($request->filled('tanggal_awal') && $request->filled('tanggal_akhir')) {
            $query->whereBetween('tanggal_pinjam', [$request->tanggal_awal, $request->tanggal_akhir]);
        }
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }
        if ($request->filled('item_id')) {
            $query->where('item_id', $request->item_id);
        }

        $data   = $query->orderBy('tanggal_pinjam', 'desc')->get();
        $barang = Item::orderBy('nama_barang')->get();

        return view('laporan.peminjaman', compact('data', 'barang'));
    }

    public function peminjamanPdf(Request $request)
    {
        $query = Loan::with('item.category', 'item.location', 'return.condition');

        if ($request->filled('tanggal_awal') && $request->filled('tanggal_akhir')) {
            $query->whereBetween('tanggal_pinjam', [$request->tanggal_awal, $request->tanggal_akhir]);
        }
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }
        if ($request->filled('item_id')) {
            $query->where('item_id', $request->item_id);
        }

        $data    = $query->orderBy('tanggal_pinjam', 'desc')->get();
        $tanggal = Carbon::now()->translatedFormat('d F Y');
        $periode = $this->formatPeriode($request->tanggal_awal, $request->tanggal_akhir);

        $pdf = PDF::loadView(
            'laporan.pdf.peminjaman',
            compact('data', 'tanggal', 'periode')
        )
            ->setPaper('a4', 'landscape');

        return $pdf->download('laporan-peminjaman-' . date('Ymd-His') . '.pdf');
    }

    /* =========================================================
     * HELPER: Format Periode
     * ========================================================= */
    private function formatPeriode($awal, $akhir)
    {
        if ($awal && $akhir) {
            return Carbon::parse($awal)->translatedFormat('d F Y')
                . ' s/d ' .
                Carbon::parse($akhir)->translatedFormat('d F Y');
        }
        return 'Semua Periode';
    }
}