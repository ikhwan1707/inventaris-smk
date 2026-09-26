<?php

namespace App;

use App\Item;
use Illuminate\Database\Eloquent\Model;

class Location extends Model
{
    protected $table = 'locations';

    protected $fillable = ['nama_ruangan'];

    public function items()
    {
        return $this->hasMany(Item::class);
    }
}