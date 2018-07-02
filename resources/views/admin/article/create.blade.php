@extends('layouts.admin_app')

@section('css')
    <link href="{{ asset('css/plugins/iCheck/custom.css') }}" rel="stylesheet">
    <link href="{{ asset('css/plugins/colorpicker/bootstrap-colorpicker.min.css') }}" rel="stylesheet">
    <style>
        .colorpicker{
            width: 10px
        }
    </style>
@endsection

@section('content')

    <div class="row">
        <div class="col-sm-6" style="height: 100%">
            <div class="ibox float-e-margins"  style="height: 100%">
                <div class="ibox-title">
                    <h5>文章分级标注 <small>包括自定义样式的复选和单选按钮</small></h5>
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
                            <label class="col-sm-2 control-label">文本黏贴</label>
                            <div class="col-sm-10" style="height: 100%">
                                <textarea rows="20" cols="20" type="text" name="article" id="text" class="article form-control" style="width: 90%;height: 100%"></textarea>
                            </div>
                        </div>

                        <div class="hr-line-dashed"></div>
                        <div class="form-group">
                            <label class="col-sm-1 control-label">显示级别</label>

                            <div class="col-sm-11" >
                                @for($i=0;$i<count($levels);$i++)
                                    <div class="checkbox-inline">
                                        <input type="text" name="level1" id="level{{ $i+1 }}" class="form-control colorpicker level_color" value="{{ $levels[$i] }}" />
                                    </div>
                                    <label class="checkbox-inline i-checks">
                                        <div class="icheckbox_square-green" style="position: relative;">
                                            <input checked type="checkbox" class="level_check" id="check{{ $i }}" value="1" style="position: absolute; opacity: 0;">
                                            <ins class="iCheck-helper" style="position: absolute; top: 0%; left: 0%; display: block; width: 100%; height: 100%; margin: 0px; padding: 0px; background: rgb(255, 255, 255); border: 0px; opacity: 0;"></ins>
                                        </div>
                                        {{ $i+1 }}级
                                    </label>
                                @endfor
                            </div>
                        </div>

                        <div class="hr-line-dashed"></div>
                        <div class="form-group">
                            <div class="col-sm-4 col-sm-offset-2">
                                <button class="btn btn-primary" type="button" id="shi">分级识别</button>
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
                <div class="ibox-content">
                    <form method="post" class="form-horizontal" id="dao_form" action="{{ url('admin/article/toWord') }}">
                        {{ csrf_field() }}
                        <div class="form-group">
                            <label class="col-sm-2 control-label">分词标注结果</label>

                            <div class="col-sm-10">
                                <input type="hidden" name="article" value="" id="article">
                                <div id="show" style="width: 100%;height: 400px;overflow: auto" >

                                </div>
                            </div>
                        </div>
                        <div class="hr-line-dashed"></div>
                        <div class="form-group">
                            <div class="col-sm-4 col-sm-offset-2">
                                {{--<button class="btn btn-primary" type="button" id="shi">分级识别</button>--}}
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
    <script src="{{ asset('js/plugins/colorpicker/bootstrap-colorpicker.min.js') }}"></script>
    <script>

        $(document).ready(
                function(){
                    $(".colorpicker").colorpicker({
                        target:'#title',
                        success:function(o,color){
                            $("#color").val(color)
                        },

                        reset:function(o){
                            $("#color").val('');
                        }
                    });

                    $(".i-checks").iCheck({checkboxClass:"icheckbox_square-green",radioClass:"iradio_square-green",});

                    //点击分词识别，触发ajax
                    document.getElementById("shi").onclick = function() {
                        var checkbox = '';
                        $('.level_check').each(function () {
                            if ($(this).prop('checked')) {
                                checkbox += $(this).val()+',';
                            }else {
                                checkbox += '0'+',';
                            }

                        });

                        var level_str = '';
                        $('.level_color').each(function () {
                            level_str += $(this).val()+',';
                        });


                        //alert(level_str);
                        var strContent = document.getElementById("text").value;
                        strContent = strContent.replace(/\r\n/g, ' br '); //IE9、FF、chrome
                        strContent = strContent.replace(/\n/g, ' br '); //IE7-8
                        strContent = strContent.replace(/\s/g, ' '); //空格处理
                        $.ajax({
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                            },
                            url:"ppl",
                            data:{'article':strContent,'checkbox':checkbox,'level_str':level_str},
                            type:'post',
                            success:function(data){
                                console.log(1);
                                //console.log(data);
                                $('#show').html(data);
                            }
                        },JSON);
                    };
                    document.getElementById("dao").onclick = function() {
                        var strContent = $('#show').html();
                        $('#article').val(strContent);
                        $('#dao_form').submit();
                    };
                });
    </script>

    @endsection