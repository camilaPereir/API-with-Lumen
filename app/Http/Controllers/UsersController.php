<?php

namespace App\Http\Controllers;

use App\Models\Users;
use App\Models\Wallet;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Symfony\Component\HttpFoundation\Response;

class UsersController extends Controller
{

    private $model;
    private $wallet;
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(Users $users, Wallet $wallet)
    {
        $this->model = $users;
        $this->wallet = $wallet;
    }

    public function show($id)
    {
        //retornar o usuario com o valor que tem em carteira
        $user = $this->model->find($id);
        $wallet = $this->model->find($id);
        //if ($wallet->id && $user->id) {
            $return = ["id" => $user->id, "name" => $user->name, "cpf_cnpj" => $user->cpf_cnpj, "email" => $user->email, "type_id" => $user->type_id, "value" => $wallet->value];
            return response()->json($return, status: Response::HTTP_OK);
       // } else {
            return response()->json($user, status: Response::HTTP_OK);
        //}
    }

    public function index()
    {
        $users = $this->model->all();
        return response()->json($users, status: Response::HTTP_OK);
    }

    public function store(Request $request)
    {
        $validatedData = $this->validate($request, [
            'name' => 'required|string|max:255',
            'cpf_cnpj' => 'required|unique:users',
            'email' => 'required|email|unique:users|email:rfc,dns',
            'password' => 'required|min:8',
            'type_id' => 'required|exists:type,id'
        ]);
        DB::beginTransaction();
        $users = $this->model->create($validatedData);
        if ($users->id) {
            $wallet = $this->wallet->create(["id_users" => $users->id, "value" => 100.00]);
            if ($wallet->id) {
                $return = ["id" => $users->id, "name" => $users->name, "cpf_cnpj" => $users->cpf_cnpj, "email" => $users->email, "type_id" => $users->type_id, "value" => $wallet->value];
                DB::commit();
                return response()->json($return, status: Response::HTTP_CREATED);
            } else {
                DB::rollback();
            }
        } else {
            DB::rollback();
        }
    }

    public function update(int $id, Request  $request)
    {
        $validatedData = $this->validate($request, [
            'name' => 'sometimes|string|max:255',
            'cpf_cnpj' => 'sometimes|unique:users',
            'email' => 'sometimes|email|unique:users|email:rfc,dns',
            'password' => 'sometimes|min:8',
            'type_id' => 'sometimes|exists:type,id'
        ]);

        $users = $this->model->find($id)
            ->update($validatedData);

        return response()->json($users, status: Response::HTTP_OK);
    }

    public function destoy(int $id, Request $request)
    {
        $users = $this->model->find($id)
            ->update($request->all());
        return response()->json($users, status: Response::HTTP_OK);
    }

    //
}
