@extends('layouts.admin_app')

@section('css')
    <link href="{{ asset('css/plugins/iCheck/custom.css') }}" rel="stylesheet">

@endsection

@section('content')

    <div class="row">
        <div class="col-sm-12">
            <div class="ibox float-e-margins">
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
                <div class="ibox-content">
                    <form method="post" class="form-horizontal" action="{{ url('admin/article/store') }}">
                        {{ csrf_field() }}
                        <div class="form-group">
                            <label class="col-sm-2 control-label">普通</label>

                            <div class="col-sm-10">
                                <textarea type="text" name="article" id="text" class="article form-control" style="width: 80%;height: 100%"></textarea>
                            </div>
                        </div>

                        <div class="hr-line-dashed"></div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label">显示级别</label>

                            <div class="col-sm-10" hidden>
                                <label class="checkbox-inline i-checks">
                                    <div class="icheckbox_square-green" style="position: relative;">
                                        <input checked type="checkbox" value="1" style="position: absolute; opacity: 0;"><ins class="iCheck-helper" style="position: absolute; top: 0%; left: 0%; display: block; width: 100%; height: 100%; margin: 0px; padding: 0px; background: rgb(255, 255, 255); border: 0px; opacity: 0;"></ins></div>
                                    1级</label>
                                <label class="checkbox-inline i-checks">
                                    <div class="icheckbox_square-green" style="position: relative;">
                                        <input checked type="checkbox" value="2" style="position: absolute; opacity: 0;"><ins class="iCheck-helper" style="position: absolute; top: 0%; left: 0%; display: block; width: 100%; height: 100%; margin: 0px; padding: 0px; background: rgb(255, 255, 255); border: 0px; opacity: 0;"></ins></div>
                                    2级</label>
                                <label class="checkbox-inline i-checks">
                                    <div class="icheckbox_square-green" style="position: relative;">
                                        <input checked type="checkbox" value="3" style="position: absolute; opacity: 0;"><ins class="iCheck-helper" style="position: absolute; top: 0%; left: 0%; display: block; width: 100%; height: 100%; margin: 0px; padding: 0px; background: rgb(255, 255, 255); border: 0px; opacity: 0;"></ins></div>
                                    3级</label>
                                <label class="checkbox-inline i-checks">
                                    <div class="icheckbox_square-green" style="position: relative;">
                                        <input checked type="checkbox" value="4" style="position: absolute; opacity: 0;"><ins class="iCheck-helper" style="position: absolute; top: 0%; left: 0%; display: block; width: 100%; height: 100%; margin: 0px; padding: 0px; background: rgb(255, 255, 255); border: 0px; opacity: 0;"></ins></div>
                                    4级</label>
                                <label class="checkbox-inline i-checks">
                                    <div class="icheckbox_square-green" style="position: relative;">
                                        <input checked type="checkbox" value="5" style="position: absolute; opacity: 0;"><ins class="iCheck-helper" style="position: absolute; top: 0%; left: 0%; display: block; width: 100%; height: 100%; margin: 0px; padding: 0px; background: rgb(255, 255, 255); border: 0px; opacity: 0;"></ins></div>
                                    5级</label>
                            </div>
                        </div>

                        <div class="hr-line-dashed"></div>
                        <div class="form-group">
                            <div class="col-sm-4 col-sm-offset-2">
                                <button class="btn btn-primary" type="button" id="shi">分级识别</button>
                                <button class="btn btn-primary" type="button" id="dao">导出word</button>
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
                    document.getElementById("shi").onclick = function() {
                        var strContent = document.getElementById("text").value;
                        alert("处理前的strContent为\r\n"+strContent);
                        strContent = strContent.replace(/\r\n/g, '<br/>'); //IE9、FF、chrome
                        strContent = strContent.replace(/\n/g, '<br/>'); //IE7-8
                        strContent = strContent.replace(/\s/g, ' '); //空格处理
                        alert("转换之后的html代码为\r\n"+strContent);
                    };
                        $(document).on('click','.article',function() {

                            var _item = $(this);
                            var title = "确定删除该专栏作者？";
                            //            layer.confirm(title, {
                            //                btn: ['删除', '取消'],
                            //                icon: 5
                            //            },function(index){
                            //                var column_id = _item.children('.column_id').val();
                            //                $.ajax({
                            //                    headers: {
                            //                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                            //                    },
                            //                    url:"column/"+column_id,
                            //                    data:{'_method':'delete'},
                            //                    type:'post',
                            //                    success:function(data){
                            //                        var data_obj = JSON.parse(data);
                            //                        if(data_obj.data == 1){
                            //                            layer.msg('删除成功');
                            //                            $("#"+column_id).remove();
                            //                        }else{
                            //                            layer.msg('删除失败');
                            //                        }
                            //                    }
                            //                },JSON);
                            //                layer.close(index);
                            //            });
                        });
                });
    </script>

    @endsection