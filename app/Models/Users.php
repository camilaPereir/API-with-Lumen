<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Users extends Model
{

    protected $fillable = [
        "name",
        "email",
        "password",
        "cpf_cnpj",
        "type_id"
    ];

    protected $hidden = [
        'password',
    ];

    public function type()
    {
        return $this->hasOne(Type::class);
    }
}
