<?php

namespace App\Repositories;

use App\Models\Users;

class UsersRepository
{
    private $users;

    public function __construct(Users $users){
        $this->users = $users;
    }
    
    public function show(int $id): Object
    {
        return $this->users->find($id);
    }
}
