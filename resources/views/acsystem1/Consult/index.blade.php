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
                width: 520px;
                left: 14%;
                margin-top: 34%;
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
    <div class="row" style="margin-top: 25px">
        <div class="col-md-6" >
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title">提交咨询</h3>
                </div>
                <div class="panel-body">

                    @include('ACSystem.partials.errors')
                    @include('acsystem.partials.success')

                    <form class="form-horizontal" role="form" method="POST" action="/consult/post1">
                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                        <div class="form-group">
                            <label for="reverse_direction" class="col-md-3 control-label">
                                咨询类别
                            </label>
                            <div class="col-md-7">
                                @foreach($consultType as $consult)
                                    <label class="radio-inline">
                                        <input type="radio" name="consults_type_id"
                                               checked=""
                                               value="{{$consult->id}}">
                                        {{$consult->name}}
                                    </label>
                                @endforeach
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="phone" class="col-md-3 control-label">
                                电话
                            </label>
                            <div class="col-md-8">
                                <input type="tel" class="form-control" name="phone" id="phone" value="{{$phone}}">
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="meta_description" class="col-md-3 control-label">
                                咨询细节(选填)
                            </label>
                            <div class="col-md-8">
                                    <textarea class="form-control" id="meta_description" name="meta_description" rows="20"></textarea>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-md-7 col-md-offset-3">
                                <button type="submit" class="btn btn-primary btn-md">
                                    <i class="fa fa-plus-circle"></i>
                                    确定
                                </button>
                            </div>
                        </div>

                    </form>

                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title">历史咨询</h3>
                </div>
                <div class="panel-body">
                    <table data-toggle="table" id="consultTable"
                           data-halign="center" data-align="center"
                           data-search="true"
                           data-url="/consult/ConsultHistory/{{Auth::User()->id}}">
                        <thead>
                        <tr>
                            <th data-field="Number" data-formatter="actionFormatterNumber" data-halign="center" data-align="center" >序号</th>
                            <th data-field="name" data-halign="center" data-align="center">咨询名称</th>
                            <th data-field="submit_time" data-halign="center" data-align="center">提交时间</th>
                            <th data-field="state" data-halign="center" data-align="center">协调状态</th>
                            <th data-field="action" data-halign="center" data-align="center"
                                data-formatter="ConsultInfo" data-events="actionEvents" >咨询详情</th>
                        </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <div class="row">

        <button id="check-consult" data-toggle="modal" data-target="#checkout-consult" style="display: none">
            查看活动
        </button>
        <!-- 查看详情的 模态框（Modal） -->
        <div class="modal fade" id="checkout-consult" tabindex="-1" role="dialog" aria-hidden="true">
            <div id="#add-activity-modal" class="modal-dialog" style="margin-top: 10%">
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
                            <div>
                                <p><span style="font-weight: bold;">咨询名称：&nbsp;&nbsp;</span>
                                    <span id="act-name" ></span>
                                </p>
                                <p><span style="font-weight: bold;">咨询内容：&nbsp;&nbsp;</span>
                                    <span id="act-info" ></span>
                                </p>
                                <p><span style="font-weight: bold;">回复内容：&nbsp;&nbsp;</span>
                                    <span id="act-content" ></span>
                                </p>
                            </div>
                        </div>
                    </div>

                </div><!-- /.modal-content -->
            </div><!-- /.modal -->
        </div>

    </div>
</div>
<script src="/js/consult/index.js"></script>

</body>
</html>
