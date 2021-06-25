<?php

namespace App\Http\Controllers;
use App\Models\Exercicios;

class ExercicioController extends BaseController
{
    public function __construct()
    {
        $this->classe = Exercicios::class;
    }
}
