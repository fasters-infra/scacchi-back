<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Exercicios extends Model
{
    use SoftDeletes;

    protected $table = "exercicios";
    protected $fillable = [
        'name',
        'cod',
        'fen',
        'cor',
        'dica',
        'PGN',
        'step',
        'resolucao',
        'exercicio_categoria_id',
        'tema_id'
    ];

    public function exercicioCategoria()
    {
        return $this->belongsTo('App\Models\Exercicio_categoria','exercicio_categoria_id');
    }

    public function Temas()
    {
        return $this->belongsTo('App\Models\Tema','tema_id');
    }
}
