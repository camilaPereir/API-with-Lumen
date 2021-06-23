<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use App\Models\Users;
use App\Models\Wallet;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Symfony\Component\HttpFoundation\Response;

class TransactionController extends Controller
{
    private $model;
    private $wallet;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(Transaction $transaction, Wallet $wallet)
    {
        $this->model = $transaction;
        $this->wallet = $wallet;
    }

    public function show($id)
    {
        $transaction = $this->model->find($id);
        return response()->json($transaction, status: Response::HTTP_OK);
    }

    public function index()
    {
        $transaction = $this->model->all();
        return response()->json($transaction, status: Response::HTTP_OK);
    }

    public function store(Request $request, Users $users)
    {
        $validatedData = $this->validate($request, [
            'value' => 'required|numeric',
            'payee' => 'required|int|different:payer|exists:wallet,id',
            'payer' => 'required|int|different:payee|exists:wallet,id'
        ]);


        $transaction = $this->model->create($validatedData); 
        $payerWallet = $this->wallet->findOrFail($transaction->payer);
        $payeeWallet = $this->wallet->findOrFail($transaction->payee);

        if ($payerWallet->users->id !== $users->id) {
            echo "error";
        }

        if($transaction->value > $payeeWallet->value) {
            echo "saldo insuficiente";
        }

         DB::beginTransaction(function () use ($transaction, $payerWallet, $payeeWallet) {
            $payerWalletValue = $payerWallet->value - $transaction->value;
            $this->wallet->update($payerWallet, ['value' => $payerWalletValue]);

            $payeeWalletValue = $payeeWallet->value + $transaction->value;
            $this->wallet->update($payeeWallet, ['value' => $payeeWalletValue]);

            //$this->repository->save($transactions);
            DB::commit();
         });
        $transaction = $transaction = $this->model->save($validatedData, $users);
        return response($transaction, Response::HTTP_CREATED);
    }


    //
}
