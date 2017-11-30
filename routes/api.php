<?php

use Illuminate\Http\Request;

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

Route::get('/todos', 'TodoController@all');
Route::post('/todos', 'TodoController@add');
Route::post('/todos/{id}', 'TodoController@complete');
Route::post('/todos/{id}/star', 'TodoController@star');
Route::delete('/todos/{id}', 'TodoController@remove');