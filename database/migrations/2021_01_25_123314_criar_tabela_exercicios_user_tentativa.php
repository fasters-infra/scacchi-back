<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CriarTabelaExerciciosUserTentativa extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('exercicio_user_tentativa', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('exercicio_user_id')->unsigned()->nullable(false);
            $table->bigInteger('tentativa')->unsigned()->default(0);
            $table->string('fen')->nullable(false);
            $table->softDeletes();
            $table->timestamps();
        });

        Schema::table('exercicio_user_tentativa', function (Blueprint $table) {
            $table->foreign('exercicio_user_id')->references('id')->on('exercicio_user');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('exercicio_user_tentativa');

    }
}
