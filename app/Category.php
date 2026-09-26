<?php

namespace App;

use App\Item;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $table = 'categories';

    protected $fillable = ['nama_kategori'];

    public function items()
    {
        return $this->hasMany(Item::class);
    }
}