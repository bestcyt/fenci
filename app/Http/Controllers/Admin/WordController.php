<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Maatwebsite\Excel\Facades\Excel;

class WordController extends Controller
{

    public function index()
    {
        //获取缓存的数据
        $words_cache  = Cache::get('words');
        if (!$words_cache){
            flash('请先导入词汇','danger')->important();
            return back();
        }

        $levels = Cache::get('levels');

        $ws = DB::table('words')->paginate(20);

        //$collection = new Collection($moments);
        //返回的分页数据
        //$currentPageSearchResults = array_values($collection->slice(($page-1)*$perPage,$perPage)->all());

        return view('admin.word.index',['words'=>$ws]);
    }


    public function create()
    {
        return view('admin.word.create');
    }

    //获取随机颜色
    public  function randColor(){
        $colors = array();
        for($i = 0;$i<6;$i++){
            $colors[] = dechex(rand(0,15));
        }
        return implode('',$colors);
    }

    public function store(Request $request)
    {
        set_time_limit(0);
        //按多个等级了，就要弄成不同sheet
        DB::table('words')->truncate();

        $file = $request->file('word_excel')->path();
        $re =  Excel::load($file, function($reader) {
            $reader->noHeading(); //这一句
        })->get();
        //re = 几个sheet

        //标准库创建指定长度数组，并初始化等级颜色

        $level_caches =  array_fill(0, count($re), '?');
        //$level_caches = new \SplFixedArray(count($re));
        for($i=0;$i<count($re);$i++){
            $level_caches[$i] = $this->randColor();
        }
        //
        Cache::forever('levels',$level_caches);

        //多个sheet的插入
        $this->manySheetStore($re);

        flash('导入成功','success')->important();
        return back();
    }

    //多个sheet
    public function manySheetStore($re){


        $time = date('Y-m-d H:m:i',time());
        $insert_array = $ar = $all_words = [];
        //每个sheet循环
        for ($i=0;$i<count($re);$i++){
            $tem = $re[$i]->toArray(); //集合转为数组
            for ($j=0;$j<count($tem);$j++){
                if(isset($tem[$j][0]) && isset($tem[$j][1]) && isset($tem[$j][2]) && isset($tem[$j][3])
                && isset($tem[$j][4]))
                {
                    $insert_array[$j]['word'] = trim($tem[$j][0]);
                    $insert_array[$j]['mean'] = trim($tem[$j][1]);
                    $insert_array[$j]['level'] = intval($tem[$j][2]);
                    $insert_array[$j]['zanwu'] = trim($tem[$j][3]);
                    $insert_array[$j]['code'] = intval($tem[$j][4]);
                    $insert_array[$j]['created_at'] = $time;
                }

            }
            $all_words = array_merge($all_words,$insert_array);

            DB::table('words')->insert($insert_array);

        }
        foreach ($all_words as $array_one=>&$value){
            $value['id'] = $array_one+1;
        }

        //记录导入记录
        $info = ['count'=>count($all_words),'time'=>$time];
        Log::info('导入Excel词汇共：',$info);
        //缓存全部词汇
        Cache::forever('words',$all_words);
    }

    //一个sheet
    public function oneSheetStore($re){
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

        DB::table('words')->insert($insert_array);

        foreach ($insert_array as $array_one=>&$value){
            $value['id'] = $array_one+1;
        }

        //缓存词汇
        Cache::forever('words',$insert_array);

    }

    /*
     * 刷新缓存
     */
    public function updateWordCache(){
        $words = DB::table('words')->get()->map(function ($value) {
            return (array)$value;
        })->toArray();

        Cache::forget('words');
        Cache::forever('words',$words);

        flash('刷新缓存成功','success')->important();
        return redirect()->route('wordIndex');
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
