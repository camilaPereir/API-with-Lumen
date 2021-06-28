<?php

namespace App\Repositories;

use App\Models\StatusTransaction;

class StatusRepository
{
    private $statusRepository;

    public function __construct(StatusTransaction $statusRepository)
    {
        $this->statusRepository = $statusRepository;
    }

    public function create(array $params): Object
    {
        return $this->statusRepository->create($params);
    }
}
