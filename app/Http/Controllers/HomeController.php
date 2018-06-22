<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {


        return view('home');
    }

    public function getTable(){


        //序号，词汇，注释，级别 （需要用缓存的匹配组成新数组）

        $words = Cache::get('words');


        $getword = [];
        $table = "<table border=\"1\" cellspacing=\"0\" cellpadding=\"0\" width=\"90%\" align=\"center\">";
        for ($i=0;$i<count($getword);$i++){

            $num = $i+1;
            $word = $getword[$i]['word'];
            $mean = $getword[$i]['mean'];
            $level = $getword[$i]['level'];
            $table .= '<tr>';
            $table .= "<td>$num</td>";
            $table .= "<td>$word</td>";
            $table .= "<td>$mean</td>";
            $table .= "<td>$level</td>";
            $table .= '</tr>';
        }
        $table .= "</table>";
    }
}
