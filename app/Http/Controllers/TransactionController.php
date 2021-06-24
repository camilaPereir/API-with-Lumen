<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use App\Models\Users;
use App\Models\Wallet;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Symfony\Component\HttpFoundation\Response;
use App\Services\TransactionService;

class TransactionController extends Controller
{
    private $transactionService;
    private $wallet;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(TransactionService $transactionService, Wallet $wallet)
    {
        $this->transactionService = $transactionService;
        $this->wallet = $wallet;
    }

    public function show($id)
    {
        $transaction = $this->transactionService->find($id);
        return response()->json($transaction, status: Response::HTTP_OK);
    }

    public function index()
    {
        $transaction = $this->transactionService->all();
        return response()->json($transaction, status: Response::HTTP_OK);
    }

    public function store(Request $request, Users $users, Wallet $wallet)
    {
        $validatedData = $this->validate($request, [
            'value' => 'required|numeric',
            'payee' => 'required|int|different:payer|exists:wallet,id',
            'payer' => 'required|int|different:payee|exists:wallet,id'
        ]);

        return response($this->transactionService->store($request->all()), Response::HTTP_CREATED);
    }

    //
}
