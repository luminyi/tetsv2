<!DOCTYPE html>
<meta name="render" content="webkit">
<meta http-equiv="X-UA-Compatible" content="IE=11">

<style type="text/css">
    * {
        font-family: "Microsoft YaHei"
    }

    .nav_a {
        cursor: pointer;
    }

    .panel-add {
        color: #fff;
        background-color: #97d3c5 !important;
        border-color: #97d3c5 !important;
    }

    .panel-red {
        color: #fff;
        background-color: #f68484 !important;
        border-color: #f68484 !important;
    }

    .panel-blue {
        color: #fff;
        background-color: #75B9E6 !important;
        border-color: #75B9E6 !important;
    }

    .table thead > tr > th, .table tbody > tr > th, .table tfoot > tr > th, .table thead > tr > td, .table tbody > tr > td, .table tfoot > tr > td {
        padding: 3px !important;
    }

    .load-all {
        color: #428bca;
        float: right;
        margin-top: -10px;
        cursor: pointer;
    }

</style>
<head>
    <meta charset="utf-8"/>
    <title>北京林业大学教评中心业务平台</title>
    <meta name="keywords" content="北京林业大学教评中心业务平台"/>
    <meta name="description" content="北京林业大学教评中心业务平台"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <!-- basic styles -->
    <link href="{{asset('assets/css/bootstrap.min.css')}}" rel="stylesheet"/>
    <link href="{{asset('assets/bootstrap-table/src/bootstrap-table.css')}}" rel="stylesheet"/>


    <link rel="stylesheet" href="{{asset('assets/css/font-awesome.min.css')}}"/>
    <link rel="stylesheet" href="{{asset('assets/css/dashboard.css')}}"/>
    <link rel="stylesheet" href="{{asset('assets/css/common.css')}}"/>
    <link rel="stylesheet" href="{{asset('assets/css/main.css')}}"/>
    <link rel="stylesheet" href="{{asset('css/activity_css/modify.css')}}"/>

    {{--the style of school-term-choose--}}
    <link rel="stylesheet" type="text/css" href="{{asset('calendar/DateTimePicker.css')}}" />


    {{--the style of school-term-choose--}}
    <link rel="stylesheet" type="text/css" href="{{asset('calendar1/css/bootstrap-datetimepicker.css')}}" />


    <!--[if IE 7]>
    <link rel="stylesheet" href="{{asset('assets/css/font-awesome-ie7.min.css')}}"/>
    <![endif]-->

    <!--[if lt IE 9]>
    <link rel="stylesheet" href="{{asset('assets/js/html5shiv.js')}}"/>
    <link rel="stylesheet" href="{{asset('assets/js/respond.min.js')}}"/>
    <![endif]-->
    <script src="{{asset('assets/js/jquery-2.0.3.min.js')}}"></script>
    <script src="{{asset('origin_bootstrap/js/bootstrap.min.js')}}"></script>

    {{--活动表格--}}
    <script src="{{asset('assets/bootstrap-table/src/bootstrap-table.js')}}"></script>
    <script src="{{asset('assets/bootstrap-table/src/locale/bootstrap-table-zh-CN.js')}}"></script>

    {{--活动时间选择--}}
    {{--<script src="{{asset('calendar1/js/locales/bootstrap-datetimepicker.zh-CN.js')}}"></script>--}}

    <script src="{{asset('calendar1/js/bootstrap-datetimepicker.js')}}"></script>
