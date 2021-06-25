<?php

namespace App\Models;

use Illuminate\Auth\Authenticatable;
use Illuminate\Contracts\Auth\Access\Authorizable as AuthorizableContract;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Lumen\Auth\Authorizable;
use Illuminate\Database\Eloquent\SoftDeletes;


class User extends Model implements AuthenticatableContract, AuthorizableContract
{
    use Authenticatable, Authorizable, HasFactory;
    use SoftDeletes;

    protected $appends = ['file'];
    protected $table = "users";
    // protected $hidden = ['pivot'];
    protected $fillable = [
        'name', 'email','password','cpf','cod', 'nome_responsavel', 'telefone_responsavel', 'cpf_responsavel', 'endereco_responsavel', 'ano_letivo', 'serie_aluno', 'unidade_id','profile_id','file_id'
    ];

    public function Profiles()
    {
        return $this->belongsTo('App\Models\Profile','profile_id');
    }

    public function Unidades()
    {
        return $this->belongsTo('App\Models\Unidade','unidade_id');
    }

    public function Files()
    {
        return $this->belongsTo('App\Models\File','file_id');
    }

    public static function Turmas()
    {
        return $this->belongsToMany(Turma::class, 'turma_user', 'user_id', 'turma_id');;
    }

    public function getfileAttribute()
    {
        if(is_null($this->file_id))
            return "";
            
        $file = File::find($this->file_id);
        return "http://skakiback.fasters.com.br/".$file["path"].$file["file"];
    }

    public static function ValidatePlanilha($value, $msgError,$allUsers,$i)
    {
        $error = false;
        if(is_null($value[0])){
            array_push($msgError,"Campo Nome na linha: ".$i." não pode ser vazia");
            $error = true;
        }
    
        if(is_null($value[1])){
            array_push($msgError,"Campo Código na linha: ".$i." não pode ser vazia");
            $error = true;
        }
        
        if(is_null($value[2])){
            array_push($msgError,"Campo CPF na linha: ".$i." não pode ser vazia");
            $error = true;
        }

        if(!is_null( Collect($allUsers)->where('cpf',$value[2] )->first()  )  ){
            array_push($msgError,"Campo CPF na linha: ".$i." já cadastrado no sistema");
            $error = true;
        }
        
        if(is_null($value[3])){
            array_push($msgError,"Campo Email na linha: ".$i." não pode ser vazia");
            $error = true;
        }

        if(is_null($value[4])){
            array_push($msgError,"Campo Password na linha: ".$i." não pode ser vazia");
            $error = true;
        }

        return [
            "msg" => $msgError,
            "haserro" => $error
        ];

    } 
}
