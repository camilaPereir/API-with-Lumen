<?php

namespace App\Http\Controllers;

use App\Models\Type;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class TypeController extends Controller
{

    private $model;
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(Type $type)
    {
        $this->model = $type;
    }

    public function index()
    {
        $type = $this->model->all();
        return response()->json($type, status: Response::HTTP_OK);
    }

    public function store(Request $request)
    {
        $validatedData = $this->validate($request, [
            'description' => 'required|string|max:255'
        ]);
        $type = $this->model->fill($validatedData)->save();
        return response()->json($type, status: Response::HTTP_CREATED);
    }

    public function update($id, Request  $request)
    {
        $type = $this->model->find($id)
            ->update($request->all());
        return response()->json($type, status: Response::HTTP_OK);
    }

    public function destoy($id, Request $request)
    {
        $type = $this->model->find($id)
            ->update($request->all());
        return response()->json($type, status: Response::HTTP_NO_CONTENT);
    }
}
