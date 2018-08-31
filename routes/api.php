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
Route::get('/', function () {
    return ['status' => 'OK'];
});

Route::group(['prefix' => 'auth'], function () {
    Route::post('login', 'AuthController@login');
    Route::post('logout', 'AuthController@logout');
});

Route::post('users', 'UserController@store');

Route::group(['middleware' => 'auth:api'], function () {
    Route::get('users', 'UserController@list');
    Route::get('users/{id}', 'UserController@show');
    Route::put('users/{id}', 'UserController@update');

    Route::get('quits', 'QuitController@list');
    Route::get('quits/{id}', 'QuitController@show');
    Route::post('quits', 'QuitController@create');
    Route::put('quits/{id}', 'QuitController@update');
    Route::delete('quits/{id}', 'QuitController@destroy');

    Route::get('quits/{quit_id}/replies', 'ReplyController@list');
    Route::get('quits/{quit_id}/replies/{id}', 'ReplyController@show');
    Route::post('quits/{quit_id}/replies', 'ReplyController@create');
    Route::put('quits/{quit_id}/replies/{id}', 'ReplyController@update');
    Route::delete('quits/{quit_id}/replies/{id}', 'ReplyController@destroy');
});
