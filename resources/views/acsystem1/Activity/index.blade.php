<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>{{ config('blog.title') }} Admin</title>
    <!-- basic styles -->
    <link href="{{asset('assets/css/bootstrap.min.css')}}" rel="stylesheet"/>
    <link href="{{asset('assets/bootstrap-table/src/bootstrap-table.css')}}" rel="stylesheet"/>

    <link rel="stylesheet" href="{{asset('assets/css/main.css')}}"/>
    <link rel="stylesheet" href="{{asset('assets/css/font-awesome.min.css')}}"/>
    <link rel="stylesheet" href="{{asset('assets/css/dashboard.css')}}"/>
    <link rel="stylesheet" href="{{asset('assets/css/common.css')}}"/>
    <link rel="stylesheet" href="{{asset('css/activity_css/modify.css')}}"/>

    {{--<link href="{{asset('origin_bootstrap/css/bootstrap.min.css')}}" rel="stylesheet">--}}
    <link href="{{asset('assets/bootstrap-table/src/bootstrap-table.css')}}" rel="stylesheet"/>

    <script src="{{asset('assets/js/jquery-1.10.2.min.js')}}"></script>
    <script src="{{asset('origin_bootstrap/js/bootstrap.min.js')}}"></script>
    {{--活动表格--}}
    <script src="{{asset('assets/bootstrap-table/src/bootstrap-table.js')}}"></script>
    <script src="{{asset('assets/bootstrap-table/src/locale/bootstrap-table-zh-CN.js')}}"></script>

    @yield('styles')

        <!--[if lt IE 9]>
    <script src="//oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
    <script src="//oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
    <style>
        .row{
            margin-left: 255px
        }
        .container-fluid{
            padding-right: 10px;
            padding-left: 15px;
            margin-right: auto;
            margin-left: auto;
        }
        @media screen and (max-width: 1400px){
            .row{
                margin-left: 220px
            }
        }
        /*手机屏幕大小下自适应调节*/
        @media screen and (max-width: 768px){
            .container-fluid{
                overflow-x: auto;
                min-width: 1900px;
            }
            /*详细信息的弹出窗口位置*/
            .modal-content{
                width: 600px;
                left: 25%;
            }
        }
        @media screen and (max-width: 415px){
            .container-fluid{
                overflow-x: auto;
                min-width: 1275px;
            }
        }
    </style>
</head>
<body>

@include('layout.header')
@include('layout.sidebar')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-12" style="margin-top: 20px;">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title">活动概览</h3>
                </div>
                <div class="panel-body">

                    <table data-toggle="table" id="activity-table"
                           data-halign="center" data-align="center"
                           data-url="/activity/teacher/show/{{ Auth::User()->id}}">
                        <thead>
                        <tr>
                            <th data-field="Number" data-formatter="actionFormatterNumber" data-halign="center" data-align="center" >序号</th>
                            <th data-field="name" data-halign="center" data-align="center">活动名称</th>
                            <th data-field="teacher" data-halign="center" data-align="center">主讲人</th>
                            <th data-field="place" data-halign="center" data-align="center">活动地点</th>
                            <th data-field="start_time" data-halign="center" data-align="center">活动开始时间</th>
                            <th data-field="end_time" data-halign="center" data-align="center">活动结束时间</th>
                            <th data-field="remainder_num" data-halign="center" data-align="center">剩余名额</th>
                            <th data-field="apply_state" data-halign="center" data-align="center">报名状态</th>
                            <th data-field="action" data-halign="center" data-align="center"
                                data-formatter="activityInfo" data-events="actionEvents" >活动详情</th>
                            <th data-field="attend" data-halign="center" data-align="center"
                                data-formatter="attendInfo" data-events="actionEvents" >报名情况</th>
                        </tr>
                        </thead>
                    </table>
                </div>
            </div>
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title">我参加过的活动</h3>
                </div>
                <div class="panel-body">
                    <table data-toggle="table" id="history-table"
                           data-halign="center" data-align="center"
                           data-search="true"
                           data-url="/activity/teacher/attend/{{ Auth::User()->id }}">
                        <thead>
                        <tr>
                            <th data-field="Number" data-formatter="actionFormatterNumber" data-halign="center" data-align="center" >序号</th>
                            <th data-field="name" data-halign="center" data-align="center">活动名称</th>
                            <th data-field="teacher" data-halign="center" data-align="center">主讲人</th>
                            <th data-field="place" data-halign="center" data-align="center">活动地点</th>
                            <th data-field="apply_state" data-halign="center" data-align="center">报名状态</th>
                            <th data-field="term" data-halign="center" data-align="center">活动学期</th>
                            <th data-field="action" data-halign="center" data-align="center"
                                data-formatter="activityInfo" data-events="actionEvents" >活动详情</th>
                        </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <div class="row">

        <button id="check-activity" data-toggle="modal" data-target="#checkout-activity" style="display: none">
            查看活动
        </button>
        <!-- 查看详情的 模态框（Modal） -->
        <div class="modal fade" id="checkout-activity" tabindex="-1" role="dialog" aria-hidden="true">
            <div id="#add-activity-modal" class="modal-dialog" style="margin-top: 10%">
                <div class="modal-content">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <h2 class="panel-title">活动详情
                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
                                    &times;
                                </button>
                            </h2>
                        </div>
                        <div class="panel-body">
                            <div class="row" style="margin-left: 0px">
                                <p><span style="font-weight: bold;">活动名称：&nbsp;&nbsp;</span>
                                    <span id="act-name" ></span>
                                </p>
                                <p><span style="font-weight: bold;">活动地点：&nbsp;&nbsp;</span>
                                    <span id="act-place" ></span>
                                </p>
                                <p><span style="font-weight: bold;">活动时间：&nbsp;&nbsp;</span>
                                    <span id="act-time" ></span>
                                </p>
                                <p><span style="font-weight: bold;">报名时间：&nbsp;&nbsp;</span>
                                    <span id="apply_act-time" ></span>
                                </p>
                                <p><span style="font-weight: bold;">活动信息：&nbsp;&nbsp;</span>
                                    <span id="act-info" ></span>
                                </p>
                            </div>
                        </div>
                    </div>

                </div><!-- /.modal-content -->
            </div><!-- /.modal -->
        </div>

    </div>
</div>
<script>
    var userId='{{Auth::User()->id}}';

</script>
<script src="{{asset('js/activity/index.js')}}"></script>

</body>
</html>

