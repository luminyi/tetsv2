<!DOCTYPE html>
<meta name="render" content="webkit|ie-comp|ie-stand">
<meta http-equiv="X-UA-Compatible" content="IE=11">
<html lang="en">
<style>
    *{font-family:"Microsoft YaHei"}
</style>
<link rel="stylesheet" href="css/Evaluation.css" />

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
    <link rel="stylesheet" href="assets/css/bootstrap-material-btndesign.css" />
    <!--[if IE 7]>
    <link rel="stylesheet" href="assets/css/font-awesome-ie7.min.css" />
    <![endif]-->

    <!--[if lt IE 9]>
    <script src="assets/js/html5shiv.js"></script>
    <script src="assets/js/respond.min.js"></script>
    <![endif]-->
    <script src="assets/js/jquery-2.0.3.min.js"></script>

</head>
@include('layout.header')
@include('layout.sidebar')
<body>
<div class="container-fluid clearfix">
    <div class="row clearfix">
        {{--@include('layout.sidebar')--}}
                <!-- 面板开始 -->
        <div class="col-sm-10 col-sm-offset-2 col-md-10 col-md-offset-2">

            {{--<!-- .breadcrumb -->--}}
            <div class="breadcrumbs" id="breadcrumbs">
                <ul class="breadcrumb" style="padding-top: 22px; padding-bottom: 12px;">
                    {{--<li>--}}
                        {{--<i class="icon-home home-icon"></i>--}}
                        {{--<a style="color: #225081;" href="#">评价管理</a>--}}
                    {{--</li>--}}
                    {{--<li style="color:gray">关注课程完成情况</li>--}}
                </ul>
            </div>
            <!-- .breadcrumb -->
            <!-- .page-content 开始 -->

            <input id="getlevel" value="{{session('role')}}" style="display: none"/>
            <input id="getunit" value="{{Auth::User()->unit}}" style="display: none"/>
            <input id="getgroup" value="{{Auth::User()->group}}" style="display: none"/>

            <div class="page-content">
                <div class="col-md-6 col-md-offset-4">
                    <h3 style="font-family: Microsoft YaHei;" class="current-year"></h3>
                </div>

                <div id="main" class="col-lg-5 col-md-5 col-sm-5 col-sx-12" style="height:800px;float: left"></div>
                {{--已听课程--}}

                <div class="col-lg-7 col-md-7 col-sm-7 col-sx-12">
                    <div class="panel panel-success" style="margin-top:50px;margin-right: 20px;">
                        <div class="panel-heading">
                            <h4 class="panel-title DoTitle">关注课程已完成统计表</h4>
                        </div>
                        <div class="panel-body">
                            <div>
                                <div id="Do">
                                    <table id="finished"
                                           data-toggle="table"
                                           data-classes="table table-hover table-bordered"
                                           data-click-to-select="true"
                                           data-search = "true"
                                           data-show-pagination-switch="true"
                                           data-pagination="true"
                                           data-page-list="[5, 10, 20, 50, 100, 200]" >
                                        <thead>
                                        <tr class="success">
                                            <th data-field="课程名称" data-halign="center" data-align="center">课程名称</th>
                                            {{--@if(Auth::User()->level=='院级')--}}
                                                {{--<th data-field="" data-halign="center" data-align="center">听课督导</th>--}}
                                            {{--@else--}}
                                                {{--<th data-field="督导id" data-halign="center" data-align="center">督导id</th>--}}
                                                <th data-field="督导姓名" data-halign="center" data-align="center">听课督导</th>
                                                <th data-field="assign_group" data-halign="center" data-align="center">关注课程所在组</th>
                                            {{--@endif--}}
                                            <th data-field="任课教师" data-halign="center" data-align="center">任课教师</th>
                                            {{--<th data-field="课程属性" data-halign="center" data-align="center">课程属性</th>--}}
                                            <th data-field="上课班级" data-halign="center" data-align="center">上课班级</th>
                                            <th data-field="听课时间" data-halign="center" data-align="center">听课时间</th>
                                            <th data-field="听课节次" data-halign="center" data-align="center">听课节次</th>
                                            <th data-field="授课总体评价" data-halign="center" data-align="center">授课总体评价</th>

                                            <th data-field="填表时间" data-halign="center" data-align="center">填表时间</th>
                                            <th data-field="action" data-formatter="actionFormatter" data-events="actionEvents">评价详情</th>
                                        </tr>
                                        </thead>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                {{--保存课程--}}

                <div class="col-lg-7 col-md-7 col-sm-7 col-sx-12">
                    <div class="panel panel-info" style="margin-top:50px;margin-right: 20px; display: none">
                        <div class="panel-heading">
                            <h4 class="panel-title SaveTitle">关注课程待提交统计表</h4>
                        </div>
                        <div class="panel-body">
                            <div>
                                <div id="Save"  style="display: none">
                                    <table id="saved"
                                           data-toggle="table"
                                           data-classes="table table-hover table-bordered"
                                           data-click-to-select="true"
                                           data-search = "true"
                                           data-show-pagination-switch="true"
                                           data-pagination="true"
                                           data-page-list="[5, 10, 20, 50, 100, 200]" >
                                        <thead>
                                        <tr class="success">
                                            <th data-field="课程名称" data-halign="center" data-align="center">课程名称</th>
                                            {{--@if(Auth::User()->level=='院级')--}}
                                                {{--<th data-field="" data-halign="center" data-align="center">听课督导</th>--}}
                                            {{--@else--}}
                                                {{--<th data-field="督导id" data-halign="center" data-align="center">督导id</th>--}}
                                                <th data-field="督导姓名" data-halign="center" data-align="center">听课督导</th>
                                                <th data-field="assign_group" data-halign="center" data-align="center">关注课程所在组</th>
                                            {{--@endif--}}
                                            <th data-field="任课教师" data-halign="center" data-align="center">任课教师</th>
                                            {{--<th data-field="课程属性" data-halign="center" data-align="center">课程属性</th>--}}
                                            <th data-field="上课班级" data-halign="center" data-align="center">上课班级</th>
                                            <th data-field="听课时间" data-halign="center" data-align="center">听课时间</th>
                                            <th data-field="填表时间" data-halign="center" data-align="center">填表时间</th>
                                            <th data-field="听课节次" data-halign="center" data-align="center">听课节次</th>

                                            <th data-field="action" data-formatter="actionFormatter" data-events="actionEvents">评价详情</th>
                                        </tr>
                                        </thead>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                {{--评价详情模态框--}}
                <button id="view" class="btn btn-primary" data-toggle="modal" data-target="#myModal" style="display: none">
                    开始演示模态框
                </button>
                <!-- 模态框（Modal） -->
                <div class="modal fade bs-example-modal-lg" id="myModal" tabindex="-1" role="dialog"
                     aria-labelledby="myModalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-lg">
                        <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal"
                                        aria-hidden="true">×
                                </button>
                                <h4 class="modal-title" id="myModalLabel">
                                    评价表详情
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
                                            <span for="LessonSupervisor" class="col-lg-1" style="padding-top: 8px;" >听课督导</span>
                                            <div class="col-sm-2">
                                                <input type="text" class="form-control" id="LessonSupervisor" readonly="readonly">
                                            </div>
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
                                            <th>上课班级</th>
                                            <th>上课地点</th>
                                            <th>听课时间</th>
                                        </tr>
                                        <tr>
                                            <td><input type="text" class="form-control" id="LessonName" readonly="readonly"></td>
                                            <td><input type="text" class="form-control" id="Teacher" readonly="readonly"></td>
                                            <td><input type="text" class="form-control" id="LessonClass" readonly="readonly"></td>
                                            <td><input type="text" class="form-control" id="LessonRoom" readonly="readonly"></td>
                                            <td><input type="text" class="form-control" id="ListenTime" readonly="readonly"></td>
                                        </tr>
                                    </table>
                                    <div>
                                        <span class="icon-exclamation-sign" style="color: #f35454;"></span>
                                        <strong>  &nbsp;&nbsp;&nbsp;&nbsp; 注：</strong>
                                        &nbsp;&nbsp;&nbsp;（1）5个评价等级为：非常满意、满意、正常、存在不足、存在明显不足。<br>
                                        （2）评价内容共两部分：评价表正面和评价表背面。<br>
                                        （3）评价表正面除“章节目录、课程属性、学生到课情况、其他”外均为必填项，背面为选填项。<br>
                                    </div>
                                    <br><br>
                                    <ul id="myTab" class="nav nav-tabs">
                                        <li class="active"><a href="#front" data-toggle="tab">评价表正面</a></li>
                                        <li><a href="#back" data-toggle="tab" >评价表背面</a></li>
                                    </ul>
                                    <div id="myTabContent" class="tab-content content-font">
                                        <div class="tab-pane fade in active" id="front" style="">


                                        </div>
                                        <div class="tab-pane fade content-back" id="back">


                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-default btn-raised"
                                        data-dismiss="modal">关闭
                                </button>
                                {{--<button type="button" class="btn btn-primary">--}}
                                {{--提交更改--}}
                                {{--</button>--}}
                            </div>
                        </div><!-- /.modal-content -->
                    </div><!-- /.modal-dialog -->
                </div><!-- /.modal -->


                {{--未听课程--}}
                <div class="col-lg-7 col-md-7 col-sm-7 col-sx-12">
                    <div class="panel panel-danger" style="margin-top:50px;margin-right: 20px;display: none;">
                        <div class="panel-heading">
                            <h4 class="panel-title UndoTitle" style="display: none;">关注课程未完成统计表</h4>
                        </div>
                        <div class="panel-body">
                            <div>
                                <div id="Undo" style="display:none;">
                                    <table id="unfinished"
                                           data-toggle="table"
                                           data-classes="table table-hover table-bordered"
                                           data-click-to-select="true"
                                           data-show-pagination-switch="true"
                                           data-search = "true"
                                           data-pagination="true"
                                           data-page-list="[5, 10, 20, 50, 100, 200]" >
                                        <thead>
                                        <tr class="warning">
                                            <th data-field="lesson_name" data-halign="center" data-align="center" class="className">课程名称</th>
                                            {{--@if(Auth::User()->level!='院级')--}}
                                                <th data-field="assign_group" data-halign="center" data-align="center">关注课程所在组</th>
                                            {{--@endif--}}
                                            <th data-field="lesson_teacher_name" data-halign="center" data-align="center">任课教师</th>
                                            <th data-field="lesson_class" data-halign="center" data-align="center" class="classNum">上课班级</th>
                                            <th data-field="lesson_teacher_unit" data-halign="center" data-align="center">所属院系</th>
                                            <th data-field="lesson_week" data-halign="center" data-align="center">上课周次</th>
                                            <th data-field="lesson_time" data-halign="center" data-align="center">上课时间</th>
                                            <th data-field="lesson_room" data-halign="center" data-align="center">上课地点</th>
                                        </tr>
                                        </thead>
                                    </table>
                                </div>
                            </div>
                        </div>
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
<script src="assets/js/jquery-2.0.3.min.js"></script>
<script src="assets/js/bootstrap.min.js"></script>
<script src="assets/js/echarts.min.js"></script>
<script src="assets/js/vintage.js"></script>
<script src="assets/js/bootstrap-table.js"></script>
<script src="assets/js/bootstrap-table-zh-CN.js"></script>
<script>

