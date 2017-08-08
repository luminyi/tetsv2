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
    {{--the style of school-term-choose--}}
    <link rel="stylesheet" type="text/css" href="{{asset('calendar/DateTimePicker.css')}}" />
    <link rel="stylesheet" href="{{asset('css/TeachEva/TeacherEvaluation.css')}}" />
    <link rel="stylesheet" href="/assets/css/font-awesome.min.css" />

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
        @media screen and (max-width: 768px){
            .container-fluid{
                overflow-x: auto;
                min-width: 1900px;
            }
            #dtpick{
                top: 22%;
                left: 12%;
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
                    <h3 class="panel-title">教学评价</h3>
                </div>
                <div class="panel-body">
                    学年学期
                    @include('acsystem1.partials.year-term-calender')

                    <button id="view" class="btn btn-primary btn-raised">
                        <i class="glyphicon glyphicon-search"></i> 查询
                    </button>

                    <div class="finishedTable">
                        <table id="finished" data-toggle="table"
                               data-classes="table table-hover table-bordered"
                               data-click-to-select="true"
                               data-show-pagination-switch="true"
                               data-pagination="true"
                               data-search = "true"
                               data-page-list="[5, 10, 20, 50, 100, 200]">
                            <thead>
                            <tr>
                                <th data-field="Number" data-formatter="actionFormatterNumber"
                                    data-halign="center" data-align="center" >序号</th>
                                <th data-field="课程名称" data-halign="center" data-align="center">课程名称</th>
                                <th data-field="任课教师" data-halign="center" data-align="center">任课教师</th>
                                <th data-field="听课时间" data-halign="center" data-align="center">听课时间</th>
                                <th data-field="action" data-align="center"  data-formatter="actionUnitFormatter" data-events="actionEvents">评价详情</th>
                            </tr>
                            </thead>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>

<button id="detail" class="btn btn-primary btn-lg" data-toggle="modal" data-target="#myModal1" style="display: none">
    开始演示模态框
</button>

<div class="modal fade bs-example-modal-lg" id="myModal1" tabindex="-1" role="dialog"
     aria-labelledby="myModalLabel" aria-hidden="true" style="overflow-x: auto">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"
                        aria-hidden="true">×
                </button>
                <h4 class="modal-title" id="myModalLabel">
                    评价详情
                </h4>
            </div>
            <div class="modal-body">
                <div class="panel-heading">
                    <p style="font-size:20px; " class="panel-title">北京林业大学本科教学督导听课评价表</p>
                </div>
                <div class="panel-body">
                    <form class="form-horizontal">
                        <div class="form-group">
                            <span for="inputChapter" class="col-lg-1" style="padding-top: 8px;" >章节内容</span>
                            <div class="col-sm-2">
                                <input type="text" class="form-control" id="inputChapter" readonly="readonly">
                            </div>
                            {{--<span for="LessonSupervisor" class="col-lg-1" style="padding-top: 8px;" >听课督导</span>--}}
                            {{--<div class="col-sm-2">--}}
                            {{--<input type="text" class="form-control" id="LessonSupervisor" readonly="readonly">--}}
                            {{--</div>--}}
                            <span for="LessonAttr" class="col-lg-1" style="padding-top: 8px;" >课程属性</span>
                            <div class="col-sm-2">
                                <input type="text" class="form-control" id="LessonAttr" readonly="readonly">
                            </div>
                        </div>
                    </form>
                    <table class="table table-bordered">
                        <tr>
                            <th>课程名称</th>
                            <th>任课教师</th>
                            <th>听课节次</th>
                            <th>上课班级</th>
                            <th>上课地点</th>
                            <th>听课时间</th>
                        </tr>
                        <tr>
                            <td><input type="text" class="form-control" id="LessonName" readonly="readonly"></td>
                            <td><input type="text" class="form-control" id="Teacher" readonly="readonly"></td>
                            <td><input type="text" class="form-control" id="LessonTime" readonly="readonly"></td>
                            <td><input type="text" class="form-control" id="LessonClass" readonly="readonly"></td>
                            <td><input type="text" class="form-control" id="LessonRoom" readonly="readonly"></td>
                            <td><input type="text" class="form-control" id="ListenTime" readonly="readonly"></td>
                        </tr>
                    </table>

                    <br><br>

                    <div class="tab-pane fade in active" id="back">

                    </div>
                </div>
            </div>
            <div id="content-footer" class="modal-footer">
                <button type="button" class="btn btn-default btn-raised"
                        data-dismiss="modal">关闭
                </button>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<script>
    var userId='{{Auth::User()->user_id}}';
    var userName='{{Auth::User()->name}}';
</script>
<script src="{{asset('js/HelpFunction.js')}}"></script>
<script src="{{asset('js/TeachEvaluation/index.js')}}"></script>
</body>
</html>