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
    return view('layouts.front');
});
// Route::get('/', 'PagesController@getNsa');

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
Route::get('/home/invoice', 'PagesController@getInvoice');
// Route::get('/home/front', 'PagesController@getFront');

Route::Resources(['post' => 'PostsController']);
Route::get('{path}',"HomeController@index")->where( 'path', '([A-z\d-\/_.]+)?' );