</script>
<script src="{{asset('js/Evaluated.js')}}"></script>
<script>
    function actionFormatter(value, row, index) {
        return [
            '<a class="like seeDetail" href="javascript:void(0)" title="Like">详细信息</a>'
        ].join('');
    }

    var tablename = null;
    var headnum = 12;//评价表头部的数量
    window.actionEvents = {
        'click .like': function (e, value, row, index) {
            //alert('You click like icon, row: ' + JSON.stringify(row));
            $("#view").click();

            var LessonName=row.课程名称.replace(/(^\s+)|(\s+$)/g,"");
            var LessonTeacher=row.任课教师.replace(/(^\s+)|(\s+$)/g,"");
            var LessonSupervisor=row.督导id.replace(/(^\s+)|(\s+$)/g,"");
            var LessonValueTime=row.听课时间.replace(/(^\s+)|(\s+$)/g,"");
            var lessontime=row.听课节次.replace(/(^\s+)|(\s+$)/g,"");

            $('#front').empty();
            $('#back').empty();

            //获取表项内容太麻烦了，直接取该课程对应的评价表在数据库中的字段
            //已听课程 正面、背面 评价详情

            $.ajax({
                type: "get",
                async: false,
                url: "/EvaluationContent",
                data: {
                    year1:year1,
                    year2:year2,
                    semester:semester,
                    Lesson_name:LessonName,
                    Teacher:LessonTeacher,
                    Spuervisor:LessonSupervisor,
                    Lesson_date:LessonValueTime,
                    Lessontime: lessontime
                },//传递学院名称
                success: function (result) {
                    var chapterVal=result[1][0].章节目录;
                    var LessonNameVal=result[1][0].课程名称;
                    var TeacherVal=result[1][0].任课教师;
                    var LessonClassVal=result[1][0].上课班级;
                    var LessonRoomVal=result[1][0].上课地点;
                    var ListenTimeVal=result[1][0].听课时间;
                    var ListenAttrVal=result[1][0].课程属性;
                    var ListenSupervisorVal=result[1][0].督导姓名;

                    $('#inputChapter').val(chapterVal);
                    $('#LessonName').val(LessonNameVal);
                    $('#Teacher').val(TeacherVal);
                    $('#LessonClass').val(LessonClassVal);
                    $('#LessonRoom').val(LessonRoomVal);
                    $('#ListenTime').val(ListenTimeVal);
//                    $('#LessonSupervisor').val(ListenSupervisorVal);
                    $('#LessonAttr').val(ListenAttrVal);
                    if($('#getlevel').val()=='院级')
                        $('#LessonSupervisor').val('XXX');
                    else{
                        $('#LessonSupervisor').val(ListenSupervisorVal);
                    }

                    var FrontOne =[];
                    var FrontTwo =[];
                    var FrontThree =[];

                    for (i=headnum;i<result[3].length;i++)
                    {
                        a='COLUMN_NAME';
                        $('#front').append('<div class="line-1">'+'<div class="lineName">'+'<span class="icon-folder-open-alt">'+'</span>'+result[3][i][a]+'</div>'+
                                '<div class="lineData">'+
                                '<ul>'+
                                '<li class="current">'+
                                result[1][0][result[3][i][a]]+
                                '</li>'+
                                '</ul>'+
                                '</div>'+'</div>');
                        // $('#front').append('<div class="line-1">'+'<div class="lineName">'+'<span class="icon-folder-open-alt">'+'</span>'+result[3][i][a]+'</div>'+'<div class="linePoint">'+'------------------------'
                        //     +'</div>'+'<div class="lineData">'+
                        //     '<ul>'+
                        //     '<li class="current">'+
                        //     result[1][0][result[3][i][a]]+
                        //     '</li>'+
                        //     '</ul>'+
                        //     '</div>'+'</div>');
                        if ( result[1][0][result[3][i][a]]==null )
                        {
                            if(result[1][0][result[3][i+1][a]] == null )
                                FrontOne.push(result[3][i][a]);
                            else
                                FrontTwo.push(result[3][i][a]);
                        }
                        else{
                            FrontThree.push(result[3][i][a]);
                        }
                    }

                    $('.line-1').each(function () {
                        for(var i=0;i<FrontOne.length;i++)
                        {
                            if ($(this).text().indexOf(FrontOne[i])>=0)
                            {
                                $(this).addClass('front1');
                                $(this).find('.lineData').css('display','none');
                            }
                        }
                        $('.front1').css('font-size','200px');
                        for(var i=0;i<FrontTwo.length;i++)
                        {
                            if ($(this).text().indexOf(FrontTwo[i])>=0)
                            {
                                $(this).addClass('front2');
                                $(this).find('.lineData').css('display','none');
                                $(this).find('.icon-folder-open-alt').css('display','none');
                            }
                        }
                        for(var i=0;i<FrontThree.length-1;i++)
                        {
                            if ($(this).text().indexOf(FrontThree[i])>=0)
                            {
                                $(this).addClass('front3');
                                $(this).find('.lineData').css('display','inline-block');
                                $(this).find('.lineName').css('display','inline-block');
                                $(this).find('.icon-folder-open-alt').css('display','none');
                                $(this).find('.current').css('width','100px');
                            }
                        }
                    });




                    // console.log(FrontOne);
                    // console.log(FrontTwo);
                    //console.log(FrontThree);


                    var BackOne =[];
                    var BackTwo =[];
                    var BackThree =[];
                    for (i=headnum;i<result[4].length;i++)
                    {
                        a='COLUMN_NAME';
                        $('#back').append('<div class="question">'+'<div class="icon-check">'+'</div>'+'<span>'+result[4][i][a]+'</span>'+
                                '<div class="questionData">'+result[2][0][result[4][i][a]]+'</div>'+'</div>');
                        //$('#back').append(result[4][i][a]+'<br>');
                        if ( result[4][i][a].match(/\？/) != null )
                        {
                            BackOne.push(result[4][i][a]);
                        }
                        else if(result[4][i][a].match(/\。/) != null){
                            BackTwo.push(result[4][i][a]);
                        }
                        else{
                            BackThree.push(result[4][i][a]);
                        }

                    }
                    $('.question').each(function () {
                        for(var i=0;i<BackOne.length;i++)
                        {
                            if ($(this).text().indexOf(BackOne[i])>=0)
                            {
                                $(this).addClass('back1');
                                $(this).append( '<i class="icon-chevron-right" style="float: left;margin-right: 6px;color: #CCCCCC;">'+
                                        '</i>');
                                $(this).find('.questionData').css('display','none');
                                $(this).find('.icon-check').css('display','none');
                            }
                        }
                        for(var i=0;i<BackTwo.length;i++)
                        {
                            if ($(this).text().indexOf(BackTwo[i])>=0)
                            {
                                $(this).addClass('back2');
                                $(this).find('.icon-check').css('display','none');
                            }
                        }
                        for(var i=0;i<BackThree.length;i++)
                        {
                            if ($(this).text().indexOf(BackThree[i])>=0)
                            {
                                $(this).find('.questionData').css('display','inline-block');
                                if( $(this).find('.questionData').text()=='null'){
                                    $(this).find('.questionData').css('display','none');
                                    $(this).find('.icon-check').css('display','none');
                                    $(this).append( '<i class="icon-check-empty" style="float: left;margin-right: 6px;color: #CCCCCC;">'+
                                            '</i>');
                                }
                                else {
                                    $(this).find('.questionData').css('display','none');
                                    $(this).find('.icon-check').css('margin-right','6px');
                                }
                            }
                        }

                    });

                    // console.log(BackOne);
                    // console.log(BackTwo);
                    //console.log(BackThree);


                }
            });
            $('span:contains("评价状态")').css('display','none');
            $('span:contains("评价状态")').prev().css('display','none');


        }
    };
</script>

</html>
