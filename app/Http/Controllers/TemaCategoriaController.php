<?php

namespace App\Http\Controllers;
use App\Models\Tema_categoria;

class TemaCategoriaController extends BaseController
{
    public function __construct()
    {
        $this->classe = Tema_categoria::class;
    }
}
