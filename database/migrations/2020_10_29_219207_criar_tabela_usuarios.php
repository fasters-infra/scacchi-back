<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CriarTabelaUsuarios extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('cod');
            $table->string('cpf');
            $table->string('email');
            $table->string('password');
            $table->bigInteger('profile_id')->unsigned()->nullable(false)->default(1);
            $table->bigInteger('file_id')->unsigned()->nullable(true);
            $table->bigInteger('unidade_id')->unsigned()->nullable(true);
            $table->softDeletes();
            $table->timestamps();
        });

        Schema::table('users', function (Blueprint $table) {
            $table->foreign('profile_id')->references('id')->on('profiles');
             $table->foreign('file_id')->references('id')->on('files');
             $table->foreign('unidade_id')->references('id')->on('unidades');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');
    }
}
