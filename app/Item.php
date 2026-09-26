<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
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