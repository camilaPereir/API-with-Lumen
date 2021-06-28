<?php

namespace App\Http\Controllers;

use App\Services\UserService;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class UserController extends Controller
{

    private $userService;
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    public function show(int $id)
    {
        $user = $this->userService->show($id);
        return response()->json($user, status: Response::HTTP_OK);
    }

    public function index()
    {
        $user = $this->userService->index();
        return response()->json($user, status: Response::HTTP_OK);
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

        $user = $this->userService->store($request->all());

        return response()->json($user, status: Response::HTTP_OK);
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

        $user = $this->userService->update($validatedData, $id);

        return response()->json($user, status: Response::HTTP_OK);
    }

    public function destoy(int $id, Request $request)
    {
        $user = $this->userService->destoy($id);
        return response()->json($user, status: Response::HTTP_OK);
    }
}
