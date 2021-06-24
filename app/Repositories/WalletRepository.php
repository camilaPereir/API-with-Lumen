<?php

namespace App\Repositories;

use App\Models\Wallet;

class WalletRepository
{
    private $wallet;

    public function __construct(Wallet $wallet){
        $this->wallet = $wallet;
    }

    public function show(int $id): Object
    {
        return $this->wallet->findOrFail($id);
    }

    public function update(int $id, float $value): int
    {
        return $this->wallet->where('id', $id)->update(['value' => $value]);
    }
}
