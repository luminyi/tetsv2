<!DOCTYPE html>
<meta name="render" content="webkit|ie-comp|ie-stand">
<meta http-equiv="X-UA-Compatible" content="IE=11">
<html lang="en">
<style type="text/css">
    *{font-family:"Microsoft YaHei"}
    .nav_a{
        cursor: pointer;
    }
    .btn-addClass{
        color:#fff;
        background-color:#B6D9B1;
        border-color:#B6D9B1;
    }
    .btn:hover,.btn:focus{
        color: #fff !important;
    }
</style>
<head>

    <meta charset="utf-8" />
    <title>北林教学评价系统</title>
    <meta name="keywords" content="北林教学评价系统" />
    <meta name="description" content="北林教学评价系统" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <!-- basic styles -->
    <link href="assets/css/bootstrap.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="assets/css/font-awesome.min.css" />
    <link rel="stylesheet" href="assets/css/dashboard.css" />
    <link rel="stylesheet" href="assets/css/common.css" />
    <link rel="stylesheet" href="css/style1.css" />
    <link rel="stylesheet" href="assets/css/bootstrap-material-btndesign.css" />
    <!--[if IE 7]>
    <link rel="stylesheet" href="assets/css/font-awesome-ie7.min.css" />
    <![endif]-->

    <!--[if lt IE 9]>
    <script src="assets/js/html5shiv.js"></script>
    <script src="assets/js/respond.min.js"></script>
    <![endif]-->
</head>
{{--日历相关--}}
<link rel="stylesheet" type="text/css" href="calendar/DateTimePicker.css" />
<script type="text/javascript" src="calendar/jquery-1.11.0.min.js"></script>

