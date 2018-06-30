<?php

namespace App\Http\Controllers\Admin;

use Fukuball\Jieba\Finalseg;
use Fukuball\Jieba\Jieba;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Maatwebsite\Excel\Facades\Excel;
use App\Help\scws\PSCWS4;
use Illuminate\Support\Facades\Cache;

class ArticleController extends Controller
{
    public $jieba;
    public $finalseg;

    public $pscws;

    public function __construct()
    {
//        ini_set('memory_limit', '1500M');
//        $this->jieba = new Jieba();
//        $this->finalseg = new Finalseg();
//
//        $this->jieba->init();
//        $this->finalseg->init();

        $this->pscws = new PSCWS4('utf8');
        $this->pscws->set_charset('utf-8');
        $this->pscws->set_dict(public_path().'/dict.utf8.xdb');
        $this->pscws->set_rule(public_path().'/rules.ini');
    }

    //文本框界面，输入
    public function create(){
        $levels = Cache::get('levels');
        return view('admin.article.create',['levels'=>$levels]);
    }

    //分词标注
    public function ppl(Request $request){

        $article_string = $request->input('article');
        $jibie_string = $request->input('jibie');
        $level_string = $request->input('level_str');

        //获得级别颜色，并添加缓存
        $levels_arr = array_filter(explode(',',$level_string));
        Cache::forever('levels',$levels_arr);

        //分词，形成数组
        $article_fenci = [];
        $this->pscws->send_text($article_string);
        while ($some = $this->pscws->get_result())
        {
            foreach ($some as $word)
            {
                $article_fenci[] = $word['word'];
            }
        }
        //获取缓存词汇库
        $words = \Illuminate\Support\Facades\Cache::get('words');

        $jibie = array_filter(explode(',',$jibie_string));

        for ($i=0;$i<count($words);$i++){//遍历全部缓存词汇
            for ($j=0;$j<count($article_fenci);$j++){ //遍历结巴分词数组
                if ((stripos($words[$i]['word'],$article_fenci[$j]) !== false) && (strlen($words[$i]['word']) == strlen($article_fenci[$j]))){  //判断词汇是否匹配
                    if (in_array($words[$i]['level'],$jibie)){ //判断需要显示的颜色是否在数组中
                        if ($words[$i]['level'] == 1){
                            $article_fenci[$j] = "<span style='color: $levels_arr[0]'>$article_fenci[$j]</span>";
                        }
                        if ($words[$i]['level'] == 2){
                            $article_fenci[$j] = "<span style='color: $levels_arr[1]'>$article_fenci[$j]</span>";
                        }
                        if ($words[$i]['level'] == 3){
                            $article_fenci[$j] = "<span style='color: $levels_arr[2]'>$article_fenci[$j]</span>";
                        }
                        if ($words[$i]['level'] == 4){
                            $article_fenci[$j] = "<span style='color: $levels_arr[3]'>$article_fenci[$j]</span>";
                        }
                        if ($words[$i]['level'] == 5){
                            $article_fenci[$j] = "<span style='color: $levels_arr[4]'>$article_fenci[$j]</span>";
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
        return response()->json($article);
    }

    //词汇分词导出word
    public function toWord(Request $request){
        $article_string = $request->input('article');
        header("Content-Type: application/msword");
        header("Content-Disposition: attachment; filename=doc.doc"); //指定文件名称
        header("Pragma: no-cache");
        header("Expires: 0");
        $html = '<table border="1" cellspacing="2" cellpadding="2" width="90%" align="center"></table>';
        echo $html .$article_string;
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

    //词频统计
    public function wordCount(Request $request)
    {
        if ($request->method() == 'GET'){
            return view('admin.article.wordCount');
        }
        if ($request->method() == 'POST'){
            //获取缓存词汇库
            $words = Cache::get('words');
            //分词，形成数组
            $article = [];
            $this->pscws->send_text($request->input('article'));
            while ($some = $this->pscws->get_result())
            {
                foreach ($some as $word)
                {
                    $article[] = $word['word'];
                }
            }

            //去除标点符号
            for ($i=0;$i<count($article);$i++){
                $article[$i] = trim($article[$i]);
                //去除一些符号，
                if (in_array($article[$i],['"',',','.','，','。','!','?','(',')','《','》','（','）'])){
                    unset($article[$i]);
                }
            }

            //先对提交的文章去重复，再重新排键值，times=该单词的个数
            $article_values = array_values($article); //初始去除符号后的分词结果重排键值
            $article_unique = array_values(array_unique($article));//初始去除符号后的分词结果重排键值+去重


            //循环统计值，修改数组结果，再遍历唯一编码
            $art_arr = [];
            for ($i=0;$i<count($article_unique);$i++){
                $art_arr[$i]['word'] = $article_unique[$i];
                $art_arr[$i]['times'] = 0;
            }

            //统计去重后的文章的各个单词的个数 频数
            $cipings = array_count_values($article_values);//本想用函数的，但是还是得两次循环才能写进频数，就放弃了

            for ($i=0;$i<count($article_values);$i++){
                for ($j=0;$j<count($article_unique);$j++){
                    if (strtolower($article_values[$i]) == strtolower($article_unique[$j])){  //判断词汇是否匹配
                        $art_arr[$j]['times'] ++;
                    }
                }
            }

            //统计文章词汇各个等级的个数
            $level1 = $level2 = $level3 = $level4 = $level5 = 0;
            for ($i=0;$i<count($words);$i++){
                for ($j=0;$j<count($article_values);$j++){
                    if ( strtolower($words[$i]['word']) == strtolower($article_values[$j])){  //判断词汇是否匹配
                        if ($words[$i]['level'] == 1){
                            $level1 ++;
                        }
                        if ($words[$i]['level'] == 2){
                            $level2 ++;
                        }
                        if ($words[$i]['level'] == 3){
                            $level3 ++;
                        }
                        if ($words[$i]['level'] == 4){
                            $level4 ++;
                        }
                        if ($words[$i]['level'] == 5){
                            $level5 ++;
                        }
                    }
                }
            }

            $outputWords = [];
            //输出的word，加一列 频数
            for ($i=0;$i<count($words);$i++){
                $outputWords[$i]['id'] = $words[$i]['id'];
                $outputWords[$i]['mean'] = strpos($words[$i]['mean'],'=') === 0 ? "'".$words[$i]['mean']:$words[$i]['mean'];
                $outputWords[$i]['code'] = $words[$i]['code'];
                $outputWords[$i]['level'] = $words[$i]['level'];
                $outputWords[$i]['times'] = 0;
                for ($j=0;$j<count($art_arr);$j++){
                    if ( strtolower($words[$i]['word']) == strtolower($art_arr[$j]['word'])){  //判断词汇是否匹配
                        $outputWords[$i]['times'] = $art_arr[$j]['times'];
                    }
                }
            }


            //统计每个等级次数
            $level = [[$level1,$level2,$level3,$level4,$level5]];
            $sheet1_header = [['序号','释义','编码','级别','频数']];
            $sheet2_header = [['1级','2级','3级','4级','5级']];
            $sheet1 = array_merge($sheet1_header,$outputWords);
            $sheet2 = array_merge($sheet2_header,$level);

            Excel::create('词频统计',function($excel) use ($sheet1,$sheet2){
                $excel->sheet('词频', function($sheet) use ($sheet1){
                    $sheet->rows($sheet1);
                });
                $excel->sheet('级数', function($sheet) use ($sheet2){
                    $sheet->rows($sheet2);
                });
            })->export('xls');
        }
    }

    //段落释义
    public function wordMean(Request $request)
    {
        if ($request->method() == 'GET'){

            return view('admin.article.wordMean');
        }
        if ($request->method() == 'POST' && $request->input('type') == 'ppl'){
            //ajax提交，返回分词结果
            $article_fenci = $article_fenci2 = [];
           // $article_fenci = $article_fenci2 = $this->jieba->cut($request->input('article'),false);
            $this->pscws->send_text($request->input('article'));
            while ($some = $this->pscws->get_result())
            {
                foreach ($some as $word)
                {
                    $article_fenci[] = $article_fenci2[] = $word['word'];
                }
            }

            $count = $time = 0;
            for ($i=0;$i<count($article_fenci);$i++){
                $article_fenci[$i] = trim($article_fenci[$i]);
                //去除一些符号，
                if (in_array($article_fenci[$i],['"',',','.','，','。','!','?','(',')','《','》','（','）'])){
                    $time++;
                    unset($article_fenci2[$i]);
                }
                $count++;
            }

            //将词汇转为小写,防止去重的时候没有区分大小写
            array_walk($article_fenci2, function(&$value)
            {
                $value = strtolower($value);
            });

            //去重 重排后的数组
            $re_arr = array_values(array_unique($article_fenci2));

            //使用response 可以防止多了双引号
            return response()->json($re_arr);

        }
    }

    //段落释义导出word
    public function toWordMean(Request $request){
        //获取提交的信息 包括文章+CheckBox词汇
        $get_word = $request->all();

        //原文段落
        $article_str = $get_word['article_string'];

        //原文的分词数组

        //切换为scws分词法
        //$article_cut = Jieba::cut($article_str);
        $article_cut = [];
        $this->pscws->send_text($article_str);
        while ($some = $this->pscws->get_result())
        {
            foreach ($some as $word)
            {
                $article_cut[] = $word['word'];
            }
        }
        //去除数组中不需要的，保留选择的词汇数组
        unset($get_word['_token']);
        unset($get_word['article_string']);

        //词汇数组重新整理键值 0,1,2
        $get_word = array_values($get_word);

        //缓存的全部词汇数组
        $words = \Illuminate\Support\Facades\Cache::get('words');

        //给原文 选中的词汇 加粗 加序号
        for ($i=0;$i<count($article_cut);$i++){//遍历全部缓存词汇
            for ($j=0;$j<count($get_word);$j++){ //遍历结巴分词数组
                //判断词汇是否匹配
                if ((stripos($article_cut[$i],$get_word[$j]) !== false) && (strlen($article_cut[$i]) == strlen($get_word[$j]))){
                    $num = $j+1; //记录序号
                    $article_cut[$i] = "<b>$get_word[$j]<span style='color: #ff7c6e'>($num)</span></b>";//加粗并给标记上红色
                }
            }
        }

        //dd($article_cut);
        //整理加粗后的数组，拼接为文章
        $article = '';
        for ($j=0;$j<count($article_cut);$j++){
            if (preg_match("/[\x7f-\xff]/",$article_cut[$j])){
                $article .= $article_cut[$j];
            }else{
                if ($article_cut[$j] == 'br'){
                    $article_cut[$j] = '<br>';
                }
                $article .= $article_cut[$j].' ';
            }
        }

        //整理选择的词汇数组，根据词汇库读取信息序号，词汇，注释，级别 （需要用缓存的匹配组成新数组）
        $fin_word = [];
        for ($j=0;$j<count($get_word);$j++){
            $fin_word[$j]['word'] = $get_word[$j];
        }

        for ($j=0;$j<count($fin_word);$j++){
            for ($i=0;$i<count($words);$i++){
                if ((stripos($words[$i]['word'],$fin_word[$j]['word']) !== false) && (strlen($words[$i]['word']) == strlen($fin_word[$j]['word']))){
                    $fin_word[$j]['mean'] = $words[$i]['mean'];
                    $fin_word[$j]['level'] = $words[$i]['level'];
                    $fin_word[$j]['code'] = $words[$i]['code'];
                }
            }
        }


        //拼接表格内容
        $table = "<table border=\"1\" cellspacing=\"0\" cellpadding=\"0\" width=\"90%\" align=\"center\">";
        $table .= '<tr><td>序号</td><td>词汇</td><td>释义</td><td>级别</td></tr>';

        for ($i=0;$i<count($fin_word);$i++){
            $num = $i+1;
            $word = $fin_word[$i]['word'] ?? '';
            $mean = $fin_word[$i]['mean'] ?? '';
            $level = $fin_word[$i]['level'] ?? '';
            $table .= '<tr>';
            $table .= "<td>$num</td>";
            $table .= "<td>$word</td>";
            $table .= "<td>$mean</td>";
            $table .= "<td>$level</td>";
            $table .= '</tr>';
        }
        $table .= "</table>";


        //导出word
        header("Content-Type: application/msword");
        header("Content-Disposition: attachment; filename=doc.doc"); //指定文件名称
        header("Pragma: no-cache");
        header("Expires: 0");
        $html = '<table border="1" cellspacing="0" cellpadding="0" width="90%" align="center"></table>';
        $html .= $article;
        $html .= $table;

        //再接上表格

        echo $html ;
    }
}
