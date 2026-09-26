<?php

namespace App;

use App\Item;
use Illuminate\Database\Eloquent\Model;

class ItemIn extends Model
{
    protected $table = 'item_ins';

    protected $fillable = [
        'item_id',
        'tanggal_masuk',
        'jumlah',
        'sumber',
        'keterangan',
    ];

    public function item()
    {
        return $this->belongsTo(Item::class);
    }
}