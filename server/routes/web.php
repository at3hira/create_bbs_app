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

/*Route::get('/', function () {
    return view('welcome');
});*/

Route::get('/', 'ThreadsController@index')->name('top');
Route::resource('threads', 'ThreadsController', ['only' => ['create', 'store']]);
Route::resource('threads', 'ThreadsController', ['only' => ['create', 'store', 'show']]);
Route::resource('comments', 'CommentsController', ['only' => ['store']]);
Route::resource('threads', 'ThreadsController', ['only' => ['create', 'store', 'show', 'edit', 'update']]);

Auth::routes();

Route::group(['middleware' => 'auth'], function() {
    Route::get('/ope', 'HomeController@index');
});