<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;

class WordController extends Controller
{

   public function __construct(){
       ini_set('max_execution_time', '0');
   }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //获取缓存的数据
        $words_cache  = Cache::get('words');
        if (!$words_cache){
            flash('请先导入词汇','danger')->important();
            return back();
        }

        return view('admin.word.index',['words'=>$words_cache]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.word.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
        set_time_limit(0);

        DB::table('words')->truncate();

        $file = $request->file('word_excel')->path();
        $re =  Excel::load($file, function($reader) {
            $reader->noHeading(); //这一句
        })->get();

        //dd(count($re));
        //重新录
        $insert_array = $ar = [];

        //整理成数组格式
        for ($i=0;$i<count($re);$i++){
            $tem = $re[$i]->toArray(); //集合转为数组
            $ar[$i][0] = trim($tem[0]);
            $ar[$i][1] = trim($tem[1]);
            $ar[$i][2] = intval($tem[2]);
            $ar[$i][3] = trim($tem[3]);
            $ar[$i][4] = intval($tem[4]);
        }

        //整理成插入数据库的格式
        $time = date('Y-m-d H:m:i',time());
        for ($i=0;$i<count($ar);$i++){
            $insert_array[$i]['word'] = $ar[$i][0];
            $insert_array[$i]['mean'] = $ar[$i][1];
            $insert_array[$i]['level'] = $ar[$i][2];
            $insert_array[$i]['zanwu'] = $ar[$i][3];
            $insert_array[$i]['code'] = $ar[$i][4];
            $insert_array[$i]['created_at'] = $time;
        }

        //插入数据库
        DB::table('words')->insert($insert_array);

        foreach ($insert_array as $array_one=>&$value){
            $value['id'] = $array_one+1;
        }

        //缓存词汇
        Cache::forever('words',$insert_array);

        flash('导入成功','success')->important();
        return back();
    }

    /*
     * 刷新缓存
     */
    public function updateWordCache(){
        $words = DB::table('words')->get()->map(function ($value) {
            return (array)$value;
        })->toArray();
        Cache::flush();
        Cache::forever('words',$words);
        flash('刷新缓存成功','success')->important();
        return redirect()->to('admin/word/index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        DB::table('words')->truncate();
    }

    public function truncate(){
        DB::table('words')->truncate();

        flash('清空成功','success')->important();
        return back();
    }

    public function getCache(){

        dd(Cache::get('words'));
    }

    //导出参数
    public function outExcel(){
        $header = [['词汇','释义','等级','编码']];
        $cihui = \Illuminate\Support\Facades\Cache::get('words');
        $sheet1 = $sheet2 = $sheet3 = $sheet4 = $sheet5 = [];

        for ($i=0;$i<count($cihui);$i++){
            unset($cihui[$i]['id']);
            unset($cihui[$i]['created_at']);
            unset($cihui[$i]['zanwu']);
            //导出Excel 如果第一个字母是 = ，那要再加个单引号才行
            if (strpos($cihui[$i]['mean'],'=') == 0){
                $cihui[$i]['mean'] = "'".$cihui[$i]['mean'];
            }
            $sheet1[$i] = $cihui[$i];
        }
        $sheet1 = array_merge($header,$sheet1);

        Excel::create('词汇库',function($excel) use ($sheet1){
            $excel->sheet('词汇', function($sheet) use ($sheet1){
                $sheet->rows($sheet1);
            });

        })->export('xls');
    }
    




}
