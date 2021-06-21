<?php

namespace App\Http\Controllers;

use App\Models\Users;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class UsersController extends Controller
{

    private $model;
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(Users $users)
    {
        $this->model = $users;
    }

    public function show($id)
    {
        $user = $this->model->find($id);
        return response()->json($user, status: Response::HTTP_OK);
    }

    public function index()
    {
        $users = $this->model->all();
        return response()->json($users, status: Response::HTTP_OK);
    }

    public function store(Request $request)
    {
        $validatedData = $this->validate($request, [
            'name' => 'sometimes|string|max:255',
            'cpf_cnpj' => 'required|unique:users',
            'email' => 'required|email|unique:users|email:rfc,dns',
            'password' => 'required|min:8',
        ]);
        $users = $this->model->create($validatedData);
        $users = $this->model->save($validatedData);
        return response()->json($users, status: Response::HTTP_CREATED);
    }

    public function update($id, Request  $request)
    {
        $users = $this->model->find($id)
            ->update($request->all());
        return response()->json($users, status: Response::HTTP_ACCEPTED);
    }

    public function destoy($id, Request $request)
    {
        $users = $this->model->find($id)
            ->update($request->all());
        return response()->json($users, status: Response::HTTP_ACCEPTED);
    }


    //
}
