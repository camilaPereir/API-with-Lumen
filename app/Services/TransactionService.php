<?php

namespace App\Services;

use App\Repositories\TransactionRepository;
use App\Repositories\TypeRepository;
use App\Repositories\UsersRepository;
use App\Repositories\WalletRepository;
use Illuminate\Support\Facades\DB;

class TransactionService
{
    private $transactionRepository;
    private $walletRepository;
    private $usersRepository;
    private $typeRepository;
    
    public function __construct(TransactionRepository $transactionRepository, WalletRepository $walletRepository, UsersRepository $usersRepository, TypeRepository $typeRepository) {
        $this->transactionRepository = $transactionRepository;
        $this->walletRepository = $walletRepository;
        $this->usersRepository = $usersRepository;
        $this->typeRepository = $typeRepository;
    }

    public function store(Array $params)
    {
        DB::begintransaction();
        $this->transactionRepository->store($params);
        $payerWallet = $this->walletRepository->show($params["payer"]);
        $payeeWallet = $this->walletRepository->show($params["payee"]);
        $payerUser = $this->usersRepository->show($payerWallet["id_users"]);

        if (!empty($payerWallet->wallet)) {
            return "carteira do pagador não existe";
        }

        if (!empty($payeeWallet->wallet)) {
            return "carteira do recebedor não existe";
        }

        if(!$this->isPermitted($payerUser->type_id)){
            return "Tipo de usuario não permite realizar esse tipo de transação";
        }

        if($params["value"] > $payerWallet->value) {
            return "saldo insuficiente";
        }

        $payerWalletValue = $payerWallet->value - $params["value"];

        $payerUpdated = $this->walletRepository->update($payerWallet->id, $payerWalletValue); 
        if(!$payerUpdated) {
            DB::rollback();
            return "Erro ao atualizar dados do pagador";
        }
        
        $payeeWalletValue = $payeeWallet->value + $params["value"];
        
        $payeeUpdated = $this->walletRepository->update($payeeWallet->id, $payeeWalletValue); 
        if(!$payeeUpdated) {
            DB::rollback();
            return "Erro ao atualizar dados do beneficiário";
        }

        DB::commit();

        return "Transação efetuada com sucesso";
    }

    public function isPermitted(int $id)
    {
        $validateType = $this->typeRepository->show($id);  
        if($validateType['id'] === 1){
            return false;
        }
        return true;
    }
}
