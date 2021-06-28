<?php

namespace App\Repositories;

use App\Models\Type;

class TypeRepository
{
    private $typeRepository;

    public function __construct(Type $typeRepository)
    {
        $this->typeRepository = $typeRepository;
    }

    public function get(int $id): Object
    {
        return $this->typeRepository->find($id);
    }
}
