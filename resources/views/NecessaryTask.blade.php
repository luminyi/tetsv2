<!DOCTYPE html>
<meta name="render" content="webkit|ie-comp|ie-stand">
<meta http-equiv="X-UA-Compatible" content="IE=11">

<html lang="en">
<link  rel="stylesheet" href="css/NecessaryTask.css" />

<head>
    <meta charset="utf-8" />
    <title>北林教学评价系统</title>
    <meta name="keywords" content="北林教学评价系统" />
    <meta name="description" content="北林教学评价系统" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <!-- basic styles -->
    <link href="assets/css/bootstrap.min.css" rel="stylesheet" />
    <link href="assets/css/bootstrap-table.css" rel="stylesheet" />
    <link rel="stylesheet" href="assets/css/font-awesome.min.css" />
    <link rel="stylesheet" href="assets/css/dashboard.css" />
    <link rel="stylesheet" href="assets/css/common.css" />
    <link rel="stylesheet" href="css/button.css" />
    <link rel="stylesheet" href="assets/css/bootstrap-material-btndesign.css" />
    <!--[if IE 7]>
    <link rel="stylesheet" href="assets/css/font-awesome-ie7.min.css" />
    <![endif]-->

    <!--[if lt IE 9]>
    <script src="assets/js/html5shiv.js"></script>
    <script src="assets/js/respond.min.js"></script>
    <![endif]-->



{{--日历相关--}}
<link rel="stylesheet" type="text/css" href="calendar/DateTimePicker.css" />
<script type="text/javascript" src="calendar/jquery-1.11.0.min.js"></script>

<!--[if lt IE 9]>
<link rel="stylesheet" type="text/css" href="calendar1/DateTimePicker-ltie9.css" />
<script type="text/javascript" src="calendar1/DateTimePicker-ltie9.js"></script>
<![endif]-->
</head>
<script src="assets/js/jquery-1.10.2.min.js"></script>

@include('layout.header')
@include('layout.sidebar')
<body>



