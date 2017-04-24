/**
 * Created by Wendy on 2016/9/1.
 */

var MyDate = new Date();
var CurrentYear = MyDate.getFullYear();

$(document).ready(function() {
    $('.evaluated-menu').addClass('active');
    Calendat_function();
    //课程提示框
    var LessonValue=document.getElementById('LessonName');
    var TeacherValue=document.getElementById('Teacher');

    var lessondata=[];

    //输入框的操作事宜
    //$('#LessonName').bind('keyup',function(){
    //    var LessonText = $('#LessonName').val();
    //    if( LessonValue.value=='')
    //    {
    //        TeacherValue.value='';
    //    }
    //    $.ajax({
    //        type: "get",
    //        async: false,
    //        url: "/GetEvalutedLessonArr",
    //        data:{year1:$("#year1").val(),year2:$("#year2").val(),semester:$("#terminal").val().match(/\d/g),dataIn:LessonText},
    //        success: function (result) {
    //            console.log(result);
    //            lessondata = result;
    //            var html='';
    //            for (var i=0;i<result.length;i++)
    //                html+='<li>'+result[i][1]+'-'+result[i][2]+'</li>';
    //            $('#Lesson_result').html(html);
    //
    //            $('#Lesson-suggest').show().css({
    //                top:$('#LessonName').offset().top+$('#LessonName').height(),
    //                left:$('#LessonName').offset().left,
    //                position:'absolute'
    //            });
    //            $('.suggestClass').css('border','1px solid #CCC');
    //        }
    //    })
    //    $(document).bind('click',function(){
    //        $('#Lesson-suggest').hide();
    //    });
    //    $('#Lesson_result').delegate('li','click',function(){
    //        LessonValue.value=$(this).text().split('-')[0];
    //        TeacherValue.value=$(this).text().split('-')[1];
    //    });
    //});


    //绘制按钮按下时
    //$('#draw').click(function (){
    //    $.ajax({
    //        type: "get",
    //        async: false,
    //        url: "/GetEvalutedLessonContent",
    //        data:{year1:$("#year1").val(),year2:$("#year2").val(),semester:$("#terminal").val().match(/\d/g),LessonValue:LessonValue.value,TeacherValue:TeacherValue.value},
    //        success: function (result) {
    //            console.log(result);
    //            chart1();
    //        }
    //    })
    //});
});


function Calendat_function()
{
    Get_CurrentYear(CurrentYear);
    $("#calender").val( $("#year1").val()+"学年 ～ "+$("#year2").val()+"学年："+$("#terminal").val());
    $("#calender").focus(function (){
        $("#dtBox").show();
        Get_CurrentYear(CurrentYear);
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
    });

    //year1 + 按钮
    $("#year1_class1").click(function(){
        CurrentYear++;
        $("#year1").val(CurrentYear);
        $("#year2").val(parseInt(CurrentYear)+1);
    });
    //year1 - 按钮
    $("#year1_class2").click(function(){
        CurrentYear--;
        $("#year1").val(CurrentYear);
        $("#year2").val(parseInt(CurrentYear)+1);
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
                console.log(CurrentYear.match(/^\d{4}$/));
                if ( parseInt(CurrentYear)>2050 ||  parseInt(CurrentYear)<=1970 || CurrentYear.match(/^\d{4}$/) == null)
                {
                    alert("请输入正确的4位数字！有效范围为1970～2049");
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

//授课总体评价
function Chart1(data)
{

}



