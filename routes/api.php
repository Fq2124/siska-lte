<?php

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

$router->group(['prefix' => 'api', 'namespace' => 'Api'], function ($router) {

    $router->group(['prefix' => 'SISKA', 'middleware' => 'partner'], function ($router) {
        $router->group(['prefix' => 'seekers'], function ($router) {
            $router->put('update', 'APIController@updateSeekers');
            $router->delete('delete', 'APIController@deleteSeekers');
        });

        $router->group(['prefix' => 'vacancies'], function ($router) {
            $router->post('create', 'APIController@createVacancies');
            $router->put('update', 'APIController@updateVacancies');
            $router->delete('delete', 'APIController@deleteVacancies');
        });
    });

    /**
     * Route untuk query search vacancy
     * di halaman search vacancy
     */
    $router->get('vacancies/search', [
        'uses' => 'APIController@getSearchResult',
        'as' => 'get.search.vacancy'
    ]);

    $router->get('vacancies/search/{keyword}', [
        'uses' => 'APIController@getKeywordVacancy',
        'as' => 'get.keyword.vacancy'
    ]);

    /**
     * Mohon tidak melakukan perubahan apapun pada
     * routing berikut! Terimakasih :)
     */
    $router->get('credentials', [
        'uses' => 'APIController@getCredentials',
        'as' => 'get.credentials'
    ]);

});
