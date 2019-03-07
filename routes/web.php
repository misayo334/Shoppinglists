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

// ユーザ登録
Route::get('signup', 'Auth\RegisterController@showRegistrationForm')->name('signup.get');
Route::post('signup', 'Auth\RegisterController@register')->name('signup.post');

// ログイン認証
Route::get('login', 'Auth\LoginController@showLoginForm')->name('login');
Route::post('login', 'Auth\LoginController@login')->name('login.post');
Route::get('logout', 'Auth\LoginController@logout')->name('logout.get');

// ユーザ機能
Route::group(['middleware' => ['auth']], function () {
    Route::resource('users', 'UsersController', ['only' => ['index', 'show']]);
    Route::resource('shoplists', 'ShoppingListsController');
    
    //リスト一覧
    Route::get('shoplists', 'ShoppingListsController@index')->name('shoplists.get');
    //リスト詳細
    Route::get('shoplists/{id}', 'ShoppingListsController@show')->name('shoplists.show');
    //新規リスト作成
    Route::get('shoplists/create', 'ShoppingListsController@create')->name('shoplists.create');
    //新規リスト保存
    Route::post('shoplists', 'ShoppingListsController@store')->name('shoplists.post');
    //リスト編集画面表示
    Route::get('shoplists/{id}/edit', 'ShoppingListsController@edit')->name('shoplists.edit');
    //リスト更新
    Route::put('shoplists/{id}', 'ShoppingListsController@update')->name('shoplists.update');
    

});
