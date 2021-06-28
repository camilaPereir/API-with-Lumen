<?php

namespace App\Services;

use Illuminate\Support\Facades\DB;
use App\Enums\UserEnum;
use App\Repositories\UserRepository;
use App\Repositories\WalletRepository;

class UserService
{
    private $userRepository;
    private $walletRepository;

    public function __construct(UserRepository $userRepository, WalletRepository $walletRepository)
    {
        $this->userRepository = $userRepository;
        $this->walletRepository = $walletRepository;
    }

    public function show(int $id)
    {
        $users = $this->userRepository->get($id);
        $response = [
            'message' => UserEnum::SUCESS_FIND,
            'error' => 0,
            'users' => $users
        ];
        if (empty($users)) {
            $response['error'] = 1;
            $response['message'] = UserEnum::ERR_NOT_FOUND;
            return $response;
        }
        return $response;
    }

    public function index()
    {
        $users = $this->userRepository->getAll();
        $response = [
            'message' => UserEnum::SUCESS_FIND,
            'error' => 0,
            'users' => $users
        ];
        if (empty($users)) {
            $response['error'] = 1;
            $response['message'] = UserEnum::ERR_NOT_DATA;
            return $response;
        }
        return $response;
    }

    public function store(array $params)
    {
        DB::beginTransaction();
        $users = $this->userRepository->create($params);
        $response = [
            'message' => UserEnum::SUCESS_CREATED,
            'error' => 0,
            'users' => $users
        ];

        if (!empty((array) $users)) {
            $wallet = $this->walletRepository->create(['id_users' => $users->id, 'value' => 100.00]);
            if (!empty((array) $wallet)) {
                $user = [
                    'id' => $users->id,
                    'name' => $users->name,
                    'cpf_cnpj' => $users->cpf_cnpj,
                    'email' => $users->email,
                    'type_id' => $users->type_id,
                    'value' => $wallet->value
                ];
                DB::commit();
                $response['error'] = 0;
                $response['users'] = $user;
                $response['message'] = UserEnum::SUCESS_CREATED;
                return $response;
            } else {
                DB::rollback();
                $response['error'] = 1;
                $response['message'] = UserEnum::ERR_CREATE_WALLET;
                return $response;
            }
        } else {
            DB::rollback();
            $response['error'] = 1;
            $response['message'] = UserEnum::ERR_CREATE_USER;
            return $response;
        }
    }

    public function update(array $params, int $id)
    {
        $isUpdated = $this->userRepository->save($params, $id);
        $response = [
            'message' => UserEnum::SUCESS_UPDATED,
            'error' => 0,
            'user' => $isUpdated
        ];
        if (!empty($isUpdated)) {
            $response['error'] = 0;
            $response['message'] = UserEnum::SUCESS_UPDATED;
            return $response;
        }
        $response['error'] = 1;
        $response['message'] = UserEnum::ERR_USER_NOT_UPDATED;
        return $response;
    }

    public function destoy(int $id)
    {
        return $this->userRepository->delete($id);
    }
}
