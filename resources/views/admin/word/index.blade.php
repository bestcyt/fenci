@extends('layouts.admin_app')
@section('css')
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link href="{{ asset('js/plugins/footable-bootstrap/css/footable.bootstrap.css') }}" rel="stylesheet">

@endsection
@section('content')
    @inject('request', 'Illuminate\Http\Request')
    <div class="row wrapper border-bottom white-bg page-heading">
        <div class="col-lg-6">
            <h2>词汇</h2>
            <ol class="breadcrumb">
                <li>
                    <a href="{{ url('/') }}">首页</a>
                </li>
                <li>
                    <a>词汇管理</a>
                </li>
                <li class="active">
                    <strong>词汇</strong>
                </li>
            </ol>
        </div>
        <div class="col-lg-6">
            <div class="title-action">
                <a href="{{ url('admin/word/create') }}" class="btn btnloading btn-info"><i class="fa fa-plus"></i> 重导词汇</a>
                <a href="{{ url('admin/word/outExcel') }}" class="btn btnloading btn-success"><i class="fa fa-cloud-download"></i> 导出词汇</a>
            </div>
        </div>
    </div>
    <div class="wrapper wrapper-content animated fadeInRight">
        <div class="row">
            <div class="col-lg-12">
                <div class="ibox float-e-margins">
                    <div class="ibox-title">
                        <h5>显示词汇列表</h5>
                        <div class="ibox-tools">
                            <a class="collapse-link">
                                <i class="fa fa-chevron-up"></i>
                            </a>
                            <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                                <i class="fa fa-wrench"></i>
                            </a>
                            <ul class="dropdown-menu dropdown-user">
                                <li><a href="#">Config option 1</a>
                                </li>
                            </ul>
                            <a class="close-link">
                                <i class="fa fa-times"></i>
                            </a>
                        </div>
                    </div>
                    <div class="ibox-content">
                        @include('flash::message')
{{--                        <form action="{{ url('admin/w/order') }}" method="post" id="order_form">--}}
                            {{--{{ csrf_field() }}--}}
                            <table class="footable table table-striped table-bordered table-hover" data-paging-position="right" data-filter=#filter data-paging="true" data-paging-size="10" >
                                <thead>
                                <tr>
                                    <th>#</th>
                                    <th>等级</th>
                                    <th>词汇</th>
                                    <th>释义</th>
                                    <th>唯一编码</th>
                                    <th>更新时间</th>
                                    <th>操作</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($words as $item=>$val)
                                    <tr id="{{ $item }}">
                                        <td>{{ $val['id']+1 }}</td>
                                        <td>{{ $val['level'] }}</td>
                                        <td>{{ $val['word'] }}</td>
                                        <td>{{ $val['mean'] }}</td>
                                        <td>{{ $val['code'] }}</td>
                                        <td>{{ $val['created_at'] }}</td>
                                        {{--<td>--}}
                                            {{--<a href="{{ url('admin/city/'.$item->id.'/edit') }}" class="btn btn-xs btn-warning tooltips"  data-original-title="编辑" data-placement="top"><i class="fa fa-eye"></i></a>--}}
                                            {{--<a href="javascript:;" onclick="return false" class="btn btn-xs btn-outline btn-danger tooltips destroy_item" data-original-title="删除" data-placement="top">--}}
                                                {{--<i class="fa fa-trash"></i>--}}
                                                {{--<input type="hidden" value="{{ $item->id }}" class="city_id">--}}
                                            {{--</a>--}}
                                        {{--</td>--}}
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                            {{--<button type="button" class="btn btn-primary" id="order_update">更新排序</button>--}}
                        {{--</form>--}}
                        {{--<ul class="pagination pull-right">--}}
                        {{--{{ $city ->appends([--}}
                        {{--'city_name' => $request->city_name,--}}
                        {{--])->links() }}--}}
                        {{--</ul>--}}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('js')
    <script src="{{ asset('js/plugins/nestable/jquery.nestable.js')}}"></script>
    <script src="{{ asset('js/plugins/inspinia/js/menu.js')}}"></script>
    <script src="{{ asset('js/plugins/layer/layer.js')}}"></script>
    <script src="{{ asset('js/plugins/footable-bootstrap/js/footable.js') }}"></script>

    <script type="text/javascript">
        $(function () {
            $('.footable').footable({
                "filtering": {
                    "enabled": true
                }
            });
            $('#order_update').on('click',function () {
                $(this).attr('disabled','true');
                $('#order_form').submit();
            });
            var url_index = window.location.pathname;
            var ajax_url = '';
            if(url_index.indexOf('index') != -1){
                ajax_url = '';
            }else {
                ajax_url = 'city/';
            }

        })

    </script>
@endsection

