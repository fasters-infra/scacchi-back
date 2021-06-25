<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Turma_user extends Model
{
    use SoftDeletes;

    protected $table = "turma_user";
    protected $fillable = ['user_id','turma_id'];

    public function Turmas()
    {
        return $this->belongsTo('App\Models\Turma','turma_id');
    }

    public function Users()
    {
        return $this->belongsTo('App\Models\User','user_id');
    }

}
