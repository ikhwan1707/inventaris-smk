<?php

namespace App\Http\Controllers;

use App\Item;
use App\Category;
use App\Location;
use App\Condition;
use App\ItemIn;
use App\ItemOut;
use App\Loan;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        /* =========================================================
         * 1. STATISTIK UTAMA (Kartu)
         * ========================================================= */
        $totalBarang       = Item::sum('jumlah');
        $totalJenisBarang  = Item::count();
        $totalKategori     = Category::count();
        $totalRuangan      = Location::count();
        $peminjamanAktif   = Loan::where('status', 'Dipinjam')->count();
        $barangRusak       = Item::whereHas('condition', function ($q) {
            $q->where('nama_kondisi', 'like', '%rusak%');
        })->count();

        /* =========================================================
         * 2. BARANG PER KATEGORI (Grafik Donut)
         * ========================================================= */
        $barangPerKategori = Category::withCount('items')
            ->with(['items' => function ($q) {
                $q->select('category_id', DB::raw('SUM(jumlah) as total'))
                    ->groupBy('category_id');
            }])
            ->get()
            ->map(function ($cat) {
                return [
                    'nama'  => $cat->nama_kategori,
                    'total' => $cat->items->sum('total') ?? 0,
                ];
            });

        /* =========================================================
         * 3. BARANG PER KONDISI (Grafik Bar)
         * ========================================================= */
        $barangPerKondisi = Condition::with(['items' => function ($q) {
            $q->select('condition_id', DB::raw('SUM(jumlah) as total'))
                ->groupBy('condition_id');
        }])
            ->get()
            ->map(function ($cond) {
                return [
                    'nama'  => $cond->nama_kondisi,
                    'total' => $cond->items->sum('total') ?? 0,
                ];
            });

        /* =========================================================
         * 4. BARANG PER RUANGAN (Grafik Bar)
         * ========================================================= */
        $barangPerRuangan = Location::with(['items' => function ($q) {
            $q->select('location_id', DB::raw('SUM(jumlah) as total'))
                ->groupBy('location_id');
        }])
            ->get()
            ->map(function ($loc) {
                return [
                    'nama'  => $loc->nama_ruangan,
                    'total' => $loc->items->sum('total') ?? 0,
                ];
            });

        /* =========================================================
         * 5. TRANSAKSI 7 HARI TERAKHIR (Grafik Line)
         * ========================================================= */
        $labels       = [];
        $dataMasuk    = [];
        $dataKeluar   = [];

        for ($i = 6; $i >= 0; $i--) {
            $tanggal  = Carbon::now()->subDays($i)->format('Y-m-d');
            $labels[] = Carbon::now()->subDays($i)->translatedFormat('d M');

            $dataMasuk[]  = ItemIn::whereDate('tanggal_masuk', $tanggal)->sum('jumlah');
            $dataKeluar[] = ItemOut::whereDate('tanggal_keluar', $tanggal)->sum('jumlah');
        }

        /* =========================================================
         * 6. AKTIVITAS TERBARU
         * ========================================================= */
        $barangMasukTerbaru = ItemIn::with('item')
            ->orderBy('created_at', 'desc')
            ->take(5)
            ->get();

        $barangKeluarTerbaru = ItemOut::with('item')
            ->orderBy('created_at', 'desc')
            ->take(5)
            ->get();

        $peminjamanTerbaru = Loan::with('item')
            ->orderBy('created_at', 'desc')
            ->take(5)
            ->get();

        /* =========================================================
         * 7. BARANG STOK MENIPIS (<= 5 unit)
         * ========================================================= */
        $stokMenipis = Item::with(['category', 'location'])
            ->where('jumlah', '<=', 5)
            ->orderBy('jumlah', 'asc')
            ->take(10)
            ->get();

        /* =========================================================
         * 8. PEMINJAMAN TERLAMBAT
         * ========================================================= */
        $peminjamanTerlambat = Loan::with('item')
            ->where('status', 'Dipinjam')
            ->whereDate('rencana_kembali', '<', Carbon::now()->format('Y-m-d'))
            ->orderBy('rencana_kembali', 'asc')
            ->get();

        return view('dashboard', compact(
            'totalBarang',
            'totalJenisBarang',
            'totalKategori',
            'totalRuangan',
            'peminjamanAktif',
            'barangRusak',
            'barangPerKategori',
            'barangPerKondisi',
            'barangPerRuangan',
            'labels',
            'dataMasuk',
            'dataKeluar',
            'barangMasukTerbaru',
            'barangKeluarTerbaru',
            'peminjamanTerbaru',
            'stokMenipis',
            'peminjamanTerlambat'
        ));
    }
}