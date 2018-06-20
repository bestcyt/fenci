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
    $route->get('word/outExcel','WordController@outExcel'); //导出词汇

    //功能1：文章分级标注并导出
    $route->get('article/create','ArticleController@create'); //文章界面
    $route->get('article/test','ArticleController@test'); //测试功能用
    $route->post('article/ppl','ArticleController@ppl'); //识别分词颜色
    $route->post('article/toWord','ArticleController@toWord'); //导出word

    //功能2：词频统计 导出word
    $route->match(['get','post'],'article/wordCount','ArticleController@wordCount'); //统计词频界面 + 导出Excel

    //功能3：段落释义 导出word
    $route->match(['get','post'],'article/wordMean','ArticleController@wordMean');
    $route->match(['get','post'],'article/wordCount','ArticleController@wordCount'); //统计词频界面 + 导出Excel

});


//test
Route::get('usersjson','TestController@getUserAt');
Route::get('gettest','TestController@gettest');


