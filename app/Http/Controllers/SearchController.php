<?php

namespace App\Http\Controllers;

use App\Item;
use App\Category;
use App\Location;
use App\Condition;
use App\Loan;
use Illuminate\Http\Request;

class SearchController extends Controller
{
    public function index(Request $request)
    {
        $q = trim($request->input('q', ''));

        // Jika keyword kosong, tampilkan halaman kosong
        if ($q === '') {
            return view('search.index', [
                'q'          => '',
                'items'      => collect(),
                'categories' => collect(),
                'locations'  => collect(),
                'conditions' => collect(),
                'loans'      => collect(),
                'total'      => 0,
            ]);
        }

        // Limit per kategori hasil
        $limit = 10;

        // 1. Barang
        $items = Item::with(['category', 'location', 'condition'])
            ->where(function ($query) use ($q) {
                $query->where('kode_barang', 'like', "%{$q}%")
                      ->orWhere('nama_barang', 'like', "%{$q}%")
                      ->orWhere('keterangan', 'like', "%{$q}%");
            })
            ->orderBy('nama_barang')
            ->limit($limit)
            ->get();

        // 2. Kategori
        $categories = Category::where('nama_kategori', 'like', "%{$q}%")
            ->orderBy('nama_kategori')
            ->limit($limit)
            ->get();

        // 3. Ruangan
        $locations = Location::where('nama_ruangan', 'like', "%{$q}%")
            ->orderBy('nama_ruangan')
            ->limit($limit)
            ->get();

        // 4. Kondisi
        $conditions = Condition::where('nama_kondisi', 'like', "%{$q}%")
            ->orderBy('nama_kondisi')
            ->limit($limit)
            ->get();

        // 5. Peminjaman
        $loans = Loan::with('item')
            ->where(function ($query) use ($q) {
                $query->where('kode_peminjaman', 'like', "%{$q}%")
                      ->orWhere('nama_peminjam', 'like', "%{$q}%")
                      ->orWhere('kelas_atau_unit', 'like', "%{$q}%");
            })
            ->orderBy('created_at', 'desc')
            ->limit($limit)
            ->get();

        $total = $items->count()
               + $categories->count()
               + $locations->count()
               + $conditions->count()
               + $loans->count();

        return view('search.index', compact(
            'q', 'items', 'categories', 'locations', 'conditions', 'loans', 'total'
        ));
    }
}