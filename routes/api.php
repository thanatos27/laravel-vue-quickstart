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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

/**
 * Display All Tasks
 */
Route::get('tasks', 'TaskController@index');

/**
 * Add A New Task
 */
Route::post('task', 'TaskController@store');

/**
 * Delete An Existing Task
 */
Route::delete('task/{id}', 'TaskController@destroy');
