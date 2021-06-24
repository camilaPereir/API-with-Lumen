<?php

namespace App\Repositories;

use App\Models\Transaction;

class TransactionRepository
{
    private $model;

    public function __construct(Transaction $transaction){
        $this->model = $transaction;
    }

    public function show(int $id): Object
    {
        return $this->type->findOrFail($id);
    }

    public function store(Array $params){
        return $this->model->create($params);
    }
}
