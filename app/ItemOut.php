<?php

namespace App;

use App\Item;
use Illuminate\Database\Eloquent\Model;

class ItemOut extends Model
{
    protected $table = 'item_outs';

    protected $fillable = [
        'item_id',
        'tanggal_keluar',
        'jumlah',
        'tujuan',
        'keterangan',
    ];

    public function item()
    {
        return $this->belongsTo(Item::class);
    }
}