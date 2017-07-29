<!DOCTYPE html>
<meta name="render" content="webkit">
<meta http-equiv="X-UA-Compatible" content="IE=11">

<style type="text/css">
    *{font-family:"Microsoft YaHei"}
    .nav_a{
        cursor: pointer;
    }
    .panel-add{
        color: #fff;
        background-color: #97d3c5 !important;
        border-color: #97d3c5 !important;
    }
    .panel-red{
        color: #fff;
        background-color: #f68484 !important;
        border-color: #f68484 !important;
    }
    .panel-blue{
        color: #fff;
        background-color: #75B9E6 !important;
        border-color: #75B9E6 !important;
    }
    .table thead>tr>th, .table tbody>tr>th, .table tfoot>tr>th, .table thead>tr>td, .table tbody>tr>td, .table tfoot>tr>td{
        padding: 3px !important;
    }
    .load-all{
        color:#428bca;
        float: right;
        margin-top: -10px;
        cursor: pointer;
    }
    #min797{
        margin-left: 250px;
    }
    @media screen and (max-width: 1400px){
        #min797{
            margin-left: 220px;
        }
    }
    @media screen and (max-width: 797px){
        #min797{
            width: 1660px;
        }

    }
</style>
<head>
    <meta charset="utf-8" />
    <title>北京林业大学教评中心业务平台</title>
    <meta name="keywords" content="北京林业大学教评中心业务平台"/>
    <meta name="description" content="北京林业大学教评中心业务平台"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <!-- basic styles -->
    {{--<link href="{{asset('assets/css/bootstrap.min.css')}}" rel="stylesheet" />--}}
    <link href="{{asset('assets/css/bootstrap.min.css')}}" rel="stylesheet" />
    <link rel="stylesheet" href="{{asset('assets/css/font-awesome.min.css')}}" />
    <link rel="stylesheet" href="{{asset('assets/css/dashboard.css')}}" />
    <link rel="stylesheet" href="{{asset('assets/css/common.css')}}" />
    <link rel="stylesheet" href="{{asset('assets/css/main.css')}}" />

    <!--[if IE 7]>
    <link rel="stylesheet" href="{{asset('assets/css/font-awesome-ie7.min.css')}}" />
    <![endif]-->

    <!--[if lt IE 9]>
    <link rel="stylesheet" href="{{asset('assets/js/html5shiv.js')}}" />
    <link rel="stylesheet" href="{{asset('assets/js/respond.min.js')}}" />
    <![endif]-->
    <script src="{{asset('assets/js/jquery-2.0.3.min.js')}}"></script>
    <script src="{{asset('origin_bootstrap/js/bootstrap.min.js')}}"></script>
</head>
<link rel="stylesheet" href="{{asset('css/Index.css')}}">
<html lang="en">
<body>
@if(session('role')=='教师')
    <script>
        window.location = "/activity/index";
    </script>
@endif


