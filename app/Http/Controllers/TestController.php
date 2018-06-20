<?php

namespace App\Http\Controllers;

use Fukuball\Jieba\Finalseg;
use Fukuball\Jieba\Jieba;
use Illuminate\Http\Request;

class TestController extends Controller
{
    public function __construct()
    {
        Jieba::init();
        Finalseg::init();
    }

    //
    public function getUserAt()
    {
        $user = ['admin','cyt','aaa'];

        return response()->json($user);
    }

    public function gettest(){

        $test = Jieba::cut('Dragon Boat Festival is one the very classic traditional 
        festivals, which has been celebrated since the old China. Firstly, it is to 
        in honor of the great poet Qu Yuan, who jumped into the water and ended his 
        life for loving the country. ',false);
        dd($test);
    }
}
