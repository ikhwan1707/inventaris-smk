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
    return view('welcome');
});

Auth::routes();

Route::middleware('auth')->group(function () {
    Route::get('/dashboard', 'DashboardController@index')->name('dashboard');

    Route::resource('kategori', 'KategoriController');
    Route::resource('ruangan', 'RuanganController');
    Route::resource('kondisi', 'KondisiController');
    Route::resource('barang', 'BarangController');
    Route::resource('barang-masuk', 'BarangMasukController');
    Route::resource('barang-keluar', 'BarangKeluarController');
    Route::resource('peminjaman', 'PeminjamanController');
    Route::resource('pengembalian', 'PengembalianController');

    Route::get('/laporan/inventaris', 'LaporanController@inventaris')->name('laporan.inventaris');
    Route::get('/laporan/barang-masuk', 'LaporanController@barangMasuk')->name('laporan.barang-masuk');
    Route::get('/laporan/barang-keluar', 'LaporanController@barangKeluar')->name('laporan.barang-keluar');
    Route::get('/laporan/peminjaman', 'LaporanController@peminjaman')->name('laporan.peminjaman');

    Route::resource('user', 'UserController');
});