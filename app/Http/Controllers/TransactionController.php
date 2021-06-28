<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Services\TransactionService;

class TransactionController extends Controller
{
    private $transactionService;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(TransactionService $transactionService)
    {
        $this->transactionService = $transactionService;
    }

    public function show($id)
    {
        $transaction = $this->transactionService->get($id);
        return response()->json($transaction, status: Response::HTTP_OK);
    }

    public function index()
    {
        $transaction = $this->transactionService->getAll();
        return response()->json($transaction, status: Response::HTTP_OK);
    }

    public function store(Request $request)
    {
        $validatedData = $this->validate($request, [
            'value' => 'required|numeric',
            'payee' => 'required|int|different:payer|exists:wallet,id',
            'payer' => 'required|int|different:payee|exists:wallet,id'
        ]);

        return response($this->transactionService->create($request->all()), status: Response::HTTP_CREATED);
    }
}
