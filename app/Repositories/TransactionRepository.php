<?php

namespace App\Repositories;

use App\Models\Transaction;

class TransactionRepository
{
    private $transaction;

    public function __construct(Transaction $transaction)
    {
        $this->transaction = $transaction;
    }

    public function getAll(): Object
    {
        return $this->transaction->all();
    }

    public function get(int $id)
    {
        $transaction = $this->transaction->with('transactionStatus')->findOrFail($id);

        $return = [
            "id" => $transaction->id,
            "payee" => $transaction->payee,
            "payer" => $transaction->payer,
            "value" => $transaction->value,
            "status" => $transaction->transactionStatus()->orderBy('id', 'desc')->first()
        ];

        return $return;
    }

    public function create(array $params)
    {
        return $this->transaction->create($params);
    }
}
