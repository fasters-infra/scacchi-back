<?php

namespace App\Http\Controllers;
use App\Models\Exercicio_categoria;

class ExercicioCategoriaController extends BaseController
{
    public function __construct()
    {
        $this->classe = Exercicio_categoria::class;
    }
}
