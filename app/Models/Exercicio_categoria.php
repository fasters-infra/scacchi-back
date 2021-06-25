<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Exercicio_categoria extends Model
{
    use SoftDeletes;

    protected $table = "Exercicio_categoria";
    protected $fillable = ['name'];
    protected $hidden = array('pivot');
}
