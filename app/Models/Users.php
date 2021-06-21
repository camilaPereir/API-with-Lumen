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
        "type_id",
        "wallet_id"
    ];

    protected $hidden = [
        'password',
    ];

    // public array $rules = [
    //     "name" => "required|max:45|alpha",
    //     "email" => "required|email|max:100|email:rfc,dns",
    //     "password" => "required|max:45|alpha",
    //     "cpf_cnpj" => "required|max:45|alpha"
    // ];

    public function wallet()
    {
        return $this->hasMany(Wallet::class);
    }

    public function typeUser()
    {
        return $this->hasMany(TypeUser::class);
    }
}
