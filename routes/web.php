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
    return view('product');
});

Route::post('product/create', 'ProductController@save_data')->name('post.data');
Route::post('product/update', 'ProductController@update_data')->name('update.data');
Route::post('product/delete', 'ProductController@delete_data');
Route::post('product/edit', 'ProductController@edit_data');

Route::get('product/data','ProductController@getData');
