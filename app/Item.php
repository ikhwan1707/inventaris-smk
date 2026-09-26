<?php

namespace App;

use App\Category;
use App\Condition;
use App\ItemIn;
use App\ItemOut;
use App\Loan;
use App\Location;
use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    protected $table = 'items';

    protected $fillable = [
        'kode_barang',
        'nama_barang',
        'category_id',
        'location_id',
        'condition_id',
        'jumlah',
        'satuan',
        'tahun_pengadaan',
        'keterangan',
    ];
    
    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function location()
    {
        return $this->belongsTo(Location::class);
    }

    public function condition()
    {
        return $this->belongsTo(Condition::class);
    }

    public function itemIns()
    {
        return $this->hasMany(ItemIn::class);
    }

    public function itemOuts()
    {
        return $this->hasMany(ItemOut::class);
    }

    public function loans()
    {
        return $this->hasMany(Loan::class);
    }
}