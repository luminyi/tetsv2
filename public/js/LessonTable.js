/**
 * Created by computer on 2016/7/12.
 * 点击dashboard时，传递学院名称，
 *  时间：本学年时间
 *  课表：显示该学院第一个老师的课表
 *
 *  前台向后台传递：
 *
 *      1、获取学院名称、教师id、教师姓名
 *      2、获取表格中课程信息
 *      3、指派给督导，督导的姓名
 */
var partment=[
    '林学院','水土保持学院'
    ,'生物科学与技术学院','园林学院'
    ,'经济管理学院','工学院'
    ,'理学院','信息学院'
    ,'人文社会科学学院','外语学院'
    ,'材料科学与技术学院','自然保护区学院'
    ,'环境科学与工程学院','艺术设计学院','体育教学部'];

var MyDate = new Date();
var CurrentYear = MyDate.getFullYear();


var dashboard_index=0;

var department=null;
var yijizhibiao=null;

var year1=null;
var year2=null;
var terminal=null;

var lessonDetail=null;

$(document).ready(function()
{
    $('.setting-menu').addClass('active');
    $('.class-menu').addClass('active');
    //Dashboard_Click(dashboard_row,dashboard_col);
    Calendat_function();
//    教师课表
    $('.input1').focus(
        function(){
			$('.box_classify').css("display","block");
            search_ajax();
        }
    );


//点击查询
    $("#View_Btn").click(function (){
        $(".box_classify").hide();

        if ( yijizhibiao==null || $('.input1').val()=='' )
            alert("请选择教师");
        else {
            //清楚表格内容
            for(row = 1; row <= 5;row ++)
                for (col = 1;col<=5;col++) {
                    $(".info" + row + " th").eq(col).empty();
                }


            $.ajax({ //搜索框最二级指标
                type: "get",
                async: false,
                url: "/Lesson",
                data:{
                    unit: yijizhibiao,
                    name:$('.input1').val(),
                    year:$("#year1").val()+"-"+$("#year2").val(),
                    semester:$("#terminal").val().match(/\d/g)
                },
                success: function (result) {
                    lessonDetail=result;
                    console.log(result);
                    for (i=0;i<result.length;i++)
                    {
                        //判断该课程是两课时还是四课时还是一天的课

                        AppendLesson(result[i],result[i]['lesson_time']);

                    }
                }

            });
        }

    });


});

