<?php

namespace App\Repositories;

use App\Models\User;

class UserRepository
{
    private $user;

    public function __construct(User $user)
    {
        $this->user = $user;
    }

    public function get(int $id): Object
    {
        $user = $this->user->with('walletValue')->findOrFail($id);

        $return = [
            "id" => $user->id,
            "name" => $user->name,
            "cpf_cnpj" => $user->cpf_cnpj,
            "email" => $user->email,
            "type_id" => $user->type_id,
            "value" => $user->walletValue()
        ];
        return $user;
    }

    public function getAll(): Object
    {
        return $this->user->all();
    }

    public function create(array $params): Object
    {
        return $this->user->create($params);
    }

    public function save(array $params, int $id)
    {
        $user = $this->user->where('id', $id)->update($params);
        return $user;
    }

    public function delete(int $id)
    {

        return $this->user->find($id)
            ->delete();
    }
}
