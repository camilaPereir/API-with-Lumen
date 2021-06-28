<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class User extends Model
{
    protected $table = 'users';

    protected $fillable = [
        'name',
        'email',
        'password',
        'cpf_cnpj',
        'type_id'
    ];

    protected $hidden = [
        'password',
    ];

    public function type()
    {
        return $this->hasOne(Type::class);
    }

    public function walletValue()
    {
        return $this->hasMany(Wallet::class, 'id_users', 'id');
    }
}
