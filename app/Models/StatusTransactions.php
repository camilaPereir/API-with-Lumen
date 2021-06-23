<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StatusTransaction extends Model
{
    protected $fillable = [
        "status",
        "transaction_id",
    ];

    public function Users()
    {
        return $this->belongsTo(Transaction::class);
    }
}
