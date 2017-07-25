<!DOCTYPE html>
<meta name="render" content="webkit|ie-comp|ie-stand">
<meta http-equiv="X-UA-Compatible" content="IE=11">
<html lang="en">
<link rel="stylesheet" href="css/Theory.css" />

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
    <link rel="stylesheet" href="assets/css/evaluation-table.css" />
    <link rel="stylesheet" href="assets/css/bootstrap-material-btndesign.css" />
    <!--[if IE 7]>
    <link rel="stylesheet" href="assets/css/font-awesome-ie7.min.css" />
    <![endif]-->

    <!--[if lt IE 9]>
    <script src="assets/js/html5shiv.js"></script>
    <script src="assets/js/respond.min.js"></script>
    <![endif]-->
</head>
<style>
    #newmain{
         float: left;margin-left:2%;width: 1660px;
     }
    .KIKO{
        float: left;
        margin-left:15px;
        margin-bottom: 3px;
        text-align: center;
    }
    .KIKO1{
        float: left;
        margin-left:15px;
        margin-bottom: 3px;
        text-align: center;
        width: 30%;
    }
    .KIKO2{
        float: left;
        margin-left:15px;
        margin-bottom: 3px;
        width: 16%;
    }
    @media screen and (max-width: 768px){
        #newmain{
            overflow: auto;float: left;
            margin-left:44%;width: 1660px;
        }
        .KIKO{
            float: left;
            margin-left:15px;
            margin-bottom: 3px;
            text-align: left;
            width: 70%;
        }
        .KIKO1{
            float: none;
            margin-left:15px;
            margin-bottom: 3px;
            width: 80%;
        }
        .KIKO2{
            float: none;
            margin-left:15px;
            margin-bottom: 3px;
            width: 80%;
        }
        #search-suggest{
            left: -11px;
            top: 440px;
        }
        #Lesson-suggest{
            top: 510px;
        }

    }
    @media screen and (max-width: 415px){
        #newmain{
            overflow: auto;float: left;
            margin-left:70%;width: 1660px;
        }
        .KIKO{
            float: none;
            margin-left:15px;
            margin-bottom: 3px;
            text-align: left;
            width: 70%;
        }
        .KIKO1{
            float: none;
            margin-left:15px;
            margin-bottom: 3px;
            width: 80%;
        }
        .KIKO2{
            float: none;
            margin-left:15px;
            margin-bottom: 3px;
            width: 80%;
        }
        #search-suggest {
            left: -11px;
            top: 400px;
        }
        #Lesson-suggest{
            top: 464px;
        }
    }
</style>

{{--日历相关--}}
<link rel="stylesheet" href="calendar1/css/bootstrap-datetimepicker.css" />

<!--[if lt IE 9]>
<link rel="stylesheet" type="text/css" href="calendar/DateTimePicker-ltie9.css" />
<script type="text/javascript" src="calendar/DateTimePicker-ltie9.js"></script>
<![endif]-->

{{--<link rel="stylesheet" type="text/css" href="css/EvaluationTableCss/reset.css" />--}}
{{--<link rel="stylesheet" type="text/css" href="css/EvaluationTableCss/style.css" />--}}
{{--<link rel="stylesheet" type="text/css" href="css/EvaluationTableCss/zzsc.css" />--}}
<script src="assets/js/jquery-2.0.3.min.js"></script>
<script src="assets/js/bootstrap.min.js"></script>
<script>
    var url=location.href;
    var flag = null;
    var LessonWeekday=null;//听课星期的值
    var lessonTime = null;
    url = url.replace(/</g,"&lt;").replace(/>/g,"&gt");
    var tmp1=url.split("?")[1];
    if (tmp1!=null)
    {
        tmp1=decodeURI(tmp1);
        flag=tmp1.split("&")[0].split("=")[1];
        if(flag ==0)//课程表跳转
        {

            var unit=tmp1.split("&")[1].split("=")[1];
            var year=tmp1.split("&")[2].split("=")[1];
            var semester=tmp1.split("&")[3].split("=")[1];
            var Teacname=tmp1.split("&")[4].split("=")[1];
            var lesson=tmp1.split("&")[5].split("=")[1];
            var room=tmp1.split("&")[6].split("=")[1];
            var Class=tmp1.split("&")[7].split("=")[1];
            LessonWeekday=tmp1.split("&")[8].split("=")[1];
            lessonTime=tmp1.split("&")[9].split("=")[1];
        }
        if(flag !=0)//评价详情跳转
        {
            var chapter=tmp1.split("&")[1].split("=")[1];
            var lesson=tmp1.split("&")[2].split("=")[1];
            var Teacname=tmp1.split("&")[3].split("=")[1];
            var Class=tmp1.split("&")[4].split("=")[1];
            var room=tmp1.split("&")[5].split("=")[1];
            var Listendate=tmp1.split("&")[6].split("=")[1];
            var lessontime=tmp1.split("&")[7].split("=")[1];
            var Attr=tmp1.split("&")[8].split("=")[1];
            var Super=tmp1.split("&")[9].split("=")[1];
            LessonWeekday=new Date(Listendate).getDay();
            //获取课程节次和周数
            $.ajax({
                        type: "get",
                        async: false,
                        url: "/GetLessonTimeBylistendate",
                        data: {
                            Lesson_name: lesson,
                            Teacher: Teacname,
                            Class: Class,
                            Room:room,
                            LessonWeekday:LessonWeekday
                        },//传递学院名称
                        success: function (result) {
                            if (result != '')
                                lessonTime=result[0]['lesson_time'];
                            else
                                lessonTime = '';
                        }
                    });

        }
    }





