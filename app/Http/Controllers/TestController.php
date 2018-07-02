<?php

namespace App\Http\Controllers;

//require '../../Help/scws/PSCWS4.php';
use App\Help\scws\PSCWS4;
use App\Help\scws\XDB_R;
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
        $user = ['id'=>'admin','url'=>'cyt','title'=>'aaa'];

        return response()->json($user);
    }

    public function gettest(){

        $pscws = new PSCWS4('utf8');
        $pscws->set_charset('utf-8');
        $pscws->set_dict(public_path().'/dict.utf8.xdb');
        $pscws->set_rule(public_path().'/rules.ini');
        $text = "陈凯歌并不是《无极》的唯一著(作权)人，一部电影的整体版'权归电影'制片厂所有。";
        $pscws->send_text($text);
        $arr = [];
        while ($some = $pscws->get_result())
        {
            foreach ($some as $word)
            {
                $arr[] = $word['word'];
            }
        }
        //
        // 接下来, 设定一些分词参数或选项, set_dict 是必须的, 若想智能识别人名等需要 set_rule
        //
        // 包括: set_charset, set_dict, set_rule, set_ignore, set_multi, set_debug, set_duality ... 等方法
        //


        // 分词调用 send_text() 将待分词的字符串传入, 紧接着循环调用 get_result() 方法取回一系列分好的词
        // 直到 get_result() 返回 false 为止
        // 返回的词是一个关联数组, 包含: word 词本身, idf 逆词率(重), off 在text中的偏移, len 长度, attr 词性
        //


        dd($arr);

        $test = Jieba::cut('Dragon Boat Festival is one the very classic traditional 
        festivals, which has been celebrated since the old China. Firstly, it is to 
        in honor of the great poet Qu Yuan, who jumped into the water and ended his 
        life for loving the country. ',false);
        dd($test);
    }
}
