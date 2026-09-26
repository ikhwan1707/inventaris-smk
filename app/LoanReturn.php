<?php

namespace App;

use App\Condition;
use App\Loan;
use Illuminate\Database\Eloquent\Model;

class LoanReturn extends Model
{
    protected $table = 'loan_returns';

    protected $fillable = [
        'loan_id',
        'tanggal_kembali',
        'condition_id',
        'keterangan',
    ];

    public function loan()
    {
        return $this->belongsTo(Loan::class);
    }

    public function condition()
    {
        return $this->belongsTo(Condition::class);
    }
}