function AddTask_board(p)
{
    //使其兼容ie




    var pf = p.parentNode ;
    //提取星期
    posstart=pf.innerHTML.indexOf('%');
    posend=pf.innerHTML.indexOf('</p>');
    //alert(pf.innerHTML);
    //alert(posstart);
    //alert(posend);

    if(posstart>0 && posend>0)
    {
        LessonWeekday = pf.innerHTML.substring(posstart,posend).match(/\d+/);
    }
    else
    {
        LessonWeekday = 7;
    }

    var unit = yijizhibiao;
    var year =$("#year1").val()+"-"+$("#year2").val();
    var semester=$("#terminal").val().match(/\d/g);
    var name = $('.input1').val();
    var LessonName=p.parentNode.innerHTML.split("<br>")[0];
    var Room = p.parentNode.innerHTML.split("<br>")[2];
    var LessonClass = p.parentNode.innerHTML.split("<br>")[1];
    var week = p.parentNode.innerHTML.split("<br>")[3];
    LessonTime = p.parentNode.parentNode.parentNode.className.match(/\d+/);//第几节课
    $("#select").click();
    $("#tableattr option[value='1']").removeAttr("selected");
    $("#tableattr option[value='2']").removeAttr("selected");
    $("#tableattr option[value='3']").removeAttr("selected");
    for (var k=0;k<lessonDetail.length;k++)
    {
        if (lessonDetail[k]['lesson_name'].indexOf(LessonName)>=0
            && lessonDetail[k]['lesson_room'].indexOf(Room)>=0
            && lessonDetail[k]['lesson_week'].indexOf(week)>=0
            && lessonDetail[k]['lesson_class'].indexOf(LessonClass)>=0
        )
        {


            if (lessonDetail[k]['lesson_attribute'].indexOf('普通课')>=0)
                $("#tableattr option[value='1']").attr("selected","selected");
            if (lessonDetail[k]['lesson_attribute'].indexOf('实')>=0)
                $("#tableattr option[value='2']").attr("selected","selected");
            if (lessonDetail[k]['lesson_attribute'].indexOf('体育')>=0)
                $("#tableattr option[value='3']").attr("selected","selected");
        }
    }
    $("#sure").click(function (){
        var attr = $("#tableattr").val();
        if (attr == 1)
        {
            window.location.replace('/TheoryEvaluationTableView?flag=0' +
                '&unit='+unit+'&year='+year+'&semester='+semester+'' +
                '&name='+name+'&lesson='+LessonName+'&Room='+Room+'&Class='+LessonClass+
                '&LessonWeekday='+LessonWeekday+'&lessonTime='+change_lessontime(LessonTime));
        }
        else if (attr==2)
        {
            window.location.replace('/PracticeEvaluationTableView?flag=0' +
                '&unit='+unit+'&year='+year+'&semester='+semester+'' +
                '&name='+name+'&lesson='+LessonName+'&Room='+Room+'&Class='+LessonClass+
                '&LessonWeekday='+LessonWeekday+'&lessonTime='+change_lessontime(LessonTime));
        }else if (attr==3)
        {
            window.location.replace('/PhysicalEvaluationTableView?flag=0' +
                '&unit='+unit+'&year='+year+'&semester='+semester+'' +
                '&name='+name+'&lesson='+LessonName+'&Room='+Room+'&Class='+LessonClass+
                '&LessonWeekday='+LessonWeekday+'&lessonTime='+change_lessontime(LessonTime));
        }
    });
}

function Calendat_function()
{
    Get_CurrentYear(CurrentYear);
    $("#calender").val( $("#year1").val()+"学年 ～ "+$("#year2").val()+"学年："+$("#terminal").val());
    $("#calender").focus(function (){
        $("#dtBox").show();
        Get_CurrentYear(CurrentYear);
        $(".box_classify").hide();
    });
//        X 按钮
    $(".dtpicker-close").click(function(){
        $("#dtBox").hide();
    });
//        取消按钮
    $(".dtpicker-buttonClear").click(function(){
        $("#dtBox").hide();
    });
//        确定按钮
    $(".dtpicker-buttonSet").click(function(){
        $("#dtBox").hide();
        $("#calender").val( $("#year1").val()+"学年 ～ "+$("#year2").val()+"学年："+$("#terminal").val());
        year1 = $("#year1").val();
        year2 = $("#year2").val();
        terminal = $("#terminal").val();
    });

    //year1 + 按钮
    $("#year1_class1").click(function(){
        CurrentYear++;
        $("#year1").val(CurrentYear);
        $("#year2").val(CurrentYear+1);
    });
    //year1 - 按钮
    $("#year1_class2").click(function(){
        CurrentYear--;
        $("#year1").val(CurrentYear);
        $("#year2").val(CurrentYear+1);
    });
    //学期选择的 +、- 按钮
    $(".dtpicker-compButtonEnable").click(function(){
        if ( $("#terminal").val() == "第1学期")
            $("#terminal").val("第2学期");
        else
            $("#terminal").val("第1学期");
    })
    $("#year1").bind('keyup',function(){
        CurrentYear=$("#year1").val();
        if( CurrentYear.length==4)
        {
            $("#year1").blur(function(){
                //console.log(CurrentYear.match(/^\d{4}$/));
                if ( parseInt(CurrentYear)>=2050 ||  parseInt(CurrentYear)<=1970 || CurrentYear.match(/^\d{4}$/) == null)
                {
                    alert("请输入正确的4位数字！有效范围为1970～2050");
                    CurrentYear = MyDate.getFullYear();
                }
                $("#year1").val(CurrentYear);
                $("#year2").val(parseInt(CurrentYear)+1);

            });
        }
    });
    function Get_CurrentYear(year)
    {

        if ( (MyDate.getMonth()+1) <8 && (MyDate.getMonth()+1) >= 3)
        {
            $("#terminal").val("第2学期");
            terminal = 2;
            $("#year1").val(year-1);
            $("#year2").val(year);
        }
        else
        {
            $("#terminal").val("第1学期");
            terminal=1;

            if (MyDate.getMonth()+1 < 3)
            {
                $("#year1").val(year-1);
                $("#year2").val(year);
            }
            if(MyDate.getMonth()+1 >= 8)
            {
                $("#year1").val(year);
                $("#year2").val(year+1);
            }
        }

    }
}

