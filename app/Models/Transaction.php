<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    protected $table = 'transaction';

    protected $fillable = [
        'payee',
        'payer',
        'value'
    ];

    public function payee()
    {
        return $this->hasOne(Users::class, 'id', 'payee');
    }

    public function payer()
    {
        return $this->hasOne(Users::class, 'id', 'payer');
    }

    public function transactionStatus()
    {
        return $this->hasMany(StatusTransaction::class, 'transaction_id', 'id');
    }
}