</head>
{{--<link rel="stylesheet" href="{{asset('css/Index.css')}}">--}}
<html lang="en">
<body>
@include('layout.header')
@include('layout.sidebar')
<div class="container-fluid col-md-offset-2">
    <div class="row page-title-row">
        <div class="col-md-12">
            <h3>
                <small></small>
            </h3>
        </div>
    </div>

    <div class="row">

        <div class="col-md-10 col-md-offset-1">
            <div class="panel panel-default">
                <ul id="myTab" class="nav nav-tabs">
                    <li class="active">
                        <a href="#undo" data-toggle="tab">
                            待协调咨询项
                        </a>
                    </li>
                    <li>
                        <a href="#done" data-toggle="tab">
                            已协调咨询项
                        </a>
                    </li>
                </ul>
                <div id="myTabContent" class="tab-content">
                    <div class="tab-pane fade in active" id="undo">
                        @include('acsystem.Consult.Admin.AdjustParticles.Undo')
                    </div>
                    <div class="tab-pane fade" id="done">
                        @include('acsystem.Consult.Admin.AdjustParticles.Done')
                    </div>

                </div>
                @include('acsystem.partials.errors')


            </div>
        </div>
    </div>


    <div class="row">

        <button id="coordinate" data-toggle="modal" data-target="#Coordinate" style="display: none">
            查看活动
        </button>
        <!-- 查看详情的 模态框（Modal） -->
        <div class="modal fade" id="Coordinate" tabindex="-1" role="dialog" aria-hidden="true">
            <div id="#add-activity-modal" class="modal-dialog" style="width:40%; margin-top: 0%">
                <div class="modal-content">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <h2 class="panel-title">咨询详情
                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
                                    &times;
                                </button>
                            </h2>
                        </div>
                        <form class="form-horizontal" role="form" method="POST" action="/consult/coordinate">
                            <input type="hidden" name="_token" value="{{ csrf_token() }}">
                            <div class="panel-body">
                                <div class="row">
                                    <p><span style="font-weight: bold;">申请教师：&nbsp;&nbsp;</span>
                                        <span id="act-teacher-co" ></span>
                                    </p>
                                    <p><span style="font-weight: bold;">咨询名称：&nbsp;&nbsp;</span>
                                        <span id="act-name-co" ></span>
                                    </p>
                                    <p><span style="font-weight: bold;">咨询内容：&nbsp;&nbsp;</span>
                                        <span id="act-info-co" ></span>
                                    </p>
                                </div>
                            </div>
                            <p align="center"><span style="font-weight: bold;font-size:16px">回复内容</span></p>
                            <input type="hidden" value="" name="consult_id" id="consult_id">
                            <input type="hidden" value="" name="comment_user_id" id="comment_user_id">
                            <div align="center">
                                <textarea class="form-control" id="reply" name="reply" rows="20" style="width:95%"></textarea>
                            </div>
                            <div style="text-align:center">
                                <button type="submit" class="btn btn-primary btn-md">
                                    <i class="fa fa-plus-circle"></i>
                                    回复
                                </button>
                            </div>
                        </form>
                    </div>


                </div><!-- /.modal-content -->
            </div><!-- /.modal -->
        </div>

    </div>



    <div class="row">

        <button id="check-consult" data-toggle="modal" data-target="#checkout-consult" style="display: none">
            查看活动
        </button>
        <!-- 查看详情的 模态框（Modal） -->
        <div class="modal fade" id="checkout-consult" tabindex="-1" role="dialog" aria-hidden="true">
            <div id="#add-activity-modal" class="modal-dialog" style="width:50%; margin-top: 10%">
                <div class="modal-content">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <h2 class="panel-title">咨询详情
                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
                                    &times;
                                </button>
                            </h2>
                        </div>
                        <div class="panel-body">
                            <div class="row">
                                <p><span style="font-weight: bold;">申请教师：&nbsp;&nbsp;</span>
                                    <span id="act-teacher-in" ></span>
                                </p>
                                <p><span style="font-weight: bold;">咨询名称：&nbsp;&nbsp;</span>
                                    <span id="act-name-in" ></span>
                                </p>
                                <p><span style="font-weight: bold;">咨询内容：&nbsp;&nbsp;</span>
                                    <span id="act-info-in" ></span>
                                </p>
                                <p><span style="font-weight: bold;">回复内容：&nbsp;&nbsp;</span>
                                    <span id="act-content-in" ></span>
                                </p>
                            </div>
                        </div>
                    </div>

                </div><!-- /.modal-content -->
            </div><!-- /.modal -->
        </div>

    </div>
</div>
<script src="{{asset('js/consult/adjust.js')}}"></script>
<script src="{{asset('js/HelpFunction.js')}}"></script>
<script>
    var csrf_token='{{csrf_token()}}';
</script>
</body>


</html>

