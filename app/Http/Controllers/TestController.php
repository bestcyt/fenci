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
        $user = ['admin','cyt','aaa'];

        return response()->json($user);
    }

    public function gettest(){

        $pscws = new PSCWS4('utf8');
        $pscws->set_charset('utf-8');


        //
        // 接下来, 设定一些分词参数或选项, set_dict 是必须的, 若想智能识别人名等需要 set_rule
        //
        // 包括: set_charset, set_dict, set_rule, set_ignore, set_multi, set_debug, set_duality ... 等方法
        //
        $pscws->set_dict(public_path().'/dict.utf8.xdb');
        $pscws->set_rule(public_path().'/rules.ini');

        // 分词调用 send_text() 将待分词的字符串传入, 紧接着循环调用 get_result() 方法取回一系列分好的词
        // 直到 get_result() 返回 false 为止
        // 返回的词是一个关联数组, 包含: word 词本身, idf 逆词率(重), off 在text中的偏移, len 长度, attr 词性
        //
        $text = "陈凯歌并不是《无极》的唯一著(作权)人，一部电影的整体版'权归电影'制片厂所有。";
        $text = "Dragon Boat Festival is one said that 'fuck you !' the very classic traditional festivals, which has been celebrated since the old China. Firstly, it is to in honor of the great poet Qu Yuan, who jumped into the water and ended his life for loving the country. Nowadays, different places have different ways to celebrate.
        端午节是一个非常经典的传统节日，自古以来就一直被人们所庆祝。首先，是为了纪念伟大的诗人屈原，屈原跳入水自杀，以此来表达了对这个国家的爱。如今，不同的地方有不同的庆祝方式。";
        $pscws->send_text($text);
        $arr = [];
        while ($some = $pscws->get_result())
        {
            foreach ($some as $word)
            {
                $arr[] = $word['word'];
            //      print_r($word);
            //      exit();
            }
        }

        dd($arr);

        $test = Jieba::cut('Dragon Boat Festival is one the very classic traditional 
        festivals, which has been celebrated since the old China. Firstly, it is to 
        in honor of the great poet Qu Yuan, who jumped into the water and ended his 
        life for loving the country. ',false);
        dd($test);
    }
}
