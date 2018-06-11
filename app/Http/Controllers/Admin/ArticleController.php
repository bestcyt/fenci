<?php

namespace App\Http\Controllers\Admin;

use Fukuball\Jieba\Finalseg;
use Fukuball\Jieba\Jieba;
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
        dd($article_string);
        dd(strip_tags($article_string));

        $seg_list = Jieba::cut($article_string,false);

        for ($i=0;$i<count($seg_list);$i++){
            $seg_list[$i] = trim(str_replace("."," ",$seg_list[$i]));
        }

        $fenci = array_values(array_unique($seg_list));

        dd($fenci);

    }
}
