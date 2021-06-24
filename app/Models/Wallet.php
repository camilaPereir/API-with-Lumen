<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Wallet extends Model
{
    protected $table = "wallet";

    protected $fillable = [
        "id_users",
        "value"
    ];


    public function Users()
    {
        return $this->belongsTo(Users::class);
    }
}