@include('layout.header')
@include('layout.sidebar')
<div class="container-fluid clearfix">
    <div class="row clearfix">

        @if(session('role')=='督导')
            <script>
                window.location = "/EverEvaluated";
            </script>
        @else
            <input id="getlevel" value="{{session('role')}}" style="display: none"/>
            <input id="getunit" value="{{Auth::User()->unit}}" style="display: none"/>
            <input id="getgroup" value="{{Auth::User()->group}}" style="display: none"/>

            <div id="min797" class="col-sm-10 col-sm-offset-2 col-md-10 col-md-offset-2" style="float: left;">
            {{--<div class="" style="float: left;margin-left:260px;width: 1660px">--}}
                <!-- .breadcrumb -->
                <div class="breadcrumbs" id="breadcrumbs">
                    <ul class="breadcrumb" style="padding-top: 22px; padding-bottom: 12px;">
                    </ul>
                </div>
                <!-- .breadcrumb -->
                <!-- .page-content 开始 -->
                <div id="content">
                    <!-- Start .content-wrapper -->
                    <div class="content-wrapper">
                        {{--<div class="row">--}}
                        {{--这里是标题--}}
                        {{--<!-- End .page-header -->--}}
                        {{--</div>--}}
                                <!-- End .row -->
                        <div class="outlet">
                            <!-- Start .outlet -->
                            <!-- Page start here ( usual with .row ) -->
                            <div class="row">
                                <!-- Start .row -->
                                {{--<div class="" style="float: left;width: 380px;margin-left: 11px;margin-right: 11px">--}}
                                <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
                                    <div class="carousel-tile carousel vertical slide">
                                        <div class="carousel-inner">
                                            <div class="item active">
                                                <div class="tile red">
                                                    <div class="tile-icon">
                                                        <i class="br-cart s64"></i>
                                                    </div>
                                                    @if(session('role')=='校级' || session('role')=='大组长')
                                                        <div class="tile-content">
                                                            <div class="number so_num"></div>
                                                            <h3>全校督导</h3>
                                                        </div>
                                                    @endif
                                                    @if(session('role')=='院级')
                                                        <div class="tile-content">
                                                            <div class="number so_num"></div>
                                                            <h3>{{Auth::User()->unit}}督导</h3>
                                                        </div>
                                                    @endif
                                                    @if(session('role')=='小组长')
                                                        <div class="tile-content">
                                                            <div class="number group_num"></div>
                                                            <h3>{{Auth::User()->group}}督导</h3>
                                                        </div>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- End Carousel -->
                                </div>

                                <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
                                {{--<div class="" style="float: left;width: 380px;margin-left: 11px;margin-right: 11px">--}}
                                    <div class="carousel-tile carousel slide">
                                        <div class="carousel-inner">
                                            <div class="item active">
                                                <div class="tile blue">
                                                    <div class="tile-icon">
                                                        <i class="st-chat s64"></i>
                                                    </div>

                                                    @if(session('role')=='校级' || session('role')=='大组长')
                                                        <div class="tile-content">
                                                            <div class="number nec_num"></div>
                                                            <h3>学期关注课程</h3>
                                                        </div>
                                                    @endif
                                                    @if(session('role')=='院级')
                                                        <div class="tile-content">
                                                            <div class="number nec_num"></div>
                                                            <h3>{{Auth::User()->unit}} 关注课程</h3>
                                                        </div>
                                                    @endif
                                                    @if(session('role')=='小组长')
                                                        <div class="tile-content">
                                                            <div class="number group_nece_num"></div>
                                                            <h3>{{Auth::User()->group}} 关注课程</h3>
                                                        </div>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- End Carousel -->
                                </div>

                                <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
                                {{--<div class="" style="float: left;width: 380px;margin-left: 11px;margin-right: 11px">--}}
                                    <div class="carousel-tile carousel vertical slide">
                                        <div class="carousel-inner">
                                            <div class="item active">
                                                <div class="tile green">
                                                    <div class="tile-icon">
                                                        <i class="ec-users s64"></i>
                                                    </div>
                                                    @if(session('role')=='校级' ||session('role')=='大组长')
                                                        <div class="tile-content">
                                                            <div class="number FineshedNecess"></div>
                                                            <h3>关注课程已评价</h3>
                                                        </div>
                                                    @endif
                                                    @if(session('role')=='院级')
                                                        <div class="tile-content">
                                                            <div class="number FineshedNecess"></div>
                                                            <h3>{{Auth::User()->unit}} 关注课程已评价</h3>
                                                        </div>
                                                    @endif
                                                    @if(session('role')=='小组长')
                                                        <div class="tile-content">
                                                            <div class="number group_FineshedNecess"></div>
                                                            <h3>{{Auth::User()->group}} 关注课程已评价</h3>
                                                        </div>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- End Carousel -->
                                </div>

                                <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
                                {{--<div class="" style="float: left;width: 380px;margin-left: 11px;margin-right: 11px">--}}
                                    <div class="carousel-tile carousel slide">
                                        <div class="carousel-inner">
                                            <div class="item active">
                                                <div class="tile teal">
                                                    <!-- tile start here -->
                                                    <div class="tile-icon">
                                                        <i class="ec-images s64"></i>
                                                    </div>
                                                    @if(session('role')=='校级' || session('role')=='大组长')
                                                        <div class="tile-content">
                                                            <div class="number Fineshed"></div>
                                                            <h3>全校已评价课程</h3>
                                                        </div>
                                                    @endif
                                                    @if(session('role')=='院级')
                                                        <div class="tile-content">
                                                            <div class="number Fineshed"></div>
                                                            <h3>{{Auth::User()->unit}}已评价课程</h3>
                                                        </div>
                                                    @endif
                                                    @if(session('role')=='小组长')
                                                        <div class="tile-content">
                                                            <div class="number group_Fineshed"></div>
                                                            <h3>{{Auth::User()->group}} 已评价课程</h3>
                                                        </div>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- End Carousel -->
                                </div>
                            </div>
                            <!-- End .row -->
                            @if(session('role')=='小组长'||session('role')=='院级')
                                <div class="row">
                                    <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12 sortable-layout">
                                        <!-- Start col-lg-6 -->
                                        <div class="panel panel-add plain toggle panelMove panelClose panelRefresh">
                                            <!-- Start .panel -->
                                            <div class="panel-heading">
                                                <h4 class="panel-title"><i class="im-bars"></i> 关注课程完成情况</h4>
                                            </div>
                                            <div class="panel-body blue-bg">
                                                <div id="main1" style="width: 100%; height:550px;"></div>
                                            </div>
                                        </div>
                                        <!-- End .panel -->

                                    </div>
                                    <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12 sortable-layout">
                                        <!-- Start col-lg-6 -->
                                        <div class="panel panel-red plain toggle panelMove panelClose panelRefresh">
                                            <!-- Start .panel -->
                                            <div class="panel-heading">
                                                <h4 class="panel-title"><i class="im-bars"></i>督导最新评价列表</h4>
                                            </div>
                                            <div class="panel-body blue-bg">
                                                <div style="width: 100%; height:550px;">
                                                    <table class="table" style="color:#333;height:520px;">
                                                        <thead>
                                                        <tr>
                                                            <th>督导</th>
                                                            <th>课程</th>
                                                            <th>听课时间</th>
                                                        </tr>
                                                        </thead>
                                                        <tbody class="evaluate">

                                                        </tbody>

                                                    </table>
                                                    <a href="/EverEvaluated" class="load-all">显示全部
                                                        <i class=" icon-arrow-right" style="color: #428bca;"></i>
                                                    </a>
                                                </div>

                                            </div>
                                        </div>
                                        <!-- End .panel -->

                                    </div>
                                    <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12 sortable-layout">
                                        <!-- Start col-lg-6 -->
                                        <div class="panel panel-blue plain toggle panelMove panelClose panelRefresh">
                                            <!-- Start .panel -->
                                            <div class="panel-heading">
                                                <h4 class="panel-title"><i class="im-bars"></i>督导类型占比情况</h4>
                                            </div>
                                            <div class="panel-body blue-bg">
                                                <div id="main4" style="width: 100%; height:550px;"></div>
                                            </div>
                                        </div>
                                        <!-- End .panel -->

                                    </div>
                                </div>
                            @endif
                            @if(session('role')=='校级' ||session('role')=='大组长')
                                <div class="row">
                                    <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12 sortable-layout">
                                        <!-- Start col-lg-6 -->
                                        <div class="panel panel-add plain toggle panelMove panelClose panelRefresh">
                                            <!-- Start .panel -->
                                            <div class="panel-heading">
                                                <h4 class="panel-title"><i class="im-bars"></i> 关注课程完成情况</h4>
                                            </div>
                                            <div class="panel-body blue-bg">
                                                <div id="main1" style="width: 100%; height:300px;"></div>
                                            </div>
                                        </div>
                                        <!-- End .panel -->

                                    </div>
                                    <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12 sortable-layout">
                                        <!-- Start col-lg-6 -->
                                        <div class="panel panel-red plain toggle panelMove panelClose panelRefresh">
                                            <!-- Start .panel -->
                                            <div class="panel-heading">
                                                <h4 class="panel-title"><i class="im-bars"></i>督导最新评价列表</h4>
                                            </div>
                                            <div class="panel-body blue-bg">
                                                <div style="width: 100%; height:300px;">
                                                    <table class="table" style="color:#333;height:200px;">
                                                        <thead>
                                                        <tr>
                                                            <th>督导</th>
                                                            <th>课程</th>
                                                            <th>听课时间</th>
                                                        </tr>
                                                        </thead>
                                                        <tbody class="evaluate">

                                                        </tbody>

                                                    </table>
                                                    <a href="/EverEvaluated" class="load-all">显示全部
                                                        <i class=" icon-arrow-right" style="color: #428bca;"></i>
                                                    </a>
                                                </div>

                                            </div>
                                        </div>
                                        <!-- End .panel -->

                                    </div>
                                    <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12 sortable-layout">
                                        <!-- Start col-lg-6 -->
                                        <div class="panel panel-blue plain toggle panelMove panelClose panelRefresh">
                                            <!-- Start .panel -->
                                            <div class="panel-heading">
                                                <h4 class="panel-title"><i class="im-bars"></i>督导类型占比情况</h4>
                                            </div>
                                            <div class="panel-body blue-bg">
                                                <div id="main4" style="width: 100%; height:300px;"></div>
                                            </div>
                                        </div>
                                        <!-- End .panel -->

                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 sortable-layout">
                                        <div class="weather-widget panel panel-primary plain toggle panelMove panelClose panelRefresh">
                                            <!-- Start .panel -->
                                            <div class="panel-heading">
                                                <h4 class="panel-title">学院已评价课程数</h4>
                                            </div>
                                            <div class="panel-body blue-bg text-center">
                                                <div id="main3" style="width: 100%; height:600px;"></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                @endif
                                        <!-- End .row -->
                                <!-- Page End here -->
                        </div>
                        <!-- End .outlet -->
                    </div>
                    <!-- End .content-wrapper -->
                    <div class="clearfix"></div>
                </div>
                <!-- .page-content 结束 -->
            </div>
            <!-- 面板结束 -->
        @endif
    </div>
</div>
</body>

<script src="{{asset('assets/js/echarts.min.js')}}"></script>
<script src="{{asset('js/index.js')}}"></script>
<script>

</script>

</html>
