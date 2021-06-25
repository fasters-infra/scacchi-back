<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Exercicio_user_tentativa extends Model
{
    use SoftDeletes;

    protected $table = "exercicio_user_tentativa";
    protected $fillable = ['exercicio_user_id','tentativa','fen','pgn'];


    public function Exercicio_user()
    {
        return $this->belongsTo('App\Models\Exercicio_user','exercicio_user_id');
    }
}
