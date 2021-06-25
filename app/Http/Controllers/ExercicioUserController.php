<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Exercicio_user;
use App\Models\Exercicio_user_tentativa;

class ExercicioUserController extends BaseController
{
    public function __construct()
    {
        $this->classe = Exercicio_user::class;
    }

    public function update(int $id, Request $request)
    {
        $recurso = $this->classe::find($id);

        if (is_null($recurso))
            return Response()->json('', 404);

        $recurso->update($request->all());
        $recurso->save();

        $hasData = Exercicio_user_tentativa::where('tentativa', $request->tentativa)->where('exercicio_user_id', $id)->first();
        if (is_null($hasData)) {
            if ($request->tentativa > 0) {
                Exercicio_user_tentativa::create([
                    'exercicio_user_id' => $id,
                    'tentativa' => $request->tentativa,
                    'fen' => $request->fen,
                    'pgn' => $request->pgn
                ]);
            }
        } else {
            $hasData->update([
                'fen' => $request->fen,
                'pgn' => $request->pgn
            ]);
        }

        return Response()->json($recurso, 200);
    }

    public function index(Request $request)
    {
        $recurso = $this->classe::all();

        foreach ($recurso as $key => $value) {
            $value->user_tentativa = Exercicio_user_tentativa::where('exercicio_user_id', $value->id)->get();
        }

        return Response()->json($recurso, 200);
    }

    public function show(int $id)
    {
        $recurso = $this->classe::find($id);

        if (is_null($recurso))
            return Response()->json('', 204);

        $recurso->user_tentativa = Exercicio_user_tentativa::where('exercicio_user_id', $id)->get();

        return Response()->json($recurso, 200);
    }
}
