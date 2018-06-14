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

    public function ppl(Request $request){

        $article_string = $request->input('article');
        $jibie_string = $request->input('jibie');

        //带br的文章字符串，没有别的html标签
        $article_string = str_replace('\r\n','<br>',$article_string);

        //分词，形成数组
        $article_fenci = Jieba::cut($article_string,false);

        //获取缓存词汇库
        $words = \Illuminate\Support\Facades\Cache::get('words');

        $jibie = array_filter(explode(',',$jibie_string));

        for ($i=0;$i<count($words);$i++){
            for ($j=0;$j<count($article_fenci);$j++){
                if ($words[$i]['word'] == $article_fenci[$j]){  //判断词汇是否匹配
                    if (in_array($words[$i]['level'],$jibie)){ //判断需要显示的颜色是否在数组中
                        if ($words[$i]['level'] == 1){
                            $article_fenci[$j] = "<span style='color: red'>$article_fenci[$j]</span>";
                        }
                        if ($words[$i]['level'] == 2){
                            $article_fenci[$j] = "<span style='color: blue'>$article_fenci[$j]</span>";
                        }
                        if ($words[$i]['level'] == 3){
                            $article_fenci[$j] = "<span style='color: green'>$article_fenci[$j]</span>";
                        }
                        if ($words[$i]['level'] == 4){
                            $article_fenci[$j] = "<span style='color: yellow'>$article_fenci[$j]</span>";
                        }
                        if ($words[$i]['level'] == 5){
                            $article_fenci[$j] = "<span style='color: brown'>$article_fenci[$j]</span>";
                        }
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
        return json_encode($article,JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
    }

    //词汇分词导出word
    public function toWord(Request $request){
        $article_string = $request->input('article');
        header("Content-Type: application/msword");
        header("Content-Disposition: attachment; filename=doc.doc"); //指定文件名称
        header("Pragma: no-cache");
        header("Expires: 0");
        $html = '<table border="1" cellspacing="2" cellpadding="2" width="90%" align="center"></table>';
        echo $html .$article_string.'';
    }

    //不知道为什么加table才行
    public function test(){
        header("Content-Type: application/msword");
        header("Content-Disposition: attachment; filename=doc.doc"); //指定文件名称
        header("Pragma: no-cache");
        header("Expires: 0");
        $html = '<table border="1" cellspacing="0" cellpadding="0" width="90%" align="center"></table>';
        $html .= '<br>'.'"Nowadays Hollywood movies dominate the market <span style="color: red">and</span> many young people take these superheroes characters <span style="color: red">as</span> their idols. So some people start to feel disappointed <span style="color: red">about</span> the local culture because they haven t seen its essence. As the world gets globalization it is in need of building people s sense of local cultural heritage. <br> 如今，好莱坞电影主导着整个电影市场，许多年轻人把这些超级英雄人物当做偶像。所以一些人开始对当地的文化感到失望，因为他们没有看到它们的精华。随着世界的全球化，需要培养人们对当地文化继承的意识。<br> <br> The preservation of our cultural heritage is the necessary task. The culture contains the essence of Chinese people s spirit which has been tested by time. When people <span style="color: blue">admit</span> our culture we will be proud of <span style="color: green">being</span> part of the country so <span style="color: red">as</span> to enhance the unity <span style="color: red">and</span> have the desire to make a contribution to the society. The loss of cultural heritage will destroy a country which can be seen in history. <br> 保护文化遗产是主要任务。文化蕴涵着中国人民精神的精髓，是经过时间的检验的。当人们承认我们的文化时，我们就会为自己是这个国家的一员而感到自豪，从而加强民族凝聚力，并愿意为这个国家做贡献。文化遗产的丧失将摧毁一个国家，这一点在历史上是可见的。<br> <br> As the young generation faces the cultural shock in the globalization so they are easy to deny the local culture because they know little <span style="color: red">about</span> it. Thus school should implant the education of culture <span style="color: red">and</span> the government has named a day called Chinese Cultural Heritage Day in the purpose of advocating the essence of local culture. When children grow up they will fight for protecting the culture. <br> 由于年轻一代在全球化中面临着文化冲击，所以他们很容易否认当地文化，主要也是他们对这些文化知之甚少。因此，学校应该给学生们灌输文化教育，政府也已经命名了一个叫做中国文化遗产日的节日，目的是重提当地文化。当孩子们长大后，他们就会为保护文化而奋斗。"';
        echo $html ;
    }

    public function wordCount(Request $request)
    {
        if ($request->method() == 'GET'){
            return view('admin.article.wordCount');
        }
        if ($request->method() == 'POST'){
            //分词，形成数组
            $article = Jieba::cut($request->input('article'),false);

            //获取缓存词汇库
            $words = \Illuminate\Support\Facades\Cache::get('words');

            //先对提交的文章去重复，再重新排键值，

            //循环统计值，修改数组结果，再遍历唯一编码
            dd($article);
        }
        dd('修改大小写');
    }
}
