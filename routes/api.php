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

/**
 * 以下 テスト
 * TODO: 後から削除する
 */

/*
Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

// users 全て取得
Route::get('/users', function() {
    return User::orderBy('id')->get();
});

// 1 件取得 uuid を指定すると ユーザを返す
// {user} = uuid の指定は User モデルの getRouteKeyName で指定する
// 存在しない場合は abort(404) が返る
Route::get('/users/{user}', function(User $user) {
    return $user;
});
*/
