<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    protected $fillable = [
        "payee",
        "payer",
        "value"
    ];

    public function payee()
    {
        return $this->hasOne(Users::class, "id", "payee");
    }

    public function payer()
    {
        return $this->hasOne(Users::class, "id", "payer");
    }
}