</script>
<body onLoad="isReady=true">

@include('layout.header')

<div id="newmain" class="container-fluid clearfix">
    <div class="row clearfix">
        @include('layout.sidebar')
                <!-- 面板开始 -->
        <div class="col-sm-12 col-sm-offset-2 col-md-12 col-md-offset-2"  style="margin-top: 20px">
            <div class="page-content form-content">
                <div class="page-box">
                    <div class="panel panel-success">
                        <div class="panel-heading">
                            <p style="font-size:20px; " class="panel-title">北京林业大学本科教学督导听课评价表(理论课评价用表)</p>
                        </div>
                        <div class="panel-body">
                            <div class="info">
                                <p style="font-size: 18px;">尊敬的督导：您辛苦了！请您在听课后，认真、负责地填写评价表。</p>
                            </div>
                            <form class="form-horizontal">
                                <div class="form-group">

                                    <span for="inputChapter" id="" class="KIKO" style="padding-top: 8px;">章节目录</span>
                                    <div class="KIKO1" style="">
                                        <input type="text" class="form-control" id="inputChapter">
                                    </div>

                                    <span for="inputLessonAttr" class="KIKO" style="padding-top: 8px;">课程属性</span>
                                    <div class="KIKO2" style="">
                                        <select class="form-control" name="inputLessonAttr" id="inputLessonAttr"
                                                style="display: inline-block!important; color: lightgrey"
                                                onchange="inputLessonAttrAddCss()">
                                            <option disabled="disabled" selected="selected" style="color: lightgrey">请选择</option>
                                            <option style="color: black">必修课</option>
                                            <option style="color: black">专业选修课</option>
                                            <option style="color: black">全校公共选修课</option>
                                        </select>
                                    </div>

                                    @if(session('role')=='校级')
                                        <span for="inputChapterID" id="" class="KIKO" style="padding-top: 8px;width: auto">督导ID</span>
                                        {{--原来的搜索框--}}
                                        <div class="KIKO2" >
                                            <div class="search" >
                                                <form target="_blank" id="search-formID">
                                                    <input id="SearchBarID" class="form-control icon-remove"
                                                           type="text" value="" autocomplete="off" readonly="readonly"
                                                           style="width: 90%;">
                                                </form>
                                            </div>
                                        </div>
                                        <span for="inputChapter" class="KIKO" style="padding-top: 8px;width: auto">督导姓名</span>
                                        {{--原来的搜索框--}}
                                        <div class="KIKO2">
                                            <div class="search" >
                                                <form target="_blank" id="search-form">
                                                    <input id="SearchBar" class="form-control icon-remove"
                                                           type="text" value="" autocomplete="off" placeholder="督导姓名"
                                                           style="width: 100%;" unselectable="on"
                                                           {{--onkeydown="$('#SearchBar').val('');$('#SearchBarID').val('');"--}}
                                                    >
                                                </form>
                                            </div>
                                        </div>
                                    @endif
                                    @if(session('role')=='督导'||session('role')=='小组长')
                                        <span for="inputChapterID" class="KIKO" style="padding-top: 8px;">督导ID</span>
                                        <div class="KIKO2">
                                            <input type="text" class="form-control" id="SearchBarID" value="{{Auth::User()->user_id}}" readonly="readonly">
                                        </div>
                                        <span for="inputChapter" class="KIKO" style="padding-top: 8px;">督导姓名</span>
                                        <div class="KIKO2">
                                            <input type="text" class="form-control" id="SearchBar" value="{{Auth::User()->name}}" readonly="readonly">
                                        </div>
                                    @endif

                                    @if(session('role')=='校级')
                                        <div class="suggest" id="search-suggest" style="z-index: 9999">
                                            <ul id="search_result">

                                            </ul>
                                        </div>
                                    @endif

                                    {{--课程搜索框下拉列表--}}
                                    <div class="suggestClass" id="Lesson-suggest" >
                                        <ul id="Lesson_result">

                                        </ul>
                                    </div>

                                    {{--课程节次框--}}
                                    <div id="LessonTimeStyle">
                                        <div id="LessonTime-suggest" >
                                        </div>
                                        <div class="box_down">
                                        </div>
                                    </div>
                                </div>

                            </form>
                            <table class="table table-bordered">
                                <tr>
                                    <th>课程信息</th>
                                    <th>任课教师</th>
                                    <th>听课时间</th>
                                    <th>听课节次</th>
                                    <th>上课班级</th>
                                    <th>上课地点</th>
                                </tr>
                                <tr>
                                    <td><input type="text" class="form-control" id="LessonName" placeholder="课程名   教师名进行搜索"></td>
                                    <td><input type="text" class="form-control" id="Teacher" readonly="readonly"></td>
                                    <td><input type="text" class="form-control" id="ListenTime" placeholder="选择日期"></td>
                                    <td><input type="text" class="form-control" id="LessonTime" placeholder="请选择听课时长"></td>
                                    <td><input type="text" class="form-control" id="LessonClass" readonly="readonly"></td>
                                    <td><input type="text" class="form-control" id="LessonRoom"  readonly="readonly" ></td>

                                </tr>
                            </table>
                            <div class="alert alert-danger" style="font-size: 19px; text-align: center;">
                                <strong>  &nbsp;&nbsp;&nbsp;&nbsp; 注：</strong>
                                &nbsp;&nbsp;&nbsp;（1）5个评价等级为：非常满意、满意、正常、存在不足、存在明显不足。<br>
                                （2）评价内容共两部分：评价表正面和评价表背面。<br>
                                （3）评价表正面除“章节目录、课程属性、学生到课情况、其他”外均为必填项，背面为选填项。<br>
                                （4）此评价表为理论课评价表。
                            </div>



                            <ul id="myTab" class="nav nav-tabs">
                                <li class="active"><a href="#front" data-toggle="tab">评价表正面</a></li>
                                <li><a href="#back" data-toggle="tab" >评价表背面</a></li>
                            </ul>
                            <div id="myTabContent" class="tab-content content-font" style="padding-bottom: 70px">
                                <div class="tab-pane fade in active" id="front">

                                    <div>
                                        {{--front 第一维数组是菜单等级，第二维数组是表的种类，第三维内容--}}
                                        <?php
                                        for ($i=0;$i<count($front[1]);$i++)
                                        {
                                            echo '
                            <ul class="grade1">
                                <li>
                                    <span class="icon-folder-open-alt" style="float:left;margin-top: 4px;"></span>
                                    <h1>'.$front[1][$i].'</h1>';
                                            for($j=0;$j<count($front[2][$i]);$j++)
                                            {
                                                echo'
                                                <ul class="grade2">
                                <li>
                                    <span  style="float:left; margin-top: 4px;"></span>
                                    <h2 style="width: 600px;">'.$front[2][$i][$j].'</h2>';
                                                for ($k=0;$k<count($front[3][$i][$j]);$k++)
                                                {
                                                    echo '
                                <ul style="display: inline-block;" class="grade3">
                                  <li style="margin-top: 10px;">
                                  <h3>'.$front[3][$i][$j][$k].'</h3>';
                                                    echo '
                                  </li>
                              </ul>';
                                                }

                                                echo '
                    </li>
               </ul>';
                                            }
                                            echo'
            </li>
         </ul>';
                                        }?>
                                    </div>
                                </div>

                                <div class="tab-pane fade content-back" id="back">

                                    <dl>
                                        <?php
                                        echo '<dt>'.$back[1][0].'</dt>';
                                        echo '<dd>';
                                        for ($j=0;$j<count($back[2][0])-1;$j++)
                                        {
                                            echo '<div class="radio">';
                                            echo '    <label>';
                                            echo '    <input type="radio" name="optionsRadios" id="optionsRadios'.$j.'" value="option'.$j.'">';
                                            echo        $back[2][0][$j];
                                            echo '   </label>';
                                            echo '</div>';
                                        }
                                        echo '</dd>';

                                        for($i=1;$i<count($back[1]);$i++)
                                        {
                                            echo '<dt>'.$back[1][$i];
                                            echo '<dd>';
                                            for ($j=0;$j<count($back[2][$i]);$j++)
                                            {
                                                echo '<div class="checkbox">';
                                                echo '<label>';
                                                echo '<input type="checkbox" value="">';
                                                echo $back[2][$i][$j];
                                                echo '</label>';
                                                echo '</div>';
                                            }

                                            echo '</dd>';

                                            echo '</dt>';
                                        }
                                        ?>

                                    </dl>

                                    {{--<a href="javascript:doSaveAs()" style="color: #000;">保存本页</a>--}}
                                    {{--<a onclick="window.print()" style="color:#000;">打印本页页</a>　--}}
                                </div>

                                <button class="btn btn-success btn-raised tabBack" style="float: right;display: block;margin-top: 10px;" >评价表背面</button>
                                <button class="btn btn-success btn-raised tabFront" style="float: right; display: none;"  >评价表正面</button>
                            </div>
                            <button class="btn btn-success btn-raised submitTable" style="float: right;margin-top: 46px;margin-left:8px;display: none" >提交评价表</button>
                            <button class="btn btn-warning btn-raised saveTable" style="float: right; margin-top: 46px;display: none" >保存</button>

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
<script>
    /*------------点击正反页按钮-----------------*/
    $("#myTab li").eq(1).click(function () {
        $('.tabBack').css("display",'none');
        $('.tabFront,.submitTable,.saveTable').css("display",'block');

    });
    $("#myTab li").eq(0).click(function () {
        $('.tabBack').css("display",'block');
        $('.tabFront,.submitTable,.saveTable').css("display",'none');

    })
    $('.tabBack').click(function () {
        $('#myTab li:eq(1) a').tab('show');
        $('.tabBack').css("display",'none');
        $('.tabFront,.submitTable,.saveTable').css("display",'block');
        //alert("a");
    })
    $('.tabFront').click(function () {
        $('#myTab li:eq(0) a').tab('show');
        $('.tabBack').css("display",'block');
        $('.tabFront,.submitTable,.saveTable').css("display",'none');
    })
    /*---------------------结束-----------------*/


    $(".grade3").append(' ' +
            '<div class="box demo2" style="display: inline-block;width:600px;"> ' +
            '<ul class="tab_menu" style="display: inline-block;"> ' +
            '<li class="bar1">非常满意</li> ' +
            '<li class="bar2">满意</li> ' +
            '<li class="bar3">正常</li> ' +
            '<li class="bar4">不足</li> ' +
            '<li class="bar5">明显不足</li> ' +
            '</ul> ' +
            '</div>');

    $('h2:contains("授课总体评价")').css({'position':'absolute','left':'-46px'})
            .parents('.grade2').css({'background':'#ff753a','padding-top':'5px'});
    $('h2:contains("听课总体评价")').css({'position':'absolute','left':'-46px'})
            .parents('.grade2').css({'background':'#ff753a','padding-top':'5px'});


    //    var oh2 = document.getElementsByTagName('h2');
    $('h2:contains("到课情况")').parent().children('ul').remove();
    $('h2:contains("到课情况")').parent().append('<ul  style="display: inline-block;" class="grade3"> ' +
            '<li class="student"> ' +
            '<form class="form-horizontal"> ' +
            '<div class="form-group"> ' +
            '<label class="col-sm-3 control-label">应到人数</label> ' +
            '<div class="col-sm-3"> ' +
            '<input type="text" class="form-control" onblur="checkNum(this)" placeholder="例：80"> ' +
            '</div> ' +
            '<label class="col-sm-3 control-label">实到人数约</label> ' +
            '<div class="col-sm-3"> ' +
            '<input type="text" class="form-control" onblur="checkNum(this)" placeholder="例：80"> ' +
            '</div> ' +
            '</div> ' +
            '<div class="form-group"> ' +
            '<label class="col-sm-3 control-label">迟到人数</label> ' +
            '<div class="col-sm-3"> ' +
            '<input type="text" class="form-control" onblur="checkNum(this)" placeholder="例：0"> </div> ' +
            '<label class="col-sm-3 control-label">早退人数</label> ' +
            '<div class="col-sm-3"> ' +
            '<input type="text" class="form-control" onblur="checkNum(this)" placeholder="例：0"> ' +
            '</div> ' +
            '</div> ' +
            '</form>' +
            '</li>' +
            '</ul>');
    //    $('h3:contains("应到人数")').parent().siblings('div').remove();
    //    $('h3:contains("实到人数约")').parent().siblings('div').remove();
    //    $('h3:contains("迟到人数")').parent().siblings('div').remove();
    $('h1:contains("其他")').parent().children('ul').remove();
    $('h1:contains("其他")').parent().append('<textarea class="form-control" rows="3" style="width: 95%;"></textarea>');

    //移除自动生成的评述
    $('label:contains("如果以上各方面不能准确表达您的意见")').parent().remove();

    //背面附加内容说明
    $('dd').append('<p>如果以上各方面不能准确表达您的意见，您可以自己评述或提出具体意见和建议。</br>评述：</p>' +
            '            <textarea class="form-control" rows="3"></textarea>');


    $('label:contains("青年教师，且")').parent().addClass('radio');
    $('label:contains("青年教师，且")').children().attr('type','radio').attr('name','qingnianjiaoshi');
