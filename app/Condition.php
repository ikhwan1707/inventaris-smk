<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Condition extends Model
{
    protected $table = 'conditions';

    protected $fillable = ['nama_kondisi'];

    public function items()
    {
        return $this->hasMany(Item::class);
    }
}