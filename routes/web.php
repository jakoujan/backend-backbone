<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::post('/api/security/login', 'Security\SecurityController@authenticate');

Route::post('/api/customers/list', 'Api\CustomerController@index')->middleware('auth:api');
Route::post('/api/customers/save', 'Api\CustomerController@save')->middleware('auth:api');
Route::post('/api/customers/delete', 'Api\CustomerController@delete')->middleware('auth:api');

Route::post('/api/users/list', 'Api\UserController@index')->middleware('auth:api');
Route::get('/api/users/exists/{user}', 'Api\UserController@exists')->middleware('auth:api');
Route::post('/api/users/save', 'Api\UserController@save')->middleware('auth:api');
Route::post('/api/users/delete', 'Api\UserController@delete')->middleware('auth:api');

