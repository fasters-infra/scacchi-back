<?php

namespace App\Http\Controllers;

use App\Models\File;
use App\Models\Unidade;
use App\Models\Turma;
use App\Models\Tema;
use App\Models\Turma_user;
use App\Models\Exercicios;
use App\Models\Exercicio_user;
use App\Models\User;
use Illuminate\Http\Request;


class UnidadeController extends BaseController
{
    public function __construct()
    {
        $this->classe = Unidade::class;
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required'
        ]);

        $filename = str_replace(".", "", $request->cnpj);
        $filename = str_replace("/", "", $filename);
        $filename = str_replace("-", "", $filename);
        if ($request->file != null)
            $file = File::createFile($request->file, $filename, "Unidades");

        $postObj = [
            'name' => $request->name,
            'cod' => "000",
            'cnpj' => $request->cnpj,
            'cor_primaria' => $request->cor_primaria,
            'cor_secundaria' => $request->cor_secundaria,
            'file_id' => $file->id,
        ];
        return Response()->json([Unidade::create($postObj), 201]);
    }

    public function update(int $id, Request $request)
    {
        $recurso = $this->classe::find($id);
        if (is_null($recurso))
            return Response()->json('', 404);

        $recurso->fill($request->all());
        $filename = str_replace(".", "", $recurso->cnpj);
        $filename = str_replace("/", "", $filename);
        $filename = str_replace("-", "", $filename);
        if ($request->file != null)
            $recurso->file_id = File::createFile($request->file, $filename, "Unidades")->id;

        $recurso->save();
        return Response()->json($recurso, 200);
    }

    public function index(Request $request)
    {
        // $unidades = Unidade::with("Files");
        $unidades = Unidade::all();
        foreach ($unidades as $key => $unidade) {
            $file = $unidade->files;
            if (!is_null($file)) {
                $unidade->file = "http://skakiback.fasters.com.br/" . $unidade->files["path"] . $unidade->files["file"];
            }
            $unidade->turmas = Turma::where('unidade_id', $unidade->id)->get();
            foreach ($unidade->turmas as $key => $turma) {
                $ids = [];
                $turmaUsers  = Turma_user::where('turma_id', $turma->id)->get();
                foreach ($turmaUsers as $key => $turmaUser) {
                    array_push($ids, $turmaUser->user_id);
                }
                $alunos = User::where('profile_id', 5)->whereIn('id', $ids)->get();
                $turma->alunos = UnidadeController::getTemasAluno($alunos);
                $turma->progresso = UnidadeController::GetProgressoTurma($alunos);
                $turma->professor = User::where('profile_id', 4)->whereIn('id', $ids)->first();
                $turma->numero_alunos = $alunos->count();
            }
        }
        return Response()->json([$unidades, 200]);
    }

    public static function getTemasAluno($alunos)
    {
        foreach ($alunos as $key => $aluno) {

            $execUserConcluded = Exercicio_user::where('status', 2)
                ->where('user_id', $aluno->id)
                ->orderBy('updated_at', 'desc');

            $aluno->progresso = $execUserConcluded->count() . "/" . Exercicio_user::where('user_id', $aluno->id)->count();
            $lastexecUser = $execUserConcluded->first();
            if (!is_null($lastexecUser)) {
                $exec = Exercicios::where('id', $lastexecUser->exercicio_id)->first();
                if (!is_null($exec)) {
                    $tema = Tema::where('id', $exec->tema_id)->first();
                    if (is_null($tema)) {
                        $aluno->tema_atual = "tema excluído";
                    } else {
                        $aluno->tema_atual = $tema->name;
                    }
                }
            }
        }
        return $alunos;
    }

    public static function GetProgressoTurma($alunos)
    {
        $concluidos = 0;
        $total = 0;
        foreach ($alunos as $key => $aluno) {

            $concluidos += Exercicio_user::where('status', 2)
                ->where('user_id', $aluno->id)->count();

            $total += Exercicio_user::where('user_id', $aluno->id)->count();
        }
        return $concluidos . "/" . $total;
    }
}
