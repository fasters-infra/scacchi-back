<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CriarTabelaTema extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('temas', function (Blueprint $table) {
            $table->id();
            $table->string('cod');
            $table->string('name');
            $table->bigInteger('tema_categoria_id')->unsigned()->nullable(false);
            $table->bigInteger('tema_grupo_id')->unsigned()->nullable(false);
            $table->bigInteger('user_id')->unsigned()->nullable(true);
            $table->softDeletes();
            $table->timestamps();
        });

        Schema::table('temas', function (Blueprint $table) {
            $table->foreign('tema_categoria_id')->references('id')->on('tema_categoria');
            $table->foreign('tema_grupo_id')->references('id')->on('tema_grupo');
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
        Schema::dropIfExists('temas');
    }
}
