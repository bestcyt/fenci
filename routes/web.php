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


////测试导入excl
//Route::get('get_excel',function () {
//    return view('get');
//});
//
//Route::post('post_excel','ExceptController@post_excel')->name('excel.post');
//
//Route::get('excel','ExceptController@excel');

Route::group(['prefix'=>'admin','namespace'=>'Admin','middleware'=>'auth'] , function ($route){

    //获取缓存词汇库
    $route->get('word/cache','WordController@getCache');

    $route->get('word/index','WordController@index'); // 词汇列表
    $route->get('word/create','WordController@create'); //重传词汇
    $route->get('word/truncate','WordController@truncate'); //清空词汇
    $route->get('word/updateWordCache','WordController@updateWordCache'); //清空词汇
    $route->post('word/store','WordController@store'); //保存词汇

    //功能1：文章分级标注并导出
    $route->get('article/create','ArticleController@create'); //重传词汇
    $route->post('article/store','ArticleController@store'); //保存词汇
    $route->post('article/ppl','ArticleController@ppl'); //保存词汇

});


