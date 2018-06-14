@extends('layouts.admin_app')

@section('css')
    <link href="{{ asset('css/plugins/iCheck/custom.css') }}" rel="stylesheet">

@endsection

@section('content')

    <div class="row">
        <div class="col-sm-10" style="height: 100%">
            <div class="ibox float-e-margins"  style="height: 100%">
                <div class="ibox-title">
                    <h5>文章词频统计 <small></small></h5>
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
                    <form method="post" class="form-horizontal" action="{{ url('admin/article/wordCount') }}">
                        {{ csrf_field() }}
                        <div class="form-group" style="height: 100%">
                            <label class="col-sm-2 control-label">文本黏贴</label>
                            <div class="col-sm-10" style="height: 100%">
                                <textarea rows="20" cols="20" type="text" name="article" id="text" class="article form-control" style="width: 90%;height: 100%"></textarea>
                            </div>
                        </div>

                        <div class="hr-line-dashed"></div>
                        <div class="form-group">
                            <div class="col-sm-4 col-sm-offset-2">
                                <button class="btn btn-primary" type="submit" id="tongji">词汇统计</button>
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
                        $.ajax({
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                            },
                            url:"ppl",
                            data:{'article':strContent},
                            type:'post',
                            success:function(data){
                                console.log(1);
                                //console.log(data);
                                alert(1);
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