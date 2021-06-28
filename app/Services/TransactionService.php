<?php

namespace App\Services;

use App\Repositories\StatusRepository;
use App\Repositories\TransactionRepository;
use App\Repositories\TypeRepository;
use App\Repositories\UserRepository;
use App\Repositories\WalletRepository;
use App\Enums\TransactionEnum;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;

class TransactionService
{
    private $transactionRepository;
    private $walletRepository;
    private $userRepository;
    private $typeRepository;
    private $statusRepository;

    public function __construct(TransactionRepository $transactionRepository, WalletRepository $walletRepository, userRepository $userRepository, TypeRepository $typeRepository, StatusRepository $statusRepository)
    {
        $this->transactionRepository = $transactionRepository;
        $this->walletRepository = $walletRepository;
        $this->userRepository = $userRepository;
        $this->typeRepository = $typeRepository;
        $this->statusRepository = $statusRepository;
    }

    public function getAll()
    {
        $transaction = $this->transactionRepository->getAll();
        $response = [
            'message' => TransactionEnum::SUCESS_FIND,
            'error' => 0,
            'transaction' => $transaction
        ];
        if (empty($transaction)) {
            $response['error'] = 1;
            $response['message'] = TransactionEnum::ERR_NOT_DATA;
            return $response;
        }
        return $response;
    }

    public function get(int $id)
    {
        $transaction = $this->transactionRepository->get($id);
        $response = [
            'message' => TransactionEnum::SUCESS_FIND,
            'error' => 0,
            'transaction' => $transaction
        ];
        if (empty($transaction)) {
            $response['error'] = 1;
            $response['message'] = TransactionEnum::ERR_NOT_FOUND;
            return $response;
        }
        return $response;
    }

    public function create(array $params)
    {
        DB::begintransaction();

        $payerWallet = $this->walletRepository->get($params["payer"]);
        $payeeWallet = $this->walletRepository->get($params["payee"]);
        $payerUser = $this->userRepository->get($payerWallet["id_users"]);

        $response = [
            'message' => TransactionEnum::SUCESS_FIND,
            'error' => 0,
            'transaction' => null
        ];

        if (!empty($payerWallet->wallet)) {
            $response['error'] = 1;
            $response['message'] = TransactionEnum::ERR_NOT_EXIST_PAYER;
            return $response;
        }

        if (!empty($payeeWallet->wallet)) {
            $response['error'] = 1;
            $response['message'] = TransactionEnum::ERR_NOT_EXIST_PAYEE;
            return $response;
        }

        if (!$this->isPermitted($payerUser->type_id)) {
            $response['error'] = 1;
            $response['message'] = TransactionEnum::ERR_NOT_TYPE_PERMITED;
            return $response;
        }

        if ($params["value"] > $payerWallet->value) {
            $response['error'] = 1;
            $response['message'] = TransactionEnum::ERR_INSUFFICIENT_AMOUNT;
            return $response;
        }

        $transactionEfect = $this->transactionRepository->create($params);

        if (empty($transactionEfect)) {
            DB::rollback();
            $response['error'] = 1;
            $response['message'] = TransactionEnum::ERR_TRANSACTION_NOT_CREATED;
            return $response;
        }
        $statusParams = ['transaction_id' => $transactionEfect['id'], 'status' => 'Pendente'];
        $this->statusRepository->create($statusParams);

        $autorizada = $this->isAuthorizable();

        if (!$autorizada) {
            $statusParams = ['transaction_id' => $transactionEfect['id'], 'status' => 'Not Authorized'];
            $this->statusRepository->create($statusParams);
            $response['error'] = 1;
            $response['message'] = TransactionEnum::ERR_TRANSACTION_NOT_AUTHORIZED;
            return $response;
        }

        $payerWalletValue = $payerWallet->value - $params["value"];

        $payerUpdated = $this->walletRepository->save($payerWallet->id, $payerWalletValue);
        if (!$payerUpdated) {
            DB::rollback();
            $response['error'] = 1;
            $response['message'] = TransactionEnum::ERR_PAYER_NOT_UPDATED;
            return $response;
        }

        $payeeWalletValue = $payeeWallet->value + $params["value"];

        $payeeUpdated = $this->walletRepository->save($payeeWallet->id, $payeeWalletValue);
        if (!$payeeUpdated) {
            DB::rollback();
            $response['error'] = 1;
            $response['message'] = TransactionEnum::ERR_PAYEE_NOT_UPDATED;
            return $response;
        }

        $statusParams = ['transaction_id' => $transactionEfect['id'], 'status' => 'Authorized'];
        $this->statusRepository->create($statusParams);

        DB::commit();

        if (!$this->sendNotification()) {
            $response['error'] = 1;
            $response['message'] = TransactionEnum::ERR_NOT_SEND_NOTIFICATION;
            return $response;
        }

        return [
            'message' => TransactionEnum::SUCESS_CREATED,
            'error' => 0,
            'transaction' => $transactionEfect
        ];
    }

    public function isPermitted(int $id)
    {
        $validateType = $this->typeRepository->get($id);
        if ($validateType["id"] === 1) {
            return false;
        }
        return true;
    }

    public function isAuthorizable()
    {
        $response = Http::post("https://run.mocky.io/v3/8fafdd68-a090-496f-8c9a-3442cf30dae6");
        if (isset($response["message"]) && !empty($response["message"]) && $response["message"] === "Autorizado") {
            return true;
        } else {
            return false;
        }
    }

    public function sendNotification()
    {
        $response = Http::post("http://o4d9z.mocklab.io/notify");
        if (isset($response["message"]) && !empty($response["message"]) &&  $response["message"] === "Success") {
            return true;
        } else {
            return false;
        }
    }
}
