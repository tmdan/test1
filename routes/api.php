<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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



Route::post('login', 'AuthController@logIn');
Route::post('singin', 'AuthController@singIn');


Route::group([
    'middleware' => ['auth:sanctum']
], function () {


    Route::group([
        'prefix' => 'books',
    ], function () {
        Route::get('/', 'BookController@index');
        Route::post('/', 'BookController@store');
        Route::get('/{book}', 'BookController@show');
    });


    Route::group([
        'prefix' => 'authors',
    ], function () {
        Route::post('/', 'AuthorController@store');
        Route::get('/{author}/books', 'AuthorController@show');
    });

});
