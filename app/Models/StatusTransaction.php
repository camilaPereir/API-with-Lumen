<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StatusTransaction extends Model
{
    protected $table = "status";
    protected $fillable = [
        "status",
        "transaction_id",
    ];

    public function User() //user
    {
        return $this->belongsTo(Transaction::class);
    }
}
