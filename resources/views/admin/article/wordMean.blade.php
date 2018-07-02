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
                                <li class="active"><a data-toggle="tab" href="#tab-1">1级</a>
                                </li>
                                <li class=""><a data-toggle="tab" href="#tab-2">2级</a>
                                </li>
                                <li class=""><a data-toggle="tab" href="#tab-3">3级</a>
                                </li>
                                <li class=""><a data-toggle="tab" href="#tab-4">4级</a>
                                </li>
                                <li class=""><a data-toggle="tab" href="#tab-5">5级</a>
                                </li>
                                <li class=""><a data-toggle="tab" href="#tab-6">6级</a>
                                </li>
                                <li class=""><a data-toggle="tab" href="#tab-7">7级</a>
                                </li>
                            </ul>
                            <div class="tab-content">
                                <div id="tab-1" class="tab-pane active">
                                    <div class="full-height-scroll">
                                        <div class="table-responsive">
                                            <table id="t1" class="table table-striped table-hover">
                                                <tbody>
                                                <tr>
                                                    <td class="client-avatar"><button type="button" class="btn btn-success btn-sm" id="checkall1">全选</button>
                                                        <button type="button" class="btn btn-sm btn-danger" id="uncheckall1">取消全选</button>
                                                    </td>
                                                </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                                <div id="tab-2" class="tab-pane">
                                    <div class="full-height-scroll">
                                        <div class="table-responsive">
                                            <table id="t2" class="table table-striped table-hover">
                                                <tbody>
                                                <tr>
                                                    <td class="client-avatar"><button type="button" class="btn btn-success btn-sm" id="checkall2">全选</button>
                                                        <button type="button" class="btn btn-sm btn-danger" id="uncheckall2">取消全选</button>
                                                    </td>
                                                </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                                <div id="tab-3" class="tab-pane">
                                    <div class="full-height-scroll">
                                        <div class="table-responsive">
                                            <table id="t3"  class="table table-striped table-hover">
                                                <tbody>
                                                <tr>
                                                    <td class="client-avatar"><button type="button" class="btn btn-success btn-sm" id="checkall3">全选</button>
                                                        <button type="button" class="btn btn-sm btn-danger" id="uncheckall3">取消全选</button>
                                                    </td>
                                                </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                                <div id="tab-4" class="tab-pane">
                                    <div class="full-height-scroll">
                                        <div class="table-responsive">
                                            <table id="t4"  class="table table-striped table-hover">
                                                <tbody>
                                                <tr>
                                                    <td class="client-avatar"><button type="button" class="btn btn-success btn-sm" id="checkall4">全选</button>
                                                        <button type="button" class="btn btn-sm btn-danger" id="uncheckall4">取消全选</button>
                                                    </td>
                                                </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                                <div id="tab-5" class="tab-pane">
                                    <div class="full-height-scroll">
                                        <div class="table-responsive">
                                            <table id="t5"  class="table table-striped table-hover">
                                                <tbody>
                                                <tr>
                                                    <td class="client-avatar"><button type="button" class="btn btn-success btn-sm" id="checkall5">全选</button>
                                                        <button type="button" class="btn btn-sm btn-danger" id="uncheckall5">取消全选</button>
                                                    </td>
                                                </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                                <div id="tab-6" class="tab-pane">
                                    <div class="full-height-scroll">
                                        <div class="table-responsive">
                                            <table id="t6"  class="table table-striped table-hover">
                                                <tbody>
                                                <tr>
                                                    <td class="client-avatar"><button type="button" class="btn btn-success btn-sm" id="checkall6">全选</button>
                                                        <button type="button" class="btn btn-sm btn-danger" id="uncheckall6">取消全选</button>
                                                    </td>
                                                </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                                <div id="tab-7" class="tab-pane">
                                    <div class="full-height-scroll">
                                        <div class="table-responsive">
                                            <table id="t6"  class="table table-striped table-hover">
                                                <tbody>
                                                <tr>
                                                    <td class="client-avatar"><button type="button" class="btn btn-success btn-sm" id="checkall7">全选</button>
                                                        <button type="button" class="btn btn-sm btn-danger" id="uncheckall7">取消全选</button>
                                                    </td>
                                                </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
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
                                $.each(data,function (i,v) {
                                    console.log(i);
                                    console.log(v);
                                    if(i == 0){
                                        var str = '';
                                        $.each(v,function (i0,v0) {
                                            str += "<tr>";
                                            str += "<td>"+"<input type='checkbox' class='checkbox1' name="+v0+" value="+v0+">"+v0+"<br>"+"</td>";
                                            str += "</tr>";
                                        });
                                        $("#t1 tbody").append(str);
                                    }
                                    if(i == 1){
                                        var str1 = '';
                                        $.each(v,function (i1,v1) {
                                            str1 += "<tr>";
                                            str1 += "<td>"+"<input type='checkbox' class='checkbox2'  name="+v1+" value="+v1+">"+v1+"<br>"+"</td>";
                                            str1 += "</tr>";
                                        });
                                        $("#t2 tbody").append(str1);
                                    }
                                    if(i == 2){
                                        var str2 = '';
                                        $.each(v,function (i2,v2) {
                                            str2 += "<tr>";
                                            str2 += "<td>"+"<input type='checkbox' class='checkbox3'  name="+v2+" value="+v2+">"+v2+"<br>"+"</td>";
                                            str2 += "</tr>";
                                        });
                                        $("#t3 tbody").append(str2);
                                    }
                                    if(i == 3){
                                        var str3 = '';
                                        $.each(v,function (i3,v3) {
                                            str3 += "<tr>";
                                            str3 += "<td>"+"<input type='checkbox' class='checkbox4'  name="+v3+" value="+v3+">"+v3+"<br>"+"</td>";
                                            str3 += "</tr>";
                                        });
                                        $("#t4 tbody").append(str3);
                                    }
                                    if(i == 4){
                                        var str4 = '';
                                        $.each(v,function (i4,v4) {
                                            str4 += "<tr>";
                                            str4 += "<td>"+"<input type='checkbox' class='checkbox5'  name="+v4+" value="+v4+">"+v4+"<br>"+"</td>";
                                            str4 += "</tr>";
                                        });
                                        $("#t5 tbody").append(str4);
                                    }
                                    if(i == 5){
                                        var str5 = '';
                                        $.each(v,function (i5,v5) {
                                            str5 += "<tr>";
                                            str5 += "<td>"+"<input type='checkbox' class='checkbox6'  name="+v5+" value="+v5+">"+v5+"<br>"+"</td>";
                                            str5 += "</tr>";
                                        });
                                        $("#t6 tbody").append(str5);
                                    }
                                    if(i == 6){
                                        var str6 = '';
                                        $.each(v,function (i6,v6) {
                                            str6 += "<tr>";
                                            str6 += "<td>"+"<input type='checkbox' class='checkbox7'  name="+v6+" value="+v6+">"+v6+"<br>"+"</td>";
                                            str6 += "</tr>";
                                        });
                                        $("#t7 tbody").append(str6);
                                    }

//                                    if ( (i)%5 == 0 && !(i%2 == 0)){
//                                        str += "<tr>";
//                                        str += "<td>"+"<input type='checkbox' name="+v+" value="+v+">"+v+"<br>"+"</td>";
//                                    }else if ( (i+1)%5 == 0 && ((i+1)%2 == 0)){
//                                        str += "<td>"+"<input type='checkbox' name="+v+" value="+v+">"+v+"<br>"+"</td>";
//                                        str += "</tr>";
//                                    }else {
//                                        str += "<td>"+"<input type='checkbox' name="+v+" value="+v+">"+v+"<br>"+"</td>";
//                                    }
                                });
