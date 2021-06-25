<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;

abstract class BaseController extends Controller
{
    protected $classe;

    public function index(Request $request)
    {
        return $this->classe::all();
    }

    public function store(Request $request)
    {
        return Response()->json([$this->classe::create($request->all()),201]);
    }

    public function update(int $id, Request $request)
    {
        $recurso = $this->classe::find($id);

        if(is_null($recurso))
            return Response()->json('', 404);

        $recurso->fill($request->all());
        $recurso->save();
        return Response()->json($recurso, 200);
    }

    public function show(int $id)
    {
        $recurso = $this->classe::find($id);

        if(is_null($recurso))
            return Response()->json('', 204);

        return Response()->json($recurso, 200);
    }

    public function destroy(int $id)
    {
        $recurso = $this->classe::destroy($id);
        if($recurso == 0)
            return Response()->json(['msg'=>'recurso não encontrado'], 404);

        return Response()->json(["msg"=> "recurso removido com sucesso"], 200);
    }
}
