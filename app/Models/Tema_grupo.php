<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Tema_grupo extends Model
{
    use SoftDeletes;

    protected $table = "Tema_grupo";
    protected $fillable = ['name'];

    public function tema()
    {
        return $this->hasMany(Tema::class);
    }
}
