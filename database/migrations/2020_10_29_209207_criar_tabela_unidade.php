<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CriarTabelaUnidade extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('unidades', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('cod');
            $table->string('cnpj')->unique();
            $table->string('cor_primaria');
            $table->string('cor_secundaria');
            $table->bigInteger('file_id')->unsigned()->nullable(true);
            $table->softDeletes();
            $table->timestamps();
        });

        Schema::table('unidades', function (Blueprint $table) {
             $table->foreign('file_id')->references('id')->on('files');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('unidades');

    }
}
