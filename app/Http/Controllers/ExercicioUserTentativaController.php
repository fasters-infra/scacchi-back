<?php

namespace App\Http\Controllers;
use App\Models\Exercicio_user_tentativa;

class ExercicioUserTentativaController extends BaseController
{
    public function __construct()
    {
        $this->classe = Exercicio_user_tentativa::class;
    }
}
