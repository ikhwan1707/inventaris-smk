<?php

namespace App;

use App\Item;
use App\LoanReturn;
use Illuminate\Database\Eloquent\Model;

class Loan extends Model
{
    protected $table = 'loans';

    protected $fillable = [
        'kode_peminjaman',
        'item_id',
        'nama_peminjam',
        'kelas_atau_unit',
        'tanggal_pinjam',
        'rencana_kembali',
        'jumlah',
        'status',
        'keterangan',
    ];

    public function item()
    {
        return $this->belongsTo(Item::class);
    }

    public function returns()
    {
        return $this->hasMany(LoanReturn::class);
    }

    public function return()
    {
        return $this->hasOne(LoanReturn::class)->latest();
    }
}