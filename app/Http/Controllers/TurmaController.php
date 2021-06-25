<?php

namespace App\Http\Controllers;
use App\Models\Turma;
use App\Models\Enum;
use App\Models\Turma_user;
use App\Models\Enum\Profile;
use Illuminate\Http\Request;

class TurmaController extends BaseController
{
    public function __construct()
    {
        $this->classe = Turma::class;
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'cod' => 'required',
        ]);

        $unidadeId = $request->dados->unidadeId;

        if($request->dados->profileId == 1) //adm
            $unidadeId = $request->unidade_id;

        $postObj = ['cod'=>$request->cod, 'unidade_id'=> $unidadeId];
        $postObj = $this->classe::create($postObj);

        if($request->user_id != null)
            Turma_user::create(["user_id" => $request->user_id,"turma_id" => $postObj->id]);

        return Response()->json([$postObj,201]);
    }
}
