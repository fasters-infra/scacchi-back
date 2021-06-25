<?php

namespace App\Http\Controllers;

use App\Mail\ResetPasswordMail;
use App\Models\User;
use App\Models\Turma_user;
use App\Models\Turma;
use App\Models\File;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;



class UserController extends BaseController
{
    public function __construct()
    {
        $this->classe = User::class;
    }

    public function store(Request $request)
    {
        $user = $this->classe::where('cpf', $request->cpf)->first();
        if ($request->profile_id != 5 && is_null($request->cpf))
            return Response()->json(['msg' => 'CPF é obrigatório nesse cadastro', 500]);
        if ($user != null)
            return Response()->json(['msg' => 'CPF já cadastrado no sistema'], 500);

        $postObj = [
            "name" => $request->name,
            "cod" => $request->cod,
            "cpf" => $request->cpf,
            "email" => $request->email,
            "password" => Hash::make($request->password),
            "profile_id" => $request->profile_id,
            "unidade_id" => $request->unidade_id
        ];
        if ($request->unidade_id == 0) {
            $postObj["unidade_id"] = null;
        }

        if ($request->nome_responsavel != null) {
            $postObj["nome_responsavel"] = $request->nome_responsavel;
        }

        if ($request->telefone_responsavel != null) {
            $postObj["telefone_responsavel"] = $request->telefone_responsavel;
        }

        if (!is_null($request->file)) {
            $data = File::createFile($request->file, $request->cpf, "Usuarios");
            $postObj["file_id"] = $data->id;
        }

        $this->classe::create($postObj);
        return Response()->json([$postObj, 201]);
    }

    public function update(int $id, Request $request)
    {
        $recurso = $this->classe::find($id);
        if (is_null($recurso))
            return Response()->json('', 404);

        $recurso->fill($request->all());
        if ($request->password != null || $request->password != '')
            $recurso->password = Hash::make($request->password);

        if ($request->file != null)
            $recurso->file_id = File::createFile($request->file, $recurso->cpf, "Usuarios")->id;

        $recurso->save();
        return Response()->json($recurso, 200);
    }

    public function storeWithTurma(Request $request)
    {
        $this->validate($request, [
            "name" => 'required',
            "cod" => 'required',
            "password" => 'required',
            "profile_id" => 'required',
            "turma_id" => 'required'
        ]);

        $user = $this->classe::where('cpf', $request->cpf)->first();
        $turma = Turma::where('id', $request->turma_id)->first();
        if ($request->profile_id != 5)
            return Response()->json(['msg' => 'CPF é obrigatório nesse cadastro', 500]);
        if ($user != null)
            return Response()->json(['msg' => 'CPF já cadastrado no sistema'], 500);

        if ($turma == null)
            return Response()->json(['msg' => 'Turma não cadastrada no sistema'], 500);

        $postObj = [
            "name" => $request->name,
            "cod" => $request->cod,
            "cpf" => $request->cpf,
            "email" => $request->email,
            "nome_responsavel" => $request->nome_responsavel,
            "telefone_responsavel" => $request->telefone_responsavel,
            "cpf_responsavel" => $request->cpf_responsavel,
            "endereco_responsavel" => $request->endereco_responsavel,
            "ano_letivo" => $request->ano_letivo,
            "serie_aluno" => $request->serie_aluno,
            "password" => Hash::make($request->password),
            "profile_id" => $request->profile_id
        ];
        $aluno = $this->classe::create($postObj);
        Turma_user::create([
            "user_id" => $aluno->id,
            "turma_id" => $request->turma_id
        ]);

        return Response()->json([$aluno, 201]);
    }

    public function index(Request $request)
    {
        return $this->classe::with('Unidades')->get();
    }

    public function show(int $id)
    {
        $recurso = $this->classe::with('Unidades')->find($id);

        if (is_null($recurso))
            return Response()->json('', 204);

        return Response()->json($recurso, 200);
    }

    public function Addusers(Request $request)
    {
        $constProfileAluno = 5;
        $error = false;
        $msgError = [];
        $tab_file = base64_decode($request->file);
        $encoding =  mb_detect_encoding($tab_file);
        $full_stats = explode("\n", str_replace("\r", "", $tab_file));
        $allUsers = Collect(User::all());
        $turmas = Collect(Turma::all());


        for ($i = 1; $i < count($full_stats); $i++) {
            $value = explode(",", $full_stats[$i]);
            if ($value[0] == "")
                continue;

            $validate = $this->classe::ValidatePlanilha($value, $msgError, $allUsers, $i);

            $msgError = $validate['msg'];
            $error = $validate['haserro'];

            if ($error)
                continue;

            $cod = rand(4, 8);

            $last2cpf = substr($value[2], -2);
            $mycod = $cod; //não vai ter mais cpf

            $newUser = new User([
                "name" => $value[0],
                "cod" => $mycod,
                "cpf" => $value[2],
                "email" => $value[3],
                "password" => Hash::make($value[4]),
                // "nome_responsavel" => $value[5],
                // "telefone_responsavel" => $value[6],
                "profile_id" => $constProfileAluno,
            ]);
            $newUser->save();
            $turma = Collect($turmas)->where('cod', $value[1])->first();
            Turma_user::create([
                "user_id" => $newUser->id,
                "turma_id" => $turma->id
            ]);
        }

        if ($error) {
            return response()->json([
                'success' => false,
                'msg' => 'Os seguintes campos estão inválidos',
                'data' => $msgError
            ], 500);
        }

        return response()->json(['success' => true, 'msg' => 'Criação dos usuários executada com sucesso']);
    }

    public function testeEmail(Request $request)
    {
        $result = Mail::to("christopher@fasters.com.br")->send(new ResetPasswordMail(
            [
                "email" => "kitoto.oliveira@gmail.com",
                "name" => "Christopher de Oliveira",
                "link" => "link:123456",
            ]
        ));
        return response()->json(['success' => true, 'data' => $result]);
    }
}
