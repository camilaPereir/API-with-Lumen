<?php

namespace App\Repositories;

use App\Models\Wallet;

class WalletRepository
{
    private $wallet;

    public function __construct(Wallet $wallet)
    {
        $this->wallet = $wallet;
    }

    public function get(int $id): Object
    {
        return $this->wallet->find($id);
    }

    public function create(array $params): Object
    {
        return $this->wallet->create($params);
    }

    public function save(int $id, float $value): int
    {
        return $this->wallet->where('id', $id)->update(['value' => $value]);
    }
}
