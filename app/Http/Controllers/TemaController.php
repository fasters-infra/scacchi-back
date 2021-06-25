<?php

namespace App\Http\Controllers;
use Auth;
use App\Models\Enum;
use App\Models\Tema;
use App\Models\Turma_user;
use App\Models\Exercicios;
use App\Models\Exercicio_user;
use App\Models\User;
use Illuminate\Http\Request;


class TemaController extends BaseController
{
    public function __construct()
    {
        $this->classe = Tema::class;
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required'
        ]);

        if($request->dados->userId == null)
            return response()->json('Não autorizado', 401);

        $cat = 2;
        if($request->dados->profileId == 1)
            $cat = 1;

            // $id = $request->dados->userId;

            $user = Auth::user();
    
            $nome = Auth::user()->name;
            
            $profile = Auth::user()->profile_id;

        $postObj = [
            'name'=> $request->name,
            'cod'=> $request->cod,
            'tema_categoria_id'=> $cat,
            'user_id'=> $request->dados->userId,
            'user_name' => $nome,
            'profile_id' => $profile,
            'tema_grupo_id' => $request->tema_grupo_id
        ];

        return Response()->json([$this->classe::create($postObj),201]);
    }

    public function index(Request $request)
    {
        return $this->classe::with('Exercicios')->with('temaGrupo')->get();
    }

    public function destroy(int $id)
    {
        $recurso = $this->classe::destroy($id);
        TemaController::DestroyExerciciosTema($id);
        if($recurso == 0)
            return Response()->json(['msg'=>'recurso não encontrado'], 404);

        return Response()->json(["msg"=> "recurso removido com sucesso"], 200);
    }

    public function associateTemaTurma(Request $request)
    {
        $this->validate($request, [
            'turma_ids' => 'required',
            'tema_id' => 'required'
        ]);

        
        if(!is_array($request->turma_ids))
            return Response()->json(["msg"=> "turma_ids necessita ser um array", "data"=>$request->turma_ids], 402);

            
        $exercicios = Exercicios::where('tema_id',$request->tema_id)->get();
        foreach($request->turma_ids as $key => $id)
        {
            $alunos = Turma_user::where('turma_id',$id)->get();
            foreach($alunos as $key => $aluno)
            {
                foreach ($exercicios as $key => $exercicio) {
                    $hasExecUser = Exercicio_user::where('exercicio_id',$exercicio->id )->where('user_id')->get();
                    
                    if(!$hasExecUser->count() > 0){
                        Exercicio_user::create([
                            'exercicio_id' => $exercicio->id,
                            'user_id' => $aluno->user_id,
                            'Status' => 0,
                            "PGN" => " "
                        ]);
                    };
                }
            }
        }
        return response()->json(['data'=> $hasExecUser->count(),'msg'=>'Associação feita com sucesso'], 200);
    }

    public static function DestroyExerciciosTema($tema_id)
    {
        $exercicios = Exercicios::where('tema_id',$tema_id)->get();
        foreach ($exercicios as $key => $value) {
            Exercicios::destroy($value->id);
        }
    }
    
}