//
//    $('label:contains("板书存在问题")').parent().addClass('radio');
//    $('label:contains("板书存在问题")').children().attr('type','radio').attr('name','banshu');
//
//    $('label:contains("多媒体使用或搭配存在一些问题")').parent().addClass('radio');
//    $('label:contains("多媒体使用或搭配存在一些问题")').children().attr('type','radio').attr('name','duomeiti');
    //功能部分

    //单选框取消问题：即radio问题
/*
* 1、确定是哪个单选框被选了
* */
    $(function(){
            $(":radio").click(function(){
                //检查当前单选框是否为选中状态

                if($(this).attr('checked')){
                    $(this).attr('checked',false);
                }else{
                    $(this).attr('checked',true);
                }

            });
    });

</script>
<script src="js/jquery.tabs.js"></script>
<script src="calendar1/js/bootstrap-datetimepicker1.min.js"></script>
<script src="calendar1/js/locales/bootstrap-datetimepicker.zh-CN.js"></script>
<script src="js/HelpFunction.js"></script>
<script>
    var split_flag='___';//课程信息的分隔符

    //函数声明部分
    //听课时间格式检测
    function GetContent(LessonState)
    {


        var flagC =checkNeceHead_Input(LessonState);//0:成功通过验证，1：提交必填项失败 2：保存必填项失败
//        2017-01-15暂时取消必填项检查功能
//正面内容的值
        var Frontlist = [];//正面选择框的值

        //存储所有的选项框
        for (i=0;i<$('.current').length;i++)
        {
            key = $('.current').eq(i).parent().parent().prev().children()[0].innerHTML;
            if (key=='') {
                key=$('.current').eq(i).parent().parent().parent().prev()[0].innerHTML;
            }
            value = $('.current').eq(i)[0].innerHTML;
            obj = {
                key : key,
                value : value
            };
            Frontlist.push(obj);
        }
        //存储学生听课状态中的人数
        for (k=0;k<$('label:contains("人数")').length;k++)
        {
            key = $('label:contains("人数")').eq(k)[0].innerHTML;
            value = $('label:contains("人数")').eq(k).next().children().val();
            if (value == '')
                    value = '-';
            obj = {
                key : key,
                value : value
            };
            Frontlist.push(obj);
        }
        //其他部分
        obj = {
            key : '其他',
            value : $('h1:contains("其他")').next().eq(0).val()
        }
        Frontlist.push(obj);

//如果是待提交状态，将正面未完成标识写入lessonstate，并将其置为可提交状态
        if(LessonState=='待提交')
        {
            if (flagC == 1)//必填项未完成
            {
                LessonState+=flagC;
                flagC = 0;
            }
        }

        //后台传数据
        if (flagC == 0)
        {
            var Headlist=TableHeadData();
//            console.log(Headlist);
//背面的值
            var Backlist1 =GetBackList1();
            var Backlist2 =GetBackList2();

            var frontflag=null;
            $.ajax({
                type: "post",
                async: false,
                url: "/DBTheoryFrontEvaluationTable",
                data:{
                    '_token':'{{csrf_token()}}',
                    headdata:Headlist,
                    LessonState:LessonState,
                    frontdata:Frontlist,
                    backdata1:Backlist1,
                    backdata2:Backlist2,
                    valueID:flag
                },
                success: function (result) {
                    if (result!='')
                    {
                        frontflag = result;
                    }
                }
            });

            if (frontflag !='')
            {
                alert(frontflag);
                window.location.href="/EverEvaluated";
            }
        }
    }



    //督导姓名提示框
    var SearchValue=document.getElementById('SearchBar');
    var SearchValueID=document.getElementById('SearchBarID');
    //课程提示框
    var LessonValue=document.getElementById('LessonName');
    var TeacherValue=document.getElementById('Teacher');
    var LessonClassValue=document.getElementById('LessonClass');
    var LessonRoomValue=document.getElementById('LessonRoom');


    var lessondata=[];
    $(document).ready(function() {
        $('.evaluated-menu').addClass('active');
        $('.supervise-menu').addClass('active');
        $('.work-menu').addClass('active');






        //督导姓名输入框的操作事宜
        chooseSupervisor();

        var timeoutObj;//用于计时，课程信息请求次数限制

        //课程名称输入框的操作事宜
        $('#LessonName').bind('input propertychange',function(){
            var LessonText = $('#LessonName').val();
            if( LessonValue.value=='')//课程change ，其余均change
            {
                TeacherValue.value='';
                LessonClassValue.value='';
                LessonRoomValue.value='';
                $('#ListenTime').val('');
            }
            if(timeoutObj)
            {
                clearTimeout(timeoutObj);
            }
            timeoutObj = setTimeout(function(){
                var LessonText = $('#LessonName').val();
                $.ajax({
                    type: "get",
                    async: false,
                    url: "/GetLessonArrThe",
                    data:{dataIn:LessonText},
                    success: function (result) {
//                    console.log(result);
                        lessondata = result;
                        var html='';
                        for (var i=0;i<result.length;i++)
                        {
                            html+='<li class="list-group-item" style="font-size: 14px; ' +
                                    'border-bottom: lightgrey solid 2px">'
                                    +result[i]['lesson_name']+split_flag
                                    +result[i]['lesson_teacher_name']+split_flag
                                    +result[i]['lesson_week']+'周'+split_flag+'星期'
                                    +result[i]['lesson_weekday']+split_flag
                                    + result[i]['lesson_time'] +split_flag
                                    +result[i]['lesson_class']+split_flag
                                    +result[i]['lesson_room']+'</li>';
                        }
                        $('#Lesson_result').html(html);

                        $('#Lesson-suggest').show().css({
                            position:'absolute',
                            height:'220'
                        });
                        $('.suggestClass').css('border','1px solid #CCC');
                    }
                });
                $(document).bind('click',function(){
                    $('#Lesson-suggest').hide();
                });
                $('#Lesson_result').delegate('li','click',function(){
                    LessonValue.value=$(this).text().split(split_flag)[0];
                    TeacherValue.value=$(this).text().split(split_flag)[1];
                    LessonClassValue.value=$(this).text().split(split_flag)[5];
                    LessonRoomValue.value=$(this).text().split(split_flag)[6];
                    LessonWeekday=$(this).text().split(split_flag)[3].match(/\d/g);
                    lessonTime =$(this).text().split(split_flag)[4];
                    $('#LessonTime').attr("disabled",false).val('');
                    $('#ListenTime').attr("disabled",false).val('');

                    //                如果上课地点或者上课班级为空，则开放上课班级和上课地点编辑框
                    if(LessonClassValue.value=='')
                    {
                        $('#LessonClass').attr("readonly",false);
                        $('#LessonClass').attr("disabled",false);
                    }
                    if(LessonRoomValue.value=='')
                    {
                        $('#LessonRoom').attr("disabled",false);
                        $('#LessonRoom').attr("readonly",false);
                    }
                    /************************************************日历相关函数***************************************************/
                    var date_arr = null;
                    if (LessonWeekday!=null)
                    {
                        date_arr = new Array(0,1,2,3,4,5,6);
                        date_arr.splice(LessonWeekday,1);
                    }
                    chooseDate(date_arr);
//                console.log(lessondata[$(this).index()]);
                });
            },400);

        }).bind('click',function(ev){
            var oEvent=ev||event;
            oEvent.stopPropagation();

            var LessonText = $('#LessonName').val();
            if( LessonValue.value=='')
            {
                TeacherValue.value='';
                LessonClassValue.value='';
                LessonRoomValue.value='';
                $('#ListenTime').val('');
            }
            $.ajax({
                type: "get",
                async: false,
                url: "/GetLessonArrThe",
                data:{dataIn:LessonText},
                success: function (result) {
                    lessondata = result;
                    var html='';
                    for (var i=0;i<result.length;i++)
                    {
                        html+='<li class="list-group-item" style="font-size: 14px; ' +
                                'border-bottom: lightgrey solid 2px">'
                                +result[i]['lesson_name']+split_flag
                                +result[i]['lesson_teacher_name']+split_flag
                                +result[i]['lesson_week']+'周'+split_flag+'星期'
                                +result[i]['lesson_weekday']+split_flag
                                + result[i]['lesson_time'] +split_flag
                                +result[i]['lesson_class']+split_flag
                                +result[i]['lesson_room']+'</li>';
                    }
                    $('#Lesson_result').html(html);

                    $('#Lesson-suggest').show().css({
                        position:'absolute',
                        height:'220'

                    });
                    $('.suggestClass').css('border','1px solid #CCC');
                }
            });
            $(document).bind('click',function(){
                $('#Lesson-suggest').hide();
            });
            $('#Lesson_result').delegate('li','click',function(){
                LessonValue.value=$(this).text().split(split_flag)[0];
                TeacherValue.value=$(this).text().split(split_flag)[1];
                LessonWeekday=$(this).text().split(split_flag)[3].match(/\d/g);
                LessonClassValue.value=$(this).text().split(split_flag)[5];
                LessonRoomValue.value=$(this).text().split(split_flag)[6];
                lessonTime =$(this).text().split(split_flag)[4];
                $('#LessonTime').attr("disabled",false).val('');
                $('#ListenTime').attr("disabled",false).val('');
                //                如果上课地点或者上课班级为空，则开放上课班级和上课地点编辑框
                if(LessonClassValue.value=='')
                {
                    $('#LessonClass').attr("readonly",false);
                    $('#LessonClass').attr("disabled",false);
                }
                if(LessonRoomValue.value=='')
                {
                    $('#LessonRoom').attr("disabled",false);
                    $('#LessonRoom').attr("readonly",false);
                }
                /************************************************日历相关函数***************************************************/
                var date_arr = null;
                if (LessonWeekday!=null)
                {
                    date_arr = new Array(0,1,2,3,4,5,6);
                    date_arr.splice(LessonWeekday,1);
                }
                chooseDate(date_arr);
            });
        });

        //课程节次的坐标
        var LessonTime_X = $('#LessonTime').position().left;
        var LessonTime_Y = $('#LessonTime').position().top;
        $(window).resize(function (){
            LessonTime_X = $('#LessonTime').position().left;
            LessonTime_Y = $('#LessonTime').position().top;
        });

        //若一开始课程选择框为空时，则将课程节次选择框置为空
//
        if($('#LessonName').val()=='')
            $('#LessonTime').attr("disabled",true);
        else
            $('#LessonTime').attr("disabled",false);

        if($('#LessonName').val()=='')//课程节次
            $('#ListenTime').attr("disabled",true);
        else
            $('#ListenTime').attr("disabled",false);

//        如果是从课程表中跳转过来的话，日历函数的操作为
        if (flag == 0)
        {
            var date_arr = null;
            if (LessonWeekday!=null)
            {
                date_arr = new Array(0,1,2,3,4,5,6);
                date_arr.splice(LessonWeekday,1);
            }
            chooseDate(date_arr);
//        如果是从课程表中跳转过来的话，若课程没有提供上课地点，则为
            if(LessonClassValue.value=='')
            {
                $('#LessonClass').attr("readonly",false);
                $('#LessonClass').attr("disabled",false);
            }
            if(LessonRoomValue.value=='')
            {
                $('#LessonRoom').attr("disabled",false);
                $('#LessonRoom').attr("readonly",false);
            }
        }


        $("#LessonTime").focus(function (){
            $('#LessonTime-suggest').children().remove();
            if(LessonValue.value=='')
            {
                alert('请先选择课程名称');
                $('#LessonTime').attr("disabled",true);

            }
            else {
                $('#LessonTimeStyle').css("display","block");
                if ( lessonTime == '')
                {
                    AddLessonTime(LessonTime_X,LessonTime_Y,'01020304050607080910');
                }
                else{
                    AddLessonTime(LessonTime_X,LessonTime_Y,lessonTime);
                }
            }
        });


//听课节次面板控制
        $(function ()
        {
            $("#LessonTime").click(function (event)
            {
                // $(".box_classify").show();
                $(document).one("click", function ()
                {//对document绑定一个影藏Div方法
                    $("#LessonTimeStyle").hide();
                });
                event.stopPropagation();//阻止事件向上冒泡
            });
            $("#LessonTimeStyle").click(function (event)
            {
                event.stopPropagation();//阻止事件向上冒泡
            });
        });

        $(function(){
            $('.demo2').Tabs({
                event:'click'
            });
        });

        (function(){
            $('dl').on('click', 'dt', function() {
                $(this).next().slideToggle(200);
            });

        })();
    });

    //页面内容提交
    $('.submitTable').click(function(){
        var LessonState='已完成';
        GetContent(LessonState);
    });

    $('.saveTable').click(function(){
        var LessonState='待提交';
        GetContent(LessonState);
    });



    var  contentFrontdata=[];
    var  contentBackdata=[];


    // 从Evaluation页面跳转过来的的信息填写表内容
    $("#LessonName").val(lesson);
    $("#Teacher").val(Teacname);
    $("#LessonClass").val(Class);
    $("#LessonRoom").val(room);
    if(flag != 0 && flag != null)
    {
        $("#inputChapter").val(chapter);
        $("#inputLessonAttr").val(Attr).css('color','black');
        $("#ListenTime").val(Listendate);
//        根据日期判断星期几
        var b = new Date(Date.parse(Listendate.replace(/\-/g,"/")));
        var date_arr = null;
        if (LessonWeekday!=null)
        {
            date_arr = new Array(0,1,2,3,4,5,6);
            date_arr.splice(b.getDay(),1);
        }
        chooseDate(date_arr);
        $("#LessonTime").val(lessontime);

        //向数据库请求填写信息
        $.ajax({
            type: "get",
            async: false,
            url: "/EvaluationContent",
            data: {
                year1: null,
                year2: null,
                semester: null,
                Lesson_name: lesson,
                Teacher: Teacname,
                Spuervisor: SearchValueID.value,
                Lesson_date: Listendate,
                Lessontime: lessontime
            },//传递学院名称
            success: function (result) {
//                console.log(result);

                //正面 评价内容
                contentFrontdata=result[1];

                $('.grade3 h3').each(function () {
//                    console.log( $(this).parent().next().children().children()[0].className)
//                    console.log(contentFrontdata[0][$(this).text()]);
                    for (j=0;j<$(this).parent().next().children().children().length;j++)
                    {
//                        console.log($(this).parent().next().children().children()[j])
                        if($(this).parent().next().children().children()[j].innerText==contentFrontdata[0][$(this).text()])
                        {
                            $(this).parent().next().children().children()[j].className += (' current');
//                            console.log(contentFrontdata[0][$(this).text()])
                        }
                    }
                });
//                console.log($('.grade2 h2')[0].innerText);

//                 console.log(contentFrontdata[0][$(this).text()]);
                for (j=0;j<$('.grade2').length;j++)
                {
                    if(contentFrontdata[0][$('.grade2 h2')[j].innerText] != null )
                    {
                        for (k=0;k< $('.grade2 h2').eq(j).next().children().eq(1).children().children().length;k++)
                        {
//                            console.log(contentFrontdata[0][$('.grade2 h2')[j].innerText]);
                            if($('.grade2 h2').eq(j).next().children().eq(1).children().children()[k].innerText == contentFrontdata[0][$('.grade2 h2')[j].innerText])
                            {
                                $('.grade2 h2').eq(j).next().children().eq(1).children().children()[k].className +=(' current');
                            }
                        }
                    }
                }

                $('.control-label').eq(0).next().children().val(contentFrontdata[0]['应到人数']);
                $('.control-label').eq(1).next().children().val(contentFrontdata[0]['实到人数约']);
                $('.control-label').eq(2).next().children().val(contentFrontdata[0]['迟到人数']);
                $('.control-label').eq(3).next().children().val(contentFrontdata[0]['早退人数']);

//                console.log($('h1:contains("其他")').next());
                $('h1:contains("其他")').next().eq(0).val(contentFrontdata[0]['其他']);

                //背面 评价内容
                var  contentFrontdata=result[2];
//                console.log(result[2]);
                for (var key in result[2][0])
                {
                    if(result[2][0][key] != null )
                    {
                        for(k=0;k<$('.radio').length;k++)
                        {
//                            console.log($('.radio').eq(k).children()[0].innerText.replace(/(^\s*)|(\s*$)/g, ""));
//                            console.log(key);
//                            console.log($('.radio').eq(0).children().children().eq(0) );
                            if($('.radio').eq(k).children()[0].innerText.replace(/(^\s*)|(\s*$)/g, "") == key )
                            {
                                $('.radio').eq(k).children().children().eq(0).attr('checked','checked');
//                                console.log($('.radio').eq(k).children().children().eq(0));
                            }
                        }
                        for(k=0;k<$('.checkbox').length;k++)
                        {
//                            console.log($('.radio').eq(k).children()[0].innerText);
//                            console.log( key );
                            if($('.checkbox').eq(k).children()[0].innerText.replace(/(^\s*)|(\s*$)/g, "") == key )
                            {
                                $('.checkbox').eq(k).children().children().eq(0).attr('checked','checked');
                            }
                        }
                        $(' textarea').eq(1).val(contentFrontdata[0]['如果以上各方面不能准确表达您的意见，您可以自己评述或提出具体意见和建议。4']);
                        $(' textarea').eq(2).val(contentFrontdata[0]['如果以上各方面不能准确表达您的意见，您可以自己评述或提出具体意见和建议。5']);
                        $(' textarea').eq(3).val(contentFrontdata[0]['如果以上各方面不能准确表达您的意见，您可以自己评述或提出具体意见和建议。6']);

                    }
                }
            }
        });
    }
</script>
</html>