<!--[if lt IE 9]>
<link rel="stylesheet" type="text/css" href="calendar1/DateTimePicker-ltie9.css" />
<script type="text/javascript" src="calendar1/DateTimePicker-ltie9.js"></script>
<![endif]-->
<script src="assets/js/jquery-2.0.3.min.js"></script>
<script src="assets/js/bootstrap.min.js"></script>
@include('layout.header')
@include('layout.sidebar')
<body>
<link rel="stylesheet" href="{{asset('css/LessonTable.css')}}">

    <div class="container-fluid clearfix">
        <div class="row clearfix">
                    <!-- 面板开始 -->
            <input id="getlevel" value="{{session('role')}}" style="display: none"/>
            <div class="col-sm-10 col-sm-offset-2 col-md-10 col-md-offset-2" style="margin-top: 30px">
                <!-- .breadcrumb -->
                <!-- .breadcrumb -->
                <!-- .page-content 开始 -->

                {{--教师课表--}}
                <div class="Teacher-Table" >
                    {{--学期选择框--}}
                    {{--教师选择框--}}
                        <div id="selection"style="width:300px; display: inline-block;">
                            <div class="search2">
                                {{--<form method="get" id="search3">--}}
                                {{--<form method="get" id="search3">--}}
                                <input class="input1" name="q1" type="text" size="40" placeholder="Search..." onkeyup=""/>
                                    {{--<span class="translate">EN</span>--}}
                                {{--</form>--}}
                                <div class="box_classify clearfix">
                                    <div class="box_up clearfix">
                                        <div class="water active1">林学院</div>
                                        <div class="water">水保学院</div>
                                        <div class="water">生物学院</div>
                                        <div class="water">园林学院</div>
                                        <div class="water">经管学院</div>
                                        <div class="water">工学院</div>
                                        <div class="water">理学院</div>
                                        <div class="water">信息学院</div>
                                        <div class="water">人文学院</div>
                                        <div class="water">外语学院</div>
                                        <div class="water">材料学院</div>
                                        <div class="water">保护区学院</div>
                                        <div class="water">环境学院</div>
                                        <div class="water">艺设学院</div>
                                        <div class="water">体育教学部</div>

                                    </div>

                                    <div class="box_down clearfix">
                                    </div>
                                </div>
                                <div class="box_match clearfix">
                                </div>

                            </div>
                        </div>
                        <div style="display: inline-block; margin-bottom:20px;vertical-align:middle;" class="semester">学年学期
                            <input id="calender" class="select_year" type="text" data-field="date" readonly></div>
                        <div id="dtBox" class="dtpicker-overlay dtpicker-mobile" style="display: none;">
                            <div class="dtpicker-bg">
                                <div class="dtpicker-cont">
                                    <div class="dtpicker-content">
                                        <div class="dtpicker-subcontent">

                                            <div class="dtpicker-header">
                                                <div class="dtpicker-title">选择学期</div>
                                                <a class="dtpicker-close">×</a>
                                                <!--<div class="dtpicker-value"></div>-->
                                            </div>

                                            <div class="dtpicker-components">
                                                <div class="dtpicker-compOutline dtpicker-comp3">
                                                    <div class="dtpicker-comp year1_class">
                                                        <a id="year1_class1" class="dtpicker-compButton increment">+</a>
                                                        <input id="year1" type="text" class="dtpicker-compValue" maxlength="4">
                                                        <a id="year1_class2" class="dtpicker-compButton decrement">-</a>
                                                    </div>
                                                </div>

                                                <div class="dtpicker-compOutline dtpicker-comp3">
                                                    <div class="dtpicker-comp ">
                                                        <a class="dtpicker-compButton increment "></a>
                                                        <input type="text" class="dtpicker-compValue" id="year2" disabled="disabled">
                                                        <a class="dtpicker-compButton decrement "></a>
                                                    </div>
                                                </div>

                                                <div class="dtpicker-compOutline dtpicker-comp3">
                                                    <div class="dtpicker-comp ">
                                                        <a class="dtpicker-compButton increment dtpicker-compButtonEnable">+</a>
                                                        <input type="text" class="dtpicker-compValue" id="terminal" disabled="disabled">
                                                        <a class="dtpicker-compButton decrement dtpicker-compButtonEnable">-</a>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="dtpicker-buttonCont dtpicker-twoButtons">
                                                <a class="dtpicker-button dtpicker-buttonSet">确定</a>
                                                <a class="dtpicker-button dtpicker-buttonClear">取消</a>
                                            </div>

                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <button id="View_Btn" type="button" class="btn btn-primary  btn-round btn-raised" style="margin-top:-20px;margin-left: 20px;">
                        <i class="icon-search"></i>查询</button>
                    @if(Auth::User()->level=='校级')
                        {{--<button id="ImportData_Btn" type="button" class="btn btn-success  btn-raised"--}}
                                {{--data-toggle="modal" data-target="#myModal" style="float: right;margin-top:-3px;">--}}
                            {{--<i class="glyphicon glyphicon-import"></i>导入教师课表</button>--}}

                    @endif

                    <button id="select" class="btn btn-primary btn-lg" data-toggle="modal"
                            data-target="#LessonAttr" style="display: none">
                    </button>
                    {{--表格部分--}}
                    <div class="panel panel-primary">
                        <div class="panel-heading">
                            <h2 class="panel-title" style="font-family:'Microsoft YaHei'"><span class="type_tit2">

                        </span>教师课表</h2>
                        </div>
                        <div class="panel-body panel1">
                            <!-- <span class="pull-right">
                                <a class="export"><i class="icon-file"></i> 导出</a>
                            </span> -->
                            <table class="table table-bordered">
                                <thead>
                                <tr class="active">
                                    <th>上课时间</th>
                                    <th>星期一</th>
                                    <th>星期二</th>
                                    <th>星期三</th>
                                    <th>星期四</th>
                                    <th>星期五</th>
                                    <th>星期六</th>
                                    <th>星期日</th>
                                </tr>
                                </thead>
                                <tbody>
                                <tr class="info1">
                                    <th><i>上午1-2</i></th>
                                    <th></th>
                                    <th></th>
                                    <th></th>
                                    <th></th>
                                    <th></th>
                                    <th></th>
                                    <th></th>
                                </tr>
                                <tr class="info2">
                                    <th><i>上午3-4</i></th>
                                    <th></th>
                                    <th></th>
                                    <th></th>
                                    <th></th>
                                    <th></th>
                                    <th></th>
                                    <th></th>
                                </tr>
                                <tr class="info3">
                                    <th><i>下午1-2</i></th>
                                    <th></th>
                                    <th></th>
                                    <th></th>
                                    <th></th>
                                    <th></th>
                                    <th></th>
                                    <th></th>
                                </tr>
                                <tr class="info4">
                                    <th><i>下午3-4</i></th>
                                    <th></th>
                                    <th></th>
                                    <th></th>
                                    <th></th>
                                    <th></th>
                                    <th></th>
                                    <th></th>
                                </tr>
                                <tr class="info5">
                                    <th><i>晚上1-2</i></th>
                                    <th></th>
                                    <th></th>
                                    <th></th>
                                    <th></th>
                                    <th></th>
                                    <th></th>
                                    <th></th>
                                </tr>
                                </tbody>
                            </table>
                        </div>


                        {{--模态框，用作选择导入指标列表--}}
                        <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                        <h4 class="modal-title" id="myModalLabel">请选择导入的院系</h4>
                                    </div>
                                    <div class="modal-body" id="modal_body">
                                        <button type="button" class="btn btn-primary" id="shuibao">水土保持学院</button>
                                        <button type="button" class="btn btn-secondary" id="shengwu">生物科学与技术学院</button>
                                        <button type="button" class="btn btn-success" id="jingguan">经济管理学院</button>
                                        <button type="button" class="btn btn-info" id="gong">工学院</button>
                                        <button type="button" class="btn btn-warning" id="li">理学院</button>
                                        <button type="button" class="btn btn-danger" id="xinxi">信息学院</button>
                                        <button type="button" class="btn btn-link" id="renwen">人文社会科学学院</button>
                                        <button type="button" class="btn btn-primary" id="waiyu">外语学院</button>
                                        <button type="button" class="btn btn-secondary" id="cailiao">材料科学与技术学院</button>
                                        <button type="button" class="btn btn-success" id="baohuqu">自然保护区学院</button>
                                        <button type="button" class="btn btn-info" id="huanjing">环境科学与工程学院</button>
                                        <button type="button" class="btn btn-warning" id="yishe">艺术设计学院</button>
                                        <button type="button" class="btn btn-danger" id="yuanlin">园林学院</button>
                                        <button type="button" class="btn btn-danger" id="lin">林学院</button>
                                        <button type="button" class="btn btn-link" id="tiyu">体育教学部</button>

                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-default" data-dismiss="modal">关闭</button>
                                        <button type="button" class="btn btn-primary" id="File_Submit">确定</button>
                                        {{--上传文件的选择框--}}
                                        <form id="myform" action="" method="post" enctype="multipart/form-data" style="display:none">
                                            <input accept=".xls,.xlsx,.csv" type="file"  id="SelectFile" name="importLesson" />
                                            <input type="hidden" name="_token" value="{!! csrf_token() !!}"/>
                                        </form>
                                    </div>
                                </div><!-- /.modal-content -->
                            </div><!-- /.modal -->
                        </div>

                        <!-- 模态框，用作选择课程属性（Modal） -->
                        <div class="modal fade" id="LessonAttr" tabindex="-1" role="dialog"
                             aria-labelledby="myModalLabel" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <button type="button" class="close"
                                                data-dismiss="modal" aria-hidden="true">
                                            &times;
                                        </button>
                                        <h4 class="modal-title" id="myModalLabel">
                                            请选择课程属性
                                        </h4>
                                    </div>
                                    <div class="modal-body">
                                        <select class="add_task" name="tableattr" type="text" id="tableattr" style="display: inline-block!important;margin:11px 0px 14px 22px!important;">
                                            <option value="1">理论课评价表</option>
                                            <option value="2">实践课评价表</option>
                                            <option value="3">体育课评价表</option>
                                        </select>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-default"
                                                data-dismiss="modal">关闭
                                        </button>
                                        <button id="sure" type="button" class="btn btn-primary">
                                            进行评价
                                        </button>
                                    </div>
                                </div><!-- /.modal-content -->
                            </div><!-- /.modal -->
                        </div>
                    </div>

                </div>
                <!-- .page-content 结束 -->
            </div>
            <!-- 面板结束 -->
        </div>
    </div>

    @include('layout.footer')
    </body>
    <script src="{{asset('js/LessonTable.js')}}"></script>
    <script>

    </script>
@if(Cookie::get('mess')!=null)
    <script>
        alert("{{ Cookie::get('mess') }}");
    </script>
    {{ Cookie::queue('mess', null , -1) }}
@endif
</html>