<div class="container-fluid clearfix">
    <div class="row clearfix">
                <!-- 面板开始 -->
        <input id="getlevel" value="{{session('role')}}" style="display: none"/>
        <input id="getgroup" value="{{Auth::User()->group}}" style="display: none"/>
        <input id="getunit" value="{{Auth::User()->unit}}" style="display: none"/>

        <div class="col-sm-10 col-sm-offset-2 col-md-10 col-md-offset-2">
            <!-- .breadcrumb -->
                <div class="breadcrumbs" id="breadcrumbs">
                    <ul class="breadcrumb" style="padding-top: 22px; padding-bottom: 12px;">

                    </ul>
                </div>
                        <!-- .breadcrumb -->
            <!-- .page-content 开始 -->
            <div class="page-content col-lg-12 col-md-12" >
                {{--日历部分--}}
                <div class="Teacher-Table">
                    <p>
                        学年学期
                        <input id="calender" class="select-year" type="text" data-field="date" readonly>
                        <button id="btn_search" type="button" class="btn btn-primary btn-raised">
                            <span class="icon-search" aria-hidden="true"></span>查询
                        </button>
                    </p>
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
                </div>



                {{--增加课程模态框--}}
                <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" data-backdrop="static">
                    <div class="modal-dialog " role="document" >
                        <div class="modal-content" >
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span></button>
                                <h4 class="modal-title" id="myModalLabel">新增学期必听课程</h4>

                            </div>
                            <div class="modal-body">
                                <div class="search" >
                                    <form target="_blank" id="search-form">
                                        <input id="SearchBar" type="text" class="form-control" value="" autocomplete="off" placeholder="输入课程名或教师名"
                                               style="display: inline-block;width: 200px;">
                                        {{--选择指定组--}}
                                        <select class="form-control" name="reason" id="reason" style="width:150px ;float: right">
                                            <option>新进教师</option>
                                            <option>评价分数较低教师</option>
                                        </select>
                                        <select class="form-control" name="group" id="group" style="margin-right:15px;width:150px ;float: right">
                                            <option>第一组</option>
                                            <option>第二组</option>
                                            <option>第三组</option>
                                            <option>第四组</option>
                                        </select>

                                    </form>
                                </div>
                                {{--搜索框下拉列表--}}
                                <div class="suggest" id="search-suggest" >
                                    <ul id="search_result">

                                    </ul>
                                </div>


                            </div>
                            <div class="modal-footer">
                                <button id="dui" type="button" class="btn btn-primary btn-raised" data-dismiss="modal">确定</button>
                                <button id="cuo" type="button" class="btn btn-default btn-raised" data-dismiss="modal">取消</button>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="panel panel-success" style="margin-top:30px;">
                    <div class="panel-heading">
                        <h2 class="panel-title" style="font-family:'Microsoft YaHei'">
                                <span class="type_tit2 h3">
                                </span>
                        </h2>
                        {{--表格功能键--}}
                        <div class="bs-bars pull-left" style="padding-top:22px;">
                            <div id="toolbar" class="btn-group">
                                @if(session('role')=='校级')
                                    <button id="add" data-toggle="modal" data-target="#myModal" class="btn btn-primary btn-raised"><i class="glyphicon glyphicon-plus"></i>增加</button>
                                    <button id="btn_delete" class="btn btn-warning btn-raised"><i class="icon-trash"></i>删除</button>
                                    <button id="btn_import" class="btn btn-success btn-raised" data-toggle="modal" data-target="#NeceLessonModal"><i class="glyphicon  glyphicon glyphicon-import"></i>导入</button>
                                @endif
                                <button id="btn_export" class="btn btn-danger btn-raised"><i class="glyphicon glyphicon-export"></i>导出</button>
                                {{--<a id="btn_export" class="button button-3d button-pill"><i class="glyphicon glyphicon-download-alt"></i>导出</a>--}}

                            </div>
                        </div>
                    </div>
                    <div class="panel-body">

                {{--table部分--}}
                <table id="table"
                       {{--data-toggle="table"--}}
                       data-click-to-select="true"
                       {{--data-url="data/NecessaryTask.json"--}}
                       data-show-pagination-switch="true"
                       data-query-params="queryParams"
                       data-pagination="true"
                       data-search = "true"
                       data-page-size="20"
                       >
                    <thead>
                        <tr>
                            @if(session('role')=='校级')
                            <th data-field="state" data-checkbox="true"></th>
                            @endif
                            <th data-field="lesson_name" data-halign="center" data-align="center">课程名称</th>
                            {{--<th data-field="lesson_attribute" data-halign="center" data-align="center">课程属性</th>--}}
                            <th data-field="lesson_teacher_name" data-halign="center" data-align="center">授课教师</th>
                            <th data-field="lesson_teacher_unit" data-halign="center" data-align="center">所属院系</th>
                            <th data-field="assign_group" data-halign="center" data-align="center">所属组别</th>
                            <th data-field="lesson_week" data-halign="center" data-align="center">上课周次</th>
                            <th data-field="lesson_weekday" data-halign="center" data-align="center">上课星期</th>
                            <th data-field="lesson_time" data-halign="center" data-align="center">上课时间</th>
                            <th data-field="lesson_room" data-halign="center" data-align="center">上课地点</th>
                            <th data-field="lesson_class" data-halign="center" data-align="center">上课班级</th>
                            <th data-field="lesson_attention_reason" data-halign="center" data-align="center">关注原因</th>
                        </tr>
                    </thead>
                </table>
                    </div>
                </div>




                <!-- 导入必听课程的模态框（Modal） -->
                <div class="modal fade" id="NeceLessonModal" tabindex="-1" role="dialog"
                     aria-labelledby="myModalLabel" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="close"
                                        data-dismiss="modal" aria-hidden="true">
                                    &times;
                                </button>
                                <h4 class="modal-title" id="myModalLabel">
                                    导入必听课程
                                </h4>
                            </div>
                            <div class="modal-body">
                                <form id="myform" action="" method="post" enctype="multipart/form-data">
                                    <input accept=".xls,.xlsx,.csv" type="file"  id="SelectFile" name="NecessaryTaskImport" />
                                    <input type="hidden" name="_token" value="{!! csrf_token() !!}"/>
                                </form>
                            </div>
                            <div class="modal-footer">
                                <button id="sure" type="button" class="btn btn-primary btn-raised">
                                    提交
                                </button>
                                <button type="button" class="btn btn-default btn-raised"
                                        data-dismiss="modal">关闭
                                </button>

                            </div>
                        </div><!-- /.modal-content -->
                    </div><!-- /.modal -->
                </div>

            </div>
            <!-- .page-content 结束 -->
        </div>
        <!-- 面板结束 -->
    </div>
</div>
@include('layout.footer')
@if(Cookie::get('mess')!=null)
    <script>
        alert("{{ Cookie::get('mess') }}");
    </script>
    {{ Cookie::queue('mess', null , -1) }}
@endif
</body>

<script src="assets/js/bootstrap.min.js"></script>
<script src="assets/js/bootstrap-table.js"></script>
<script src="assets/js/bootstrap-table-zh-CN.js"></script>
<script>
    function queryParams() {
        return {
            per_page: 100,
            page: 1
        };
    }
    var csrf_token='{{csrf_token()}}';
</script>
<script src="{{asset('js/NecessaryTask.js')}}"></script>



</html>
