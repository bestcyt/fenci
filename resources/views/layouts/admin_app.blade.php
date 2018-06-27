<!DOCTYPE html>
<html>

<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <meta name="csrf-token" content="{{ csrf_token() }}">

    <link rel="shortcut icon" href="/web.ico" />
    <title> 文章分词管理系统</title>

    <link href="/css/bootstrap.css" rel="stylesheet">
    <link href="/font-awesome/css/font-awesome.css" rel="stylesheet">

    <link href="/css/plugins/dataTables/datatables.min.css" rel="stylesheet">

    <link href="/css/animate.css" rel="stylesheet">
    <link href="/css/style.css" rel="stylesheet">
    @yield('css')
</head>

<body>

<div id="wrapper">

    <nav class="navbar-default navbar-static-side" role="navigation">
        <div class="sidebar-collapse">
            <ul class="nav metismenu" id="side-menu">
                <li class="nav-header">
                    <div class="dropdown profile-element"> <span>
                            <img alt="image" class="img-circle" src="{{ env('APP_URL').'/2.jpg' }}" style="width: 50px;height: 50px;"/>
                             </span>
                        <a data-toggle="dropdown" class="dropdown-toggle" href="#">
                            <span class="clear">
                                <span class="block menu">
                                    <strong class="font-bold">{{ auth()->user()->nickname }}</strong>
                                </span>
                                <span class="text-muted text-xs block">编辑资料<b class="caret"></b>
                                </span>
                            </span>
                        </a>

                        <ul class="dropdown-menu animated fadeInRight menu">
                            <li><a href="{{ url('admin/user/'.auth()->user()->id.'/edit') }}">编辑个人资料</a></li>
                            <li class="divider"></li>
                            <li>
                                <a href="{{ route('logout') }}"
                                   onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                    <i class="fa fa-sign-out"></i> Logout
                                </a>
                            </li>
                        </ul>
                    </div>
                    <div class="logo-element">
                        Overseas
                    </div>
                </li>
                <li>
                    <a href="#"><i class="fa fa-user"></i> <span class="nav-label">词汇管理</span> <span class="fa arrow"></span></a>
                    <ul class="nav nav-second-level collapse">
                        <li><a href="{{ url('admin/word/index') }}">词汇列表</a></li>
                        <li><a href="{{ url('admin/word/create') }}">重导词汇</a></li>
                    </ul>

                </li>
                <li>
                    <a href="#"><i class="fa fa-user"></i> <span class="nav-label">文章管理</span> <span class="fa arrow"></span></a>
                    <ul class="nav nav-second-level collapse">
                        <li><a href="{{ url('admin/article/create') }}">分级标注</a></li>
                        <li><a href="{{ url('admin/article/wordCount') }}">词频统计</a></li>
                        <li><a href="{{ url('admin/article/wordMean') }}">段落释义</a></li>
                    </ul>
                </li>
            </ul>
        </div>
    </nav>

    <div id="page-wrapper" class="gray-bg"  style="height: 100%">
        <div class="row border-bottom">
            <nav class="navbar navbar-static-top" role="navigation" style="margin-bottom: 0">
                <div class="navbar-header">
                    <a class="navbar-minimalize minimalize-styl-2 btn btn-primary " href="#"><i class="fa fa-bars"></i> </a>
                </div>
                <ul class="nav navbar-top-links navbar-right">
                    <li>
                        <a href="{{ route('logout') }}"
                           onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                            <i class="fa fa-sign-out"></i> Logout
                        </a>
                        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                            {{ csrf_field() }}
                        </form>
                    </li>
                </ul>
            </nav>
        </div>
        <!--content-->
        @yield('content')
        <!--end content-->
        <div class="footer">
            <div class="pull-right">
                Create by <strong><a href="http://bbs.bestcyt.cn" target="_blank">bbs.bestcyt.cn</a></strong> Free.
            </div>
            <div>
                {{--<strong>Copyright</strong> KaiYuan GmbH &copy; 2002-2018--}}
            </div>
        </div>

    </div>
</div>



<!-- Mainly scripts -->
{{--<script src="https://code.jquery.com/jquery-3.0.0.min.js"></script>--}}
@if(isset($guojia))
    <script src="/js/jquery-2.1.1.js"></script>
    @else
    <script src="/js/jquery-3.1.1.min.js"></script>
@endif



<script src="/js/bootstrap.js"></script>
<script src="/js/plugins/metisMenu/jquery.metisMenu.js"></script>
<script src="/js/plugins/slimscroll/jquery.slimscroll.min.js"></script>

<!-- Custom and plugin javascript -->
<script src="/js/inspinia.js"></script>
<script src="/js/plugins/pace/pace.min.js"></script>

@yield('js')

<script>

    $(function () {
        $('div.alert').not('.alert-important').delay(3000).fadeOut(350);
//        $(".btnloading").click(function(){
//            $(this).button('loading');
//            setTimeout(function () { $(this).button('complete'); },2000);
//        });
    })
</script>
</body>

</html>
