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

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');


// TODO: create routes/admin.php and edit app/Providers/RouteServiceProvider.php
Route::prefix('admin')->group(function () {
    Route::prefix('api')->group(function () {
        Route::resource('user', 'Admin\UserController', ['only' => [
            'index', 'show', 'update', 'destroy',
        ]]);
    });
});
