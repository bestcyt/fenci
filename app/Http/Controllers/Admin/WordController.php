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
            flash('缓存缺失','danger')->important();
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
                $ar[$i][$j]['word'] = $re[$i][$j][0];
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
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
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


}
