<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CriarTabelaExerciciosUser extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('exercicio_user', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('user_id')->unsigned()->nullable(false);
            $table->bigInteger('exercicio_id')->unsigned()->nullable(false);
            $table->bigInteger('status')->unsigned()->nullable(true);
            $table->bigInteger('tentativa')->unsigned()->default(0);
            $table->string('PGN')->nullable(false);
            $table->softDeletes();
            $table->timestamps();
        });

        Schema::table('exercicio_user', function (Blueprint $table) {
            $table->foreign('exercicio_id')->references('id')->on('exercicios');
            $table->foreign('user_id')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('exercicio_user');

    }
}
