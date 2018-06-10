@extends('layouts.admin_app')

@section('content')
    <div class="wrapper wrapper-content">
        <div class="row">
            @include('flash::message')
        <div class="col-sm-5">
            <div class="ibox float-e-margins">
                <div class="ibox-title">
                    <h3> 上传Excel词汇，sheet从1到5等级</h3>
                    <div class="ibox-tools">
                        <a class="collapse-link">
                            <i class="fa fa-chevron-up"></i>
                        </a>
                        <a class="dropdown-toggle" data-toggle="dropdown" href="form_editors.html#">
                            <i class="fa fa-wrench"></i>
                        </a>
                        <ul class="dropdown-menu dropdown-user">
                            <li><a href="form_editors.html#">选项1</a>
                            </li>
                            <li><a href="form_editors.html#">选项2</a>
                            </li>
                        </ul>
                        <a class="close-link">
                            <i class="fa fa-times"></i>
                        </a>
                    </div>
                </div>
                <div class="ibox-content">
                    <form role="form" class="form-horizontal m-t" method="post" action="{{ url('admin/word/store') }}" enctype="multipart/form-data">
                        {{ csrf_field() }}
                        <div class="form-group draggable">
                            <label class="col-sm-3 control-label">文件域：</label>
                            <div class="col-sm-9">
                                <input type="file" name="word_excel" class="form-control">
                            </div>
                        </div>
                        <div class="hr-line-dashed"></div>
                        <div class="form-group draggable">
                            <div class="col-sm-12 col-sm-offset-3">
                                <button class="btn btn-primary" type="submit">上传</button>
                            </div>
                        </div>
                    </form>
                    <div class="clearfix"></div>
                </div>
            </div>
        </div>
        <div class="col-sm-5">
            <div class="ibox float-e-margins">
                <div class="ibox-title">
                    <h3>一键清空词汇</h3>
                </div>

                <div class="ibox-content">
                    <div class="row form-body form-horizontal m-t">
                        <div class="col-md-12 droppable sortable">
                        </div>
                        <div class="col-md-6 droppable sortable" style="display: none;">
                        </div>
                        <div class="col-md-6 droppable sortable" style="display: none;">
                        </div>
                    </div>
                    <a type="button" href="{{ url('admin/word/updateWordCache') }}" class="btn btn-warning" data-clipboard-text="testing" id="copy-to-clipboard">
                        刷新缓存
                    </a>
                </div>
            </div>
        </div>
    </div>
    </div>
@endsection

