<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Tema extends Model
{
    use SoftDeletes;

    protected $table = "temas";
    protected $fillable = ['name','cod','tema_categoria_id','user_id', 'user_name', 'profile_id', 'tema_grupo_id'];

    public function temaCategoria()
    {
        return $this->belongsTo('App\Models\Tema_categoria','tema_categoria_id');
    }

    public function temaGrupo()
    {
        return $this->belongsTo('App\Models\Tema_grupo','tema_grupo_id');
    }

    public function Users()
    {
        return $this->hasMany(User::class);
    }

    public function Exercicios()
    {
        return $this->hasMany('App\Models\Exercicios','tema_id','id');
    }
}
