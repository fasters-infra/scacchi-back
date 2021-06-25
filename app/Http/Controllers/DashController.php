<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Tema;
use App\Models\Unidade;

class DashController
{
    public function index(Request $request)
    {
        if($request->dados->profileId > 2)
            return response()->json('Não autorizado', 401);

        $now = date("Y-m-d H:i:s");
        $days30 = date("Y-m-d H:i:s", strtotime('-30 days'));
        $days60 = date("Y-m-d H:i:s", strtotime('-60 days'));


        $allUsers = User::all();
        $alunos_totais = $allUsers->where('profile_id', 5)->count();
        $alunos_recentes = $allUsers->where('profile_id', 5)->whereBetween('created_at', [$days60, $now])->count();
        $temas_totais = Tema::all()->count();
        $temas_recentes = Tema::whereBetween('created_at', [$days30, $now])->count();
        $unidades_totais = Unidade::all()->count();
        $unidades_recentes = Unidade::whereBetween('created_at', [$days60, $now])->count();
        $professores_recentes = $allUsers->where('profile_id', 4)->whereBetween('created_at', [$days60, $now])->count();
        $professores_totais =  $allUsers->where('profile_id', 4)->count();

        $resultObj = [
            'alunos_totais'=> $alunos_totais,
            'alunos_recentes'=> $alunos_recentes,
            'temas_totais'=> $temas_totais,
            'temas_recentes'=> $temas_recentes,
            'unidades_totais'=> $unidades_totais,
            'unidades_recentes'=> $unidades_recentes,
            'professores_totais' => $professores_totais,
            'professores_recentes' => $professores_recentes
        ];
        return Response()->json([$resultObj,201]);
    }
}