function search_ajax(){//搜索框用的ajax函数
    var timeoutObj = null;
    $('.box_classify').css("display","block");
    //$('.water').removeClass('active1');
    //
    //if (yijizhibiao == null)
    //    yijizhibiao=partment[0];
    yijizhibiao=partment[0];
    $('.box_down').children().remove();

    search_small_ajax();
    $('.water').click(
        function(){
            $('.water').removeClass('active1');
            $(this).addClass('active1');
            yijizhibiao=partment[$(this).index()];
            $('.box_down').children().remove();
            if(timeoutObj)
            {
                clearTimeout(timeoutObj);
            }
            timeoutObj = setTimeout(search_small_ajax(),800);
        });
}
$(function ()
{
    $(".input1").click(function (event)
    {
        // $(".box_classify").show();
        $(document).one("click", function ()
        {//对document绑定一个影藏Div方法
            $(".box_classify").hide();
        });
        event.stopPropagation();//阻止事件向上冒泡
    });
    $(".box_classify").click(function (event)
    {
        event.stopPropagation();//阻止事件向上冒泡
    });
});

function search_small_ajax(){

    $.ajax({ //搜索框最二级指标
        type: "get",
        async: false,
        url: "/LessonTeacher",
        data:{
            unit: yijizhibiao,
            time:$("#year1").val()+"-"+$("#year2").val(),
            semester:$("#terminal").val().match(/\d/g)[0]
        },
        success: function (result) {
            //console.log(result);
            Name_Index = result.Index;
            Name_Value = result.Value;

            //console.log(Name_Value);

            for (var index_num in Name_Index)
            {
                //console.log(Name_Value[index_num]);
                flag = 0;
                if (Name_Index[index_num]=='')//生僻字
                {
                    $('.box_down').append(
                        "<div class='index_detail' style='font-size: 18px; color: black'>其他</div>");

                }
                else {
                    $('.box_down').append(
                        "<div class='index_detail' style='font-size: 18px; color: black'>"
                        +Name_Index[index_num]
                        +"</div>");
                }
                for (var i=0; i < Name_Value.length; i++)
                {
                    if (Name_Value[i].Letter == Name_Index[index_num])
                    {
                        $('.box_down').append(
                            "<div class='index_detail' onclick='ok(this)'>"
                            +Name_Value[i].Name
                            +"</div>");
                        flag ++ ;
                    }
                }
                if (flag > 17)
                {
                    $('.box_down').append(
                        "</br></br></br></br></br>");
                }else
                if (flag > 12)
                {
                    $('.box_down').append(
                        "</br></br></br></br>");
                }else if(flag >= 7)
                {
                    $('.box_down').append(
                        "</br></br></br>");
                }
                else
                {
                    $('.box_down').append(
                        "</br></br>");
                }
            }

        }

    });
}
function ok(obj)
{
    $('.input1').val($(obj).text());
    $('.box_classify').css("display","none");
}

