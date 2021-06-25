<?php

/** @var \Laravel\Lumen\Routing\Router $router */

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It is a breeze. Simply tell Lumen the URIs it should respond to
| and give it the Closure to call when that URI is requested.
|
*/


$router->get('/', function () use ($router) {
    return $router->app->version();
});

$router->post('api/users','UserController@store');
$router->post('api/login','TokenController@geraToken');

$router->group(['prefix'=>'api', 'middleware' => 'auth'], function($router) {

    // $router->group(['middleware' => 'Adm'], function($router) {

        $router->group(['prefix'=>'profile'], function($router) {
            $router->get('','profileController@index');
            $router->post('','profileController@store');
            $router->get('{id}','profileController@show');
            $router->put('{id}','profileController@update');
        });

        $router->group(['prefix'=>'users'], function($router) {
            $router->get('','UserController@index');
            $router->get('{id}','UserController@show');
            $router->put('{id}','UserController@update');
            $router->delete('{id}','UserController@destroy');
            $router->post('storeWithTurma','UserController@storeWithTurma');
            $router->post('testeEmail','UserController@testeEmail');
            $router->post('AddCsvUser','UserController@Addusers');
        });

        $router->group(['prefix'=>'unidades'], function($router) {
            $router->get('','unidadeController@index');
            $router->post('','unidadeController@store');
            $router->get('{id}','unidadeController@show');
            $router->put('{id}','unidadeController@update');
            $router->delete('{id}','unidadeController@destroy');
        });

        $router->group(['prefix'=>'turma'], function($router) {
            $router->get('','turmaController@index');
            $router->post('','turmaController@store');
            $router->get('{id}','turmaController@show');
            $router->put('{id}','turmaController@update');
            $router->delete('{id}','turmaController@destroy');
        });

        $router->group(['prefix'=>'turmaUser'], function($router) {
            $router->get('','TurmaUserController@index');
            $router->post('','TurmaUserController@store');
            $router->get('{id}','TurmaUserController@show');
            $router->put('{id}','TurmaUserController@update');
            $router->delete('{id}','TurmaUserController@destroy');
            $router->post('ChangeTurmaProfessor','TurmaUserController@ChangeTurmaProfessor');
            $router->post('ChangeTurmaAluno','TurmaUserController@ChangeTurmaAluno');
        });


        $router->group(['prefix'=>'tema'], function($router) {
            $router->get('','temaController@index');
            $router->post('','temaController@store');
            $router->get('{id}','temaController@show');
            $router->put('{id}','temaController@update');
            $router->delete('{id}','temaController@destroy');
            $router->post('Associate','temaController@associateTemaTurma');
        });

        $router->group(['prefix'=>'temaGrupo'], function($router) {
            $router->get('','temaGrupoController@index');
            $router->post('','temaGrupoController@store');
            $router->get('{id}','temaGrupoController@show');
            $router->put('{id}','temaGrupoController@update');
            $router->delete('{id}','temaGrupoController@destroy');
        });

        $router->group(['prefix'=>'exercicios'], function($router) {
            $router->get('','exercicioController@index');
            $router->post('','exercicioController@store');
            $router->get('{id}','exercicioController@show');
            $router->put('{id}','exercicioController@update');
            $router->delete('{id}','exercicioController@destroy');
        });

        $router->group(['prefix'=>'exercicioUser'], function($router) {
            $router->get('','ExercicioUserController@index');
            $router->post('','ExercicioUserController@store');
            $router->get('{id}','ExercicioUserController@show');
            $router->put('{id}','ExercicioUserController@update');
            $router->delete('{id}','ExercicioUserController@destroy');
        });

        $router->group(['prefix'=>'exercicioUserTentativa'], function($router) {
            $router->get('','ExercicioUserTentativaController@index');
            $router->post('','ExercicioUserTentativaController@store');
            $router->get('{id}','ExercicioUserTentativaController@show');
            $router->put('{id}','ExercicioUserTentativaController@update');
            $router->delete('{id}','ExercicioUserTentativaController@destroy');
        });

        $router->group(['prefix'=>'dashboard'], function($router) {
            $router->get('','DashController@index');
        });

    // });

});

