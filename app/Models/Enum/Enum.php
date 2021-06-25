<?php

namespace App\Models\Enum;

Abstract class Profile
{
    const Administrador = 1;
    const Investidor = 2;
    const Coordenador = 3;
    const Professor = 4;
    const Aluno = 5;
};

Abstract class Exercicio_categoria
{
    const PGN = 1;
    const Livre = 2;
};

Abstract class Tema_categoria
{
    const Geral = 1;
    const Privado = 2;
};

Abstract class ExercicioStatus
{
    const NaoIniciado = null;
    const EmAndamento = 1;
    const Concluido = 2;
    const Falha = 3;

};