function AppendLesson(result,lesson_time) {

    if (lesson_time != null && lesson_time !='' )
    {
        var reg = /\d{4}/g;
        rs = lesson_time.match(reg);
        // console.log(rs.length);

        for (var i = 0; i < rs.length; i++)
        {
            // console.log(rs[i]);

            if (rs[i]=='0102')
            {
                th='1';
                $(".info"+th+" th").eq(result['lesson_weekday']).
                append(
                    '<div>'+
                    result['lesson_name']+'<br>'+
                    result['lesson_class']+'<br>'+
                    result['lesson_room']+'<br>'+
                    result['lesson_week']+'<br>'+'<p style="display: none">%'+result['lesson_weekday']+'</p>'+
                    '<i class="icon-edit" style="float: right !important; cursor: pointer;" onclick="AddTask_board(this)";>评价'+'</i>'
                    +'</div>'
                );
            }
            if (rs[i]=='0304')
            {
                th='2';
                $(".info"+th+" th").eq(result['lesson_weekday']).
                append(
                    '<div>'+
                    result['lesson_name']+'<br>'+
                    result['lesson_class']+'<br>'+
                    result['lesson_room']+'<br>'+
                    result['lesson_week']+'<br>'+'<p style="display: none">%'+result['lesson_weekday']+'</p>'+
                    '<i class="icon-edit" style="float: right !important; cursor: pointer;" onclick="AddTask_board(this)";>评价'+'</i>'
                    +'</div>'
                );
            }
            if (rs[i]=='0506')
            {
                th='3';
                $(".info"+th+" th").eq(result['lesson_weekday']).
                append(
                    '<div>'+
                    result['lesson_name']+'<br>'+
                    result['lesson_class']+'<br>'+
                    result['lesson_room']+'<br>'+
                    result['lesson_week']+'<br>'+'<p style="display: none">%'+result['lesson_weekday']+'</p>'+
                    '<i class="icon-edit" style="float: right !important; cursor: pointer;" onclick="AddTask_board(this)";>评价'+'</i>'
                    +'</div>'
                );
            }
            if (rs[i]=='0708')
            {
                th='4';
                $(".info"+th+" th").eq(result['lesson_weekday']).
                append(
                    '<div>'+
                    result['lesson_name']+'<br>'+
                    result['lesson_class']+'<br>'+
                    result['lesson_room']+'<br>'+
                    result['lesson_week']+'<br>'+'<p style="display: none">%'+result['lesson_weekday']+'</p>'+
                    '<i class="icon-edit" style="float: right !important; cursor: pointer;" onclick="AddTask_board(this)";>评价'+'</i>'
                    +'</div>'
                );
            }
            if (rs[i].indexOf('0910')>=0)
            {
                th='5';
                $(".info"+th+" th").eq(result['lesson_weekday']).
                append(
                    '<div>'+
                    result['lesson_name']+'<br>'+
                    result['lesson_class']+'<br>'+
                    result['lesson_room']+'<br>'+
                    result['lesson_week']+'<br>'+'<p style="display: none">%'+result['lesson_weekday']+'</p>'+
                    '<i class="icon-edit" style="float: right !important; cursor: pointer;" onclick="AddTask_board(this)";>评价'+'</i>'
                    +'</div>'
                );
            }
        }
        if($("#getlevel").val().indexOf('督导')==-1 && $("#getlevel").val().indexOf('校级')==-1)
        {
            $(".icon-edit").hide();
        }
        else{
            $(".icon-edit").show();
        }
    }
}

//课表  听课节数转换
function change_lessontime(lessonTime)
{
    if(lessonTime=='1')
        return '0102';
    if(lessonTime=='2')
        return '0304';
    if(lessonTime=='3')
        return '0506';
    if(lessonTime=='4')
        return '0708';
    if(lessonTime=='5')
        return '0910';
}