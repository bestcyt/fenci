@extends('layouts.admin_app')

@section('css')
    <link href="{{ asset('css/plugins/iCheck/custom.css') }}" rel="stylesheet">

@endsection

@section('content')

    <div class="row">
        <div class="col-sm-6" style="height: 100%">
            <div class="ibox float-e-margins"  style="height: 100%">
                <div class="ibox-title">
                    <h5>段落释义<small></small></h5>
                    <div class="ibox-tools">
                        <a class="collapse-link">
                            <i class="fa fa-chevron-up"></i>
                        </a>
                        <a class="dropdown-toggle" data-toggle="dropdown" href="form_basic.html#">
                            <i class="fa fa-wrench"></i>
                        </a>
                        <ul class="dropdown-menu dropdown-user">
                            <li><a href="form_basic.html#">选项1</a>
                            </li>
                            <li><a href="form_basic.html#">选项2</a>
                            </li>
                        </ul>
                        <a class="close-link">
                            <i class="fa fa-times"></i>
                        </a>
                    </div>
                </div>
                <div class="ibox-content" style="height: 100%">
                    <form method="post" class="form-horizontal" action="{{ url('admin/article/store') }}">
                        {{ csrf_field() }}
                        <div class="form-group" style="height: 100%">
                            <label class="col-sm-2 control-label">段落黏贴</label>
                            <div class="col-sm-10" style="height: 100%">
                                <textarea rows="20" cols="20" type="text" name="article" id="text" class="article form-control" style="width: 90%;height: 100%"></textarea>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-sm-4 col-sm-offset-2">
                                <button class="btn btn-primary" type="button" id="chong">筛选词汇</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <div class="col-sm-6">
            <div class="ibox float-e-margins">
                <div class="ibox-title">
                    <h5>分级显示 <small></small></h5>
                    <div class="ibox-tools">
                        <a class="collapse-link">
                            <i class="fa fa-chevron-up"></i>
                        </a>
                        <a class="dropdown-toggle" data-toggle="dropdown" href="form_basic.html#">
                            <i class="fa fa-wrench"></i>
                        </a>
                        <ul class="dropdown-menu dropdown-user">
                            <li><a href="form_basic.html#">选项1</a>
                            </li>
                            <li><a href="form_basic.html#">选项2</a>
                            </li>
                        </ul>
                        <a class="close-link">
                            <i class="fa fa-times"></i>
                        </a>
                    </div>
                </div>
                <div class="ibox-content" >
                    <form method="post" class="form-horizontal" id="dao_form" action="{{ url('admin/article/toWordMean') }}">
                        {{ csrf_field() }}
                        <input type="hidden" name="article_string" id="article_string" value="">
                        <div class="clients-list">
                            <ul class="nav nav-tabs">
                                <span class="pull-right small text-muted">结果</span>
                                @for($i=0;$i<count($levels);$i++)
                                    <li class="{{ ($i+1) == 1 ? 'active':'' }}"><a data-toggle="tab" href="#tab-{{ ($i+1) }}">{{ ($i+1) }}级</a>
                                    </li>
                                @endfor
                            </ul>
                            <div class="tab-content">
                                @for($i=0;$i<count($levels);$i++)
                                    <div id="tab-{{ ($i+1) }}" class="tab-pane {{ ($i+1) == 1 ? 'active':'' }}">
                                        <div class="full-height-scroll">
                                            <div class="table-responsive">
                                                <table id="t{{ ($i+1) }}" class="table table-striped table-hover">
                                                    <thead>
                                                    <tr>
                                                        <th>
                                                            <button type="button" class="btn btn-success btn-sm chooseAll" id="checkall{{ ($i+1) }}">全选</button>
                                                            <button type="button" class="btn btn-sm btn-danger unChooseAll" id="uncheckall{{ ($i+1) }}">取消全选</button>
                                                        </th>
                                                    </tr>
                                                    </thead>
                                                    <tbody>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                @endfor
                                </div>
                            </div>
                        <div class="hr-line-dashed"></div>
                        <div class="form-group">
                            <div class="col-sm-4 col-sm-offset-2">
                                <button class="btn  btn-primary" type="button" id="dao">导出word</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>


@endsection

