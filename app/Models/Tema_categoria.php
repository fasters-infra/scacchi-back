<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Tema_categoria extends Model
{
    use SoftDeletes;

    protected $table = "tema_categoria";
    protected $fillable = ['name'];
    protected $hidden = array('pivot');

}
