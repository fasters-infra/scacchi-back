<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\Tema_grupo;
use App\Models\Exercicio_user;
use App\Models\Exercicios;



class TemaGrupoController extends BaseController
{
    public function __construct()
    {
        $this->classe = Tema_grupo::class;
    }

    #region Personalized API'S

    public function Index(Request $request)
    {
        $profileId = $request->dados->profileId;
        $exeUser = [];

        if($profileId == 1 || $profileId == 3 || $profileId == 4){
            $exeUser = Exercicio_user::where('user_id',$request->userId)->get();
        }else{
            $exeUser = Exercicio_user::where('user_id',$request->dados->userId)->get();
        }

        $result = $this->classe::with('Tema')->get();
        $exe = Exercicios::all();

        foreach ($result as $key => $value) {
            $value->tema = TemaGrupoController::getExecAndConcluded($value->tema,$exe,$exeUser);
        }
        return Response()->json($result, 200);
    }

    #endregion

    #region Private

    #region Index()

    private static function getExecAndConcluded($temas,$exec,$exeUser)
    {
        foreach ($temas as $key => $value) {
            $myexec = collect($exec)->where('tema_id', $value->id);
            $value->exercicios = TemaGrupoController::getExecUser($myexec,$exeUser);
            $value->count = $myexec->count();
            $value->concluded = TemaGrupoController::getConcluded($myexec,$exeUser);
        }
        return $temas;
    }

    private static function getExecUser($exec,$exeUser)
    {
        $keys = [];
        foreach ($exec as $key => $value) {
            $execUserByexecId = TemaGrupoController::transformToArray(collect($exeUser)->where('exercicio_id',$value->id));
            if($execUserByexecId == null){
                array_push($keys,$key);
            }
            $value->exercicioUser = $execUserByexecId;
        }
        
        foreach ($keys as $key => $value) {
            unset($exec[$value]);
        }

        // return $keys;
        return TemaGrupoController::transformToArray($exec);
    }

    private static function getConcluded($myexec, $exeUser)
    {
        $result = 0;
        foreach ($myexec as $key => $value) {
            $myexecUser = collect($exeUser)->where('exercicio_id',$value->id)->where('status',2);
            if($myexecUser->count() > 0)
                $result++;
        }
        return $result;
    }

    #endregion


    #region Geral functions

    public static function transformToArray($obj)
    {
        $array = [];
        foreach ($obj as $key => $value) {
            array_push($array,$value);
        }
        return $array;
    }

    #endregion

    #endregion
}