@section('js')
    <script src="{{ asset('js/plugins/iCheck/icheck.min.js') }}"></script>

    <script>
        $(document).ready(
                function(){
                    $(".i-checks").iCheck({checkboxClass:"icheckbox_square-green",radioClass:"iradio_square-green",});

                    //获取词组ajax
                    document.getElementById("chong").onclick = function() {
                        //提交选择的单词后，怎么在原本的文章上润色呢？缓存吗
                        var strContent = document.getElementById("text").value;
                        strContent = strContent.replace(/\r\n/g, ' br '); //IE9、FF、chrome
                        strContent = strContent.replace(/\n/g, ' br '); //IE7-8
                        strContent = strContent.replace(/\s/g, ' '); //空格处理
                        $.ajax({
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                            },
                            url:"wordMean",
                            data:{'article':strContent,'type':'ppl'},
                            type:'post',
                            success:function(data){
                                var stra = "<table class='table table-bordered'>";
                                //根据返回的去重后的数组，拼接table
                                $.each(data,function (item,val) {
                                    var str = '';
                                    var tb = "#t"+(item+1); //指定table 的id

                                    if(val.length > 0){
                                        $.each(val,function (i,v) {
                                            str += "<tr>";
                                            var checkbox = 'checkbox'+(i+1);
                                            str += "<td>"+"<input type='checkbox' class="+checkbox+" name="+v+" value="+v+">"+v+"<br>"+"</td>";
                                            str += "</tr>";
                                        });
                                        var aaa = " "+tb+" tbody"; //选择器
                                        console.log(aaa);
                                    }
                                    $(aaa).html('');
                                    $(aaa).append(str);
                                 });
//                                str += "</table>";
//                                $('#show').html(str); //将选择的CheckBox放进show
                            }
                        },JSON);
                    };

                    //导出word触发事件
                    document.getElementById("dao").onclick = function() {
                        var strContent = document.getElementById("text").value;
                        strContent = strContent.replace(/\r\n/g, ' br '); //IE9、FF、chrome
                        strContent = strContent.replace(/\n/g, ' br '); //IE7-8
                        strContent = strContent.replace(/\s/g, ' '); //空格处理
                        $('#article_string').val(strContent);
                        $('#dao_form').submit();
                    };

                    var level = 0;
                    $.get("getLevel", function(result){
                        level = result;
                    });
                    for (var i=0;i<level;i++){
                        var chooseall = "#checkall"+(i+1);
                        var unchooseall = "#uncheckall"+(i+1);

//                        var checkbox = ".checkbox"+(i+1);
//                        $(chooseall).click(function(){
//                            $(checkbox).attr("checked","true");
//                        });
//                        $(unchooseall).click(function(){
//                            $(checkbox).removeAttr("checked");
//                        });
                    }
                    $(".chooseAll").click(function(){
//                        $(this).attr("checked","true");
                        alert('adsf');
                    });
                    $(".unChooseAll").click(function(){
                        $(this).removeAttr("checked");
                    });
                    {{--var dd = {{ $levels }};--}}
                    {{--//点击全选--}}

//                    $("#checkall1").click(function(){
//                        $(".checkbox1").attr("checked","true");
//                    });
//                    $("#uncheckall1").click(function(){
//                        $(".checkbox1").removeAttr("checked");
//                    });
//                    $("#checkall2").click(function(){
//                        $(".checkbox2").attr("checked","true");
//                    });
//                    $("#uncheckall2").click(function(){
//                        $(".checkbox2").removeAttr("checked");
//                    });
//                    $("#checkall3").click(function(){
//                        $(".checkbox3").attr("checked","true");
//                    });
//                    $("#uncheckall3").click(function(){
//                        $(".checkbox3").removeAttr("checked");
//                    });
//                    $("#checkall4").click(function(){
//                        $(".checkbox4").attr("checked","true");
//                    });
//                    $("#uncheckall4").click(function(){
//                        $(".checkbox4").removeAttr("checked");
//                    });
//                    $("#checkall5").click(function(){
//                        $(".checkbox5").attr("checked","true");
//                    });
//                    $("#uncheckall5").click(function(){
//                        $(".checkbox5").removeAttr("checked");
//                    });
//                    $("#checkall6").click(function(){
//                        $(".checkbox6").attr("checked","true");
//                    });
//                    $("#uncheckall6").click(function(){
//                        $(".checkbox6").removeAttr("checked");
//                    })
//                    $("#checkall7").click(function(){
//                        $(".checkbox7").attr("checked","true");
//                    });
//                    $("#uncheckall7").click(function(){
//                        $(".checkbox7").removeAttr("checked");
//                    })

                });
    </script>

    @endsection