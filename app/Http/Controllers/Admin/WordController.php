<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;

class WordController extends Controller
{
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

        DB::table('words')->truncate();

        $file = $request->file('word_excel')->path();
        $re =  Excel::load($file, function($reader) {
            $reader->noHeading(); //这一句
        })->get();

        $ar = $array_all = [];
        $time = date('Y-m-d H:m:i',time());
        for ($i=0;$i<count($re);$i++){
            for ($j=0;$j<count($re[$i]);$j++){
                $ar[$i][$j]['word'] = trim($re[$i][$j][0]);
                $ar[$i][$j]['mean'] = $re[$i][$j][1];
                $ar[$i][$j]['level'] = $i+1;
                $ar[$i][$j]['created_at'] = $time;
            }
            $array_all = array_merge($array_all,$ar[$i]);
            DB::table('words')->insert($ar[$i]);
        }
        foreach ($array_all as $array_one=>&$value){
            $value['id'] = $array_one+1;
        }
        Cache::forever('words',$array_all);
        /*
         * array:1367 [▼
              0 => array:4 [▶]
              1 => array:4 [▶]
              2 => array:4 [▼
                "word" => "about"
                "mean" => "ad. 大约；到处；四处 prep. 关于；在各处；四处 "
                "level" => 1
                "created_at" => "2018-06-10 07:06:27"
              ]
         */
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

    public function outExcel(){
        $header = [['词汇','释义','等级']];
        $cihui = \Illuminate\Support\Facades\Cache::get('words');
        $sheet1 = $sheet2 = $sheet3 = $sheet4 = $sheet5 = [];
        for ($i=0;$i<count($cihui);$i++){
            unset($cihui[$i]['id']);
            unset($cihui[$i]['created_at']);
            if ($cihui[$i]['level'] == 1){
                $sheet1[$i] = $cihui[$i];
            }
            if ($cihui[$i]['level'] == 2){
                $sheet2[$i] = $cihui[$i];
            }
            if ($cihui[$i]['level'] == 3){
                $sheet3[$i] = $cihui[$i];
            }
            if ($cihui[$i]['level'] == 4){
                $sheet4[$i] = $cihui[$i];
            }
            if ($cihui[$i]['level'] == 5){
                $sheet5[$i] = $cihui[$i];
            }
        }
        $sheet1 = array_merge($header,$sheet1);
        $sheet2 = array_merge($header,$sheet2);
        $sheet3 = array_merge($header,$sheet3);
        $sheet4 = array_merge($header,$sheet4);
        $sheet5 = array_merge($header,$sheet5);

        Excel::create('词汇库',function($excel) use ($sheet1,$sheet2,$sheet3,$sheet4,$sheet5){
            $excel->sheet('1', function($sheet) use ($sheet1){
                $sheet->rows($sheet1);
            });
            $excel->sheet('2', function($sheet) use ($sheet2){
                $sheet->rows($sheet2);
            });
            $excel->sheet('3', function($sheet) use ($sheet3){
                $sheet->rows($sheet3);
            });
            $excel->sheet('4', function($sheet) use ($sheet4){
                $sheet->rows($sheet4);
            });
            $excel->sheet('5', function($sheet) use ($sheet5){
                $sheet->rows($sheet5);
            });
        })->export('xls');
    }
    




}
