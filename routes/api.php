<?php

use Illuminate\Http\Request;
use App\Model\User;
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

// auth:api = laravel passport
Route::group(['middleware' => ['auth:api']], function () {
    Route::prefix('v1')->group(function () {

        Route::get('/user', function (Request $request) {
            return $request->user();
        });

        Route::get('dashboard', 'Api\DashboardController@dashboard');

        Route::resource('anniv', 'Api\AnnivController',['only' => [
            'index', 'show', 'store', 'update', 'destroy',
        ]]);

        Route::resource('group', 'Api\GroupController',['only' => [
            'index', 'show', 'store', 'update', 'destroy',
        ]]);

    });
});
