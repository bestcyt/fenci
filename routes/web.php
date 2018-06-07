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


//测试导入excl
Route::get('get_excel',function () {
    return view('get');
});

Route::post('post_excel','ExceptController@post_excel')->name('excel.post');

Route::get('excel','ExceptController@excel');