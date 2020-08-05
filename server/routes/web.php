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


Auth::routes();
Route::group(['middleware' => 'auth'], function() {
    // 認証ログイン
    Route::get('/ope', 'HomeController@index');
    // スレッド作成
    Route::get('/create', 'ThreadsController@create');
    Route::post('/', 'ThreadsController@store')->name('threads.store'); 
    // スレッド編集
    Route::get('threads/{id}/edit', 'ThreadsController@edit')->name('threads.edit');
    Route::put('threads/{id}', 'ThreadsController@update')->name('threads.update'); 
    // スレッド削除
    //Route::delete('threads/{id}', 'ThreadsController@destroy')->name('threads.destroy');    
});