//                                str += "</table>";
//                                $('#show').html(str); //将选择的CheckBox放进show
                            }
                        },JSON);
                    };
                    document.getElementById("dao").onclick = function() {
                        var strContent = document.getElementById("text").value;
                        strContent = strContent.replace(/\r\n/g, ' br '); //IE9、FF、chrome
                        strContent = strContent.replace(/\n/g, ' br '); //IE7-8
                        strContent = strContent.replace(/\s/g, ' '); //空格处理
                        $('#article_string').val(strContent);
                        $('#dao_form').submit();
                    };

                    //点击全选
                    $("#checkall1").click(function(){
                        $(".checkbox1").attr("checked","true");
                    });
                    $("#uncheckall1").click(function(){
                        $(".checkbox1").removeAttr("checked");
                    });
                    $("#checkall2").click(function(){
                        $(".checkbox2").attr("checked","true");
                    });
                    $("#uncheckall2").click(function(){
                        $(".checkbox2").removeAttr("checked");
                    });
                    $("#checkall3").click(function(){
                        $(".checkbox3").attr("checked","true");
                    });
                    $("#uncheckall3").click(function(){
                        $(".checkbox3").removeAttr("checked");
                    });
                    $("#checkall4").click(function(){
                        $(".checkbox4").attr("checked","true");
                    });
                    $("#uncheckall4").click(function(){
                        $(".checkbox4").removeAttr("checked");
                    });
                    $("#checkall5").click(function(){
                        $(".checkbox5").attr("checked","true");
                    });
                    $("#uncheckall5").click(function(){
                        $(".checkbox5").removeAttr("checked");
                    });
                    $("#checkall6").click(function(){
                        $(".checkbox6").attr("checked","true");
                    });
                    $("#uncheckall6").click(function(){
                        $(".checkbox6").removeAttr("checked");
                    })

                });
    </script>

    @endsection