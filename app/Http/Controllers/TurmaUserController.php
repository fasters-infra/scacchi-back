<?php

namespace App\Http\Controllers;
use App\Models\Turma_user;
use App\Models\Turma;
use Illuminate\Http\Request;


class TurmaUserController extends BaseController
{
    public function __construct()
    {
        $this->classe = Turma_user::class;
    }

    // public function store(Request $request)
    // {
    //     $user = User::find($request->user_id);
    //     if(!is_null($user)){
    //         if($user->profile_id == 4){
    //             $professor = Turma_user::join('users', 'users.id','=','turma_user.user_id')
    //                             ->select('turma_user.id', 'turma_user.user_id','turma_user.turma_id')
    //                             ->where('users.profile_id','=','4')
    //                             ->where('turma_user.turma_id','=',$request->turma_id)
    //                             ->first();
    //             if(is_null($professor))
                    
    //         }
        
    //     }
    //     return Response()->json([$this->classe::create($request->all()),201]);
    // }

    public function ChangeTurmaProfessor(Request $request)
    {
        $this->validate($request, [
            'turma_id' => 'required',
            'user_id' => 'required'
        ]);
        
        $selectResult = Turma_user::join('users', 'users.id','=','turma_user.user_id')
                            ->select('turma_user.id', 'turma_user.user_id','turma_user.turma_id')
                            ->where('users.profile_id','=','4')
                            ->where('turma_user.turma_id','=',$request->turma_id)
                            ->first();

        $turma_users = Turma_user::find($selectResult->id);
        $turma_users->user_id = $request->user_id;
        $turma_users->save();

        return Response()->json([$turma_users,201]);
    }

    public function ChangeTurmaAluno(Request $request)
    {
        $this->validate($request, [
            'turma_id' => 'required',
            'user_id'=> 'required'
        ]);

        $aluno = Turma_User::where('user_id',$request->user_id)->first();
        $aluno->turma_id = $request->turma_id;
        $aluno->save();

        return Response()->json([$aluno,201]);
    }
}
