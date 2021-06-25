<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Turma extends Model
{
    use SoftDeletes;

    protected $table = "turmas";
    protected $fillable = ['name','cod','unidade_id'];

    public function Unidades()
    {
        return $this->belongsTo('App\Models\Unidade','unidade_id');
    }

    public function users()
    {   
        $turmaUsers  = Turma_user::where('turma_id', $this->id)->get();
        foreach ($turmaUsers as $key => $turmaUser) {
            $this->alunos = User::find($turmaUser->user_id);
        };

        return $this;
    }
}
