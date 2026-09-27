<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('auth.login');
});

Auth::routes();

Route::middleware('auth')->group(function () {
    Route::get('/dashboard', 'DashboardController@index')->name('dashboard');
    Route::get('/home', 'DashboardController@index');
    
    Route::resource('kategori', 'KategoriController');
    Route::resource('ruangan', 'RuanganController');
    Route::resource('kondisi', 'KondisiController');
    Route::resource('barang', 'BarangController');
    Route::resource('barang-masuk', 'BarangMasukController');
    Route::resource('barang-keluar', 'BarangKeluarController');
    Route::resource('peminjaman', 'PeminjamanController');
    Route::resource('pengembalian', 'PengembalianController');

    Route::get('search', 'SearchController@index')->name('search');

    Route::prefix('laporan')->name('laporan.')->group(function () {

        // Laporan Inventaris
        Route::get('/inventaris', 'LaporanController@inventaris')->name('inventaris');
        Route::get('/inventaris/pdf', 'LaporanController@inventarisPdf')->name('inventaris.pdf');

        // Laporan Barang Masuk
        Route::get('/barang-masuk', 'LaporanController@barangMasuk')->name('barang-masuk');
        Route::get('/barang-masuk/pdf', 'LaporanController@barangMasukPdf')->name('barang-masuk.pdf');

        // Laporan Barang Keluar
        Route::get('/barang-keluar', 'LaporanController@barangKeluar')->name('barang-keluar');
        Route::get('/barang-keluar/pdf', 'LaporanController@barangKeluarPdf')->name('barang-keluar.pdf');

        // Laporan Peminjaman
        Route::get('/peminjaman', 'LaporanController@peminjaman')->name('peminjaman');
        Route::get('/peminjaman/pdf', 'LaporanController@peminjamanPdf')->name('peminjaman.pdf');
    });

    Route::resource('user', 'UserController');
});