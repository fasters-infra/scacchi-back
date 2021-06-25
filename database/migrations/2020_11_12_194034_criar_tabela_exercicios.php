<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CriarTabelaExercicios extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('exercicios', function (Blueprint $table) {
            $table->id();
            $table->string('cod');
            $table->string('name');
            $table->string('fen');
            $table->string('PGN')->nullable(true);
            $table->string('resolucao')->nullable(true);
            $table->string('cor')->nullable(false);
            $table->string('dica')->nullable();
            $table->bigInteger('step');
            $table->bigInteger('exercicio_categoria_id')->unsigned()->nullable(false);
            $table->bigInteger('tema_id')->unsigned()->nullable(true);
            $table->softDeletes();
            $table->timestamps();
        });

        Schema::table('exercicios', function (Blueprint $table) {
            $table->foreign('exercicio_categoria_id')->references('id')->on('exercicio_categoria');
            $table->foreign('tema_id')->references('id')->on('temas');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('exercicios');
    }
}
