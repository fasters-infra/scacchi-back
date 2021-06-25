<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CriarTabelaTurmaUser extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('turma_user', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('user_id')->unsigned()->nullable(false);
            $table->bigInteger('turma_id')->unsigned()->nullable(false);
            $table->softDeletes();
            $table->timestamps();
        });

        Schema::table('turma_user', function (Blueprint $table) {
            $table->foreign('turma_id')->references('id')->on('turmas');
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
        Schema::dropIfExists('turma_user');
    }
}
