<?php

namespace App\Http\Controllers;

use App\Exceptions\Test2Exception;
use App\Exceptions\TestException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use League\Flysystem\Exception;
use Maatwebsite\Excel\Facades\Excel;

class ExceptController extends Controller
{
    //
    public function index(){

        throw new TestException('this is test Exception');
    }

    public function log(){
        Log::emergency("系统挂掉了");
        Log::alert("数据库访问异常");
        Log::critical("系统出现未知错误");
        Log::error("指定变量不存在");
        Log::warning("该方法已经被废弃");
        Log::notice("用户在异地登录");
        Log::info("用户xxx登录成功",['user_id'=>1]);
        Log::debug("调试信息");
    }

    public function checkCard(){
        $result = IdentityCard::make('35052119950228354x');

        if ( $result === false ) {

            return 'Your ID number is incorrect';
        }

        dd($result->toArray());
    }

    //Excel view
    public function get_excel(){

        $cellData = [
            ['学号','姓名','成绩'],
            ['10001','AAAAA','99'],
            ['10002','BBBBB','92'],
            ['10003','CCCCC','95'],
            ['10004','DDDDD','89'],
            ['10005','EEEEE','96'],
        ];
//        Excel::create('学生成绩',function($excel) use ($cellData){
//            $excel->sheet('score', function($sheet) use ($cellData){
//                $sheet->rows($cellData);
//            });
//        })->export('xls');
        return view('excel.get');
    }

    //post Excel
    public function post_excel(Request $request){
//        dd($request->bbb->path())
        $file = $request->bbb->path();

        $re =  Excel::load($file, function($reader) {
            $reader->noHeading(); //这一句
        })->get();
        dd($re);

    }

    public function excel(){
        $file = public_path().'/词汇分级表.xlsx';
        $re =  Excel::load($file, function($reader) {
            $reader->noHeading(); //这一句
        })->get();

//        for ($i=0;$i<count($re[0]))
        $item = $re[0][0][0];

        dd($item,$re,count($re));
    }
}
