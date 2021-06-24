<?php

namespace App\Repositories;

use App\Models\Type;

class TypeRepository
{
    private $type;

    public function __construct(Type $type){
        $this->type = $type;
    }

    public function show(int $id): Object
    {
        return $this->type->findOrFail($id);
    }
}
