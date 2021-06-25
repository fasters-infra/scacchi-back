<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Exercicio_user extends Model
{
    use SoftDeletes;

    protected $table = "exercicio_user";
    protected $fillable = ['exercicio_id','user_id','status','tentativa','PGN'];


    public function Users()
    {
        return $this->belongsTo('App\Models\User','user_id');
    }

    public function Exercicios()
    {
        return $this->belongsTo('App\Models\Exercicios','exercicio_id');
    }
}
