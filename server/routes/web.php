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
// スレッド一覧画面
Route::get('/', 'ThreadsController@index')->name('threads.index');
// スレッド詳細
Route::get('threads/{id}', 'ThreadsController@show')->name('threads.show'); 
// 選択されたタグを含むスレッドを検索
Route::get('threads/tag_search/{id}', 'ThreadsController@tag_search')->where('product', '[0-9]+');
// キーワード検索
Route::get('/keyword_search', 'ThreadsController@keyword_search');
// コメント作成
Route::resource('comments', 'CommentsController', ['only' => ['store']]);
// 認証ログイン
Route::get('ope', 'Auth\LoginController@showLoginForm')->name('login');
Route::post('ope', 'Auth\LoginController@login');


//Auth::routes();
Route::group(['middleware' => 'auth'], function() {
    // ログインダッシュボード
    Route::get('/ope/home', 'HomeController@index')->name('home');
    // ログアウト
    Route::post('ope/logout', 'Auth\LoginController@logout')->name('logout');
    // ユーザー登録
    Route::get('ope/register', 'Auth\RegisterController@showRegistrationForm')->name('register');
    Route::post('ope/register', 'Auth\RegisterController@register');
    // パスワード
    Route::get('ope/password/reset', 'Auth\ForgotPasswordController@showLinkRequestForm')->name('password.request');
    Route::post('ope/password/email', 'Auth\ForgotPasswordController@sendResetLinkEmail')->name('password.email');
    Route::get('ope/password/reset/{token}', 'Auth\ResetPasswordController@showResetForm')->name('password.reset');
    Route::post('ope/password/reset', 'Auth\ResetPasswordController@reset')->name('password.update');
    // スレッド作成
    Route::get('/create', 'ThreadsController@create');
    Route::post('/', 'ThreadsController@store')->name('threads.store'); 
    // スレッド編集
    Route::get('threads/{id}/edit', 'ThreadsController@edit')->name('threads.edit');
    // submitボタンの処理ハンドリング
    Route::put('threads/post_process/{id}', 'ThreadsController@post_process')->name('threads.post_process');
});

