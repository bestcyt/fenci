<?php

namespace App\Http\Controllers\Admin;

use Fukuball\Jieba\Finalseg;
use Fukuball\Jieba\Jieba;
use Illuminate\Filesystem\Cache;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ArticleController extends Controller
{
    public function __construct()
    {
        Jieba::init();
        Finalseg::init();
    }

    //文本框界面，输入
    public function create(){

        return view('admin.article.create');
    }

    //提交的文章分级标注
    public function store(Request $request){
        $article_string = $request->input('article');

        /*
         * 1.用textarea 在后台组装好html，在放页面上
         * 2.用simditor 貌似有函数可以获取，点击分级的时候，把内容传后台，过滤分析，组装成html，返回渲染simditor
         * 换行，空格，怎么解决？找人拿一个实例来演示比较好点
         */
        $article_string = str_replace('\r\n','<br>',$article_string);

        dd($article_string,Jieba::cut($article_string));

        ;
        //带br的string ；

        //分词
        dd(strip_tags($article_string));

        $seg_list = Jieba::cut($article_string,false);

        for ($i=0;$i<count($seg_list);$i++){
            $seg_list[$i] = trim(str_replace("."," ",$seg_list[$i]));
        }

        $fenci = array_values(array_unique($seg_list));

        dd($fenci);

    }

    public function ppl(Request $request){

        $article_string = $request->input('article');

        //带br的文章字符串，没有别的html标签
        $article_string = str_replace('\r\n','<br>',$article_string);

        //分词，形成数组
        $article_fenci = Jieba::cut($article_string,false);

        //获取缓存词汇库
        $words = \Illuminate\Support\Facades\Cache::get('words');

        for ($i=0;$i<count($words);$i++){
            for ($j=0;$j<count($article_fenci);$j++){
                $color = 'black';
                if ($words[$i]['word'] == $article_fenci[$j]){
                    switch ($words[$i]['level']){
                        case '1':
                            $color = 'red';
                            $article_fenci[$j] = "<span style='color: red'>$article_fenci[$j]</span>";
                            break;
                        case '2':
                            $color = 'blue';
                            $article_fenci[$j] = "<span style='color: blue'>$article_fenci[$j]</span>";
                            break;
                        case '3':
                            $color = 'green';
//                            $article_fenci[$j] = "<span style='color: green'>$article_fenci[$j]</span>";
                            break;
                        case '4':
                            $color = 'yellow';
//                            $article_fenci[$j] = "<span style='color: yellow'>$article_fenci[$j]</span>";
                            break;
                        case '5':
                            $color = 'brown';
//                            $article_fenci[$j] = "<span style='color: brown'>$article_fenci[$j]</span>";
                            break;
                    }
                }
            }
        }


        $article = '';
        for ($j=0;$j<count($article_fenci);$j++){
            if (preg_match("/[\x7f-\xff]/",$article_fenci[$j])){
                $article .= $article_fenci[$j];
            }else{

                if ($article_fenci[$j] == 'br'){
                    $article_fenci[$j] = '<br>';
                }
                $article .= $article_fenci[$j].' ';
            }
        }

        //解决一些textarea 高度和div高度问题限制
        //对不同等级是否要做成缓存
        //词汇库的导出
        //文章的word导出


        return json_encode($article,JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
    }
}
