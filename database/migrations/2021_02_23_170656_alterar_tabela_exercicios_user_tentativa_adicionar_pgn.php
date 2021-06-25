<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterarTabelaExerciciosUserTentativaAdicionarPgn extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('exercicio_user_tentativa', function (Blueprint $table) {
            $table->string('pgn')->nullable(true);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('exercicio_user_tentativa', function (Blueprint $table) {
            $table->dropColumn('pgn');
        });
    }
}
