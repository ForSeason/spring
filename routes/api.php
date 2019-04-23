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

Route::post('/login', 'UserController@login');
Route::post('/user', 'UserController@register');
Route::patch('/user', 'UserController@patch')->middleware('check.token');
Route::post('/headpic', 'UserController@upload_head_pic')->middleware('check.token');
Route::post('/sayings', 'SayingsController@create')->middleware('check.token');
Route::get('/sayings', 'SayingsController@show_all');
