<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Firebase\JWT\JWT;
use App\Models\User;

class TokenController extends Controller
{
    public function geraToken(Request $request)
    {
        $this->validate($request, [
            'password' => 'required'
        ]);
        
        if(!is_null($request->cpf))
            $user = User::where('cpf',$request->cpf)->first();
        
        if(!is_null($request->cod))
            $user = User::where('cod', $request->cod)->first();

        if(is_null($user))
            return response()->json(['msg' =>'usuário não encontrado'], 500);

        if(!Hash::check($request->password, $user->password))
            return response()->json(['msg' =>'senha inválida'], 500);

        $issuedAt = time();
        // jwt valid for 1 days (60 seconds * 60 minutes * 24 hours)
        $expirationTime = $issuedAt + 60 * 60 * 24;
        return [
            'acess_token' => JWT::encode([
                'cpf' => $user->cpf,
                'profileId'=>$user->profile_id,
                'userId' => $user->id,
                'unidadeId' => $user->unidade_id,
                'iat' => $issuedAt,
                'exp' => $expirationTime
            ],env('JWT_KEY'),),
            'profile_id'=> $user->profile_id,
            'user_id' => $user->id,
            'unidade_id' =>$user->unidade_id
        ];
    }
}
