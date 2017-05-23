/**
 * Created by computer on 2017/4/28.
 */
function actionFormatterNumber(value, row, index) {
    return index+1;
}
//查看详情
function actionUnitFormatter(value, row, index) {
    return [
        '<a class="edit ml10 seeDetail" href="javascript:void(0)" title="评价详情">',
        '评价详情</i>',
        '</a>'
    ].join('');
}

window.actionEvents = {

    'click .edit': function (e, value, row, index) {//评价详情
        $("#detail").click();
        $('#front').empty();
        $('#back').empty();
        var LessonName=row.课程名称.replace(/(^\s+)|(\s+$)/g,"");
        var LessonTeacher=row.任课教师.replace(/(^\s+)|(\s+$)/g,"");
        var LessonSupervisor=row.督导id.replace(/(^\s+)|(\s+$)/g,"");
        var LessonValueTime=row.听课时间.replace(/(^\s+)|(\s+$)/g,"");
        var LessonTime=row.听课节次.replace(/(^\s+)|(\s+$)/g,"");

        $.ajax({
            type: "get",
            async: false,
            url: "/EvaluationContent",
            data: {
                year1:$("#year-term-year1").val(),
                year2:$("#year-term-year2").val(),
                semester:$("#year-term-terminal").val().match(/\d/g),
                Lesson_name:LessonName,
                Teacher:LessonTeacher,
                Spuervisor:LessonSupervisor,
                Lesson_date:LessonValueTime,
                Lessontime:LessonTime},//传递学院名称
            success: function (result) {
                var chapterVal=result[1][0].章节目录;
                var LessonNameVal=result[1][0].课程名称;
                var TeacherVal=result[1][0].任课教师;
                var LessonClassVal=result[1][0].上课班级;
                var LessonRoomVal=result[1][0].上课地点;
                var ListenDateVal=result[1][0].听课时间;
                var ListenAttrVal=result[1][0].课程属性;
                var ListenSupervisorVal=result[1][0].督导姓名;
                var ListenSupervisorIDVal = result[1][0].督导id;
                var ListenTimeVal=result[1][0].听课节次;

                $('#inputChapter').val(chapterVal);
                $('#LessonName').val(LessonNameVal);
                $('#Teacher').val(TeacherVal);
                $('#LessonClass').val(LessonClassVal);
                $('#LessonRoom').val(LessonRoomVal);
                $('#ListenTime').val(ListenDateVal);
                $('#LessonTime').val(ListenTimeVal);
                $('#LessonAttr').val(ListenAttrVal);
                $('#LessonSupervisor').val(ListenSupervisorIDVal+" "+ListenSupervisorVal);

                var headnum = 12 ;//评价表头的个数

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
            }
        });
        $('span:contains("评价状态")').css('display','none');
        $('span:contains("评价状态")').prev().css('display','none');
    }
};

$(document).ready(function(){

    var year_term_calender = $("#year-term-calender");

    //调整学年学期输入框的长度
    year_term_calender.width('30%');

    x=year_term_calender.position();

    //调整学校日历的位置
    $('.dtpicker-content').css({
        "position":"relative",
        "width":$(window).width(),
        "text-align":"center",
        "margin-left": "0px",
        "margin-top": "0px"
    });

    //
    year_term_calender.focus(function (){
        var year_term_dtBox = $("#year-term-dtBox");
        var year_term_year1 = $("#year-term-year1");
        var year_term_year2 = $("#year-term-year2");
        var year_term_terminal = $("#year-term-terminal");
        var year1_term_plus = $("#year1-term-plus");
        var year1_term_minus = $("#year1-term-minus");
        school_calendar(year_term_calender, year_term_dtBox, year_term_year1, year_term_year2, year_term_terminal, year1_term_plus, year1_term_minus);
        $("#view").click(function(){
            //已听课程完成情况
            $.ajax({
                type: "get",
                async: false,
                url: "/teachEvaluation/evaluationData",
                data: {
                    year1:year_term_year1.val(),
                    year2:year_term_year2.val(),
                    semester:year_term_terminal.val(),
                    userId:userId,
                    name:userName
                },
                success: function (result) {
                    //result = JSON.parse(result);
                    console.log(result);
                    $("#finished").bootstrapTable('load',result);
                }
            });
        });
    });



});