//活动的id：管理员审核参与教师时使用
var activity_ID = null;


function actionFormatterNumber(value, row, index) {
    return index+1;
}

function activityInfo(value, row, index) {
    return [
        '<a class="info seeDetail" href="javascript:void(0)" title="Info">详细信息</a>'
    ].join('');
}

function activityModify(value, row, index) {
    return [
        '<a class="modify seeDetail" href="javascript:void(0)" title="modify">修改活动</a>'
    ].join('');
}
window.actionEvents = {
    'click .info': function (e, value, row, index) {
        activity_ID = row.id;
        $("#check-activity").click();
        $("#act-name").html(row.name);
        $("#act-place").html(row.place);
        $("#act-time").html(row.start_time +" ～ " + row.end_time);
        $("#apply_act-time").html(row.apply_start_time +" ～ " + row.apply_end_time);
        $("#act-info").html(row.information);
        $("#act-ID").val(row.id).attr('readonly',true);
        $("#remind_num").val(row.remainder_num).attr('readonly',true);
        $.ajax({
            type: "get",
            async: false,
            url: '/activity/admin/attendTeacher',
            data: {
                id:row.id
            },//传递学院名称
            success: function (result) {
console.log(row);
                $('#attendTable').bootstrapTable('load', result);
            }
        });
        //教师名单
        $("#activityName").html(row.name).attr('readonly',true);
        $("#activityID").html(row.id).attr('readonly',true);
        $.ajax({
            type: "get",
            async: false,
            url: '/activity/admin/Teachers',
            data: {
                id:row.id
            },//传递学院名称
            success: function (result) {
                $('#ACteacherTable').bootstrapTable('load', result);
            }
        });


    },
    'click .modify': function (e, value, row, index) {
        $('#change-activity-btn').click();
        $("#nameChange").val(row.name).attr('readonly',true);
        $("#teacherChange").val(row.teacher);
        $("#start_timeChange").val(row.start_time);
        $("#placeChange").val(row.place);
        $("#end_timeChange").val(row.end_time);
        $("#termChange").val(row.term);
        $("#all_numChange").val(row.all_num);
        $("#informationChange").val(row.information);
        $("#apply_start_timeChange").val(row.apply_start_time);
        $("#apply_end_timeChange").val(row.apply_end_time);
    }
};

$(document).ready(function() {
    //

   var year_calender = $("#year-calender");
    year_calender.focus(function (){
        var year_dtBox = $("#year-dtBox");
        var year_year1 = $("#year-year1");
        var year_year2 = $("#year-year2");
        var year1_plus = $("#year1-plus");
        var year1_minus = $("#year1-minus");
        var year_terminal = null;
        school_calendar(year_calender, year_dtBox, year_year1, year_year2, year_terminal, year1_plus, year1_minus);
        $("#year-sure").click(function(){
            window.location.href='/activity/modify/'+year_year1.val()+'-'+year_year2.val();
        });
    });


    var year_term_calender = $("#year-term-calender");
    year_term_calender.focus(function (){
        var year_term_dtBox = $("#year-term-dtBox");
        var year_term_year1 = $("#year-term-year1");
        var year_term_year2 = $("#year-term-year2");
        var year_term_terminal = $("#year-term-terminal");
        var year1_term_plus = $("#year1-term-plus");
        var year1_term_minus = $("#year1-term-minus");
        school_calendar(year_term_calender, year_term_dtBox, year_term_year1, year_term_year2, year_term_terminal, year1_term_plus, year1_term_minus);
        $("#year-term-sure").click(function(){
            window.location.href='/activity/modify/'+year_term_year1.val()+'-'+year_term_year2.val()+'-'+year_term_terminal.val().match(/\d/g);
        });
    });

//choose the activity begin and end time
    $("#start_time").datetimepicker({
        format: "yyyy-mm-dd hh:ii",
        autoclose: true,
        todayBtn: true,
        startDate: "2013-02-14 10:00",
        minuteStep: 10
    });

    $("#end_time").datetimepicker({
        format: "yyyy-mm-dd hh:ii",
        autoclose: true,
        todayBtn: true,
        startDate: "2013-02-14 10:00",
        minuteStep: 10
    });

    $("#apply_start_time").datetimepicker({
        format: "yyyy-mm-dd hh:ii",
        autoclose: true,
        todayBtn: true,
        startDate: "2013-02-14 10:00",
        minuteStep: 10
    });

    $("#apply_end_time").datetimepicker({
        format: "yyyy-mm-dd hh:ii",
        autoclose: true,
        todayBtn: true,
        startDate: "2013-02-14 10:00",
        minuteStep: 10
    });

    $("#start_timeChange").datetimepicker({
        format: "yyyy-mm-dd hh:ii",
        autoclose: true,
        todayBtn: true,
        startDate: "2013-02-14 10:00",
        minuteStep: 10
    });

    $("#end_timeChange").datetimepicker({
        format: "yyyy-mm-dd hh:ii",
        autoclose: true,
        todayBtn: true,
        startDate: "2013-02-14 10:00",
        minuteStep: 10
    });

    $("#apply_start_timeChange").datetimepicker({
        format: "yyyy-mm-dd hh:ii",
        autoclose: true,
        todayBtn: true,
        startDate: "2013-02-14 10:00",
        minuteStep: 10
    });

    $("#apply_end_timeChange").datetimepicker({
        format: "yyyy-mm-dd hh:ii",
        autoclose: true,
        todayBtn: true,
        startDate: "2013-02-14 10:00",
        minuteStep: 10
    });

    $("#del-activity").click(function(){
        var ids = $.map($("#activityTable").bootstrapTable('getSelections'),function(row){//获取选中的行
            var obj = {
                id:row.id
            };
            return obj;
        });
        if(ids.length==0)
        {
            alert('请选择需要删除的活动！');
        }
        else {
            $.ajax({
                type: "post",
                async: false,
                url: "/activity/admin/delete",
                data: {
                    '_token': csrf_token,
                    dataArr: ids
                },//传递学院名称
                success: function (result) {
                    alert(result);
                    window.location.reload();
                }
            });
        }
    });
    //报名已参加
    $("#review11").click(function(){
        var ChangeState = "报名已参加";
        var ids = $.map($("#ACteacherTable").bootstrapTable('getSelections'),function(row){//获取选中的行
            var obj = {
                id:row.id
            };
            return obj;
        });
        if(ids.length==0)
        {
            alert('无选择人员！');
        }
        else {
            //console.log(activity_ID);
            $.ajax({
                type: "post",
                async: false,
                url: "/activity/admin/TeachersState",
                data: {
                    '_token': csrf_token,
                    dataArr: ids,
                    activity_id:activity_ID,
                    newState: ChangeState
                },//传递学院名称
                success: function (result) {
                    alert(result);
                    $(".close").click();
                }
            });
        }
    });
    //报名未参加
    $("#review10").click(function(){
        var ChangeState = "报名未参加";
        var ids = $.map($("#ACteacherTable").bootstrapTable('getSelections'),function(row){//获取选中的行
            var obj = {
                id:row.id
            };
            return obj;
        });
        if(ids.length==0)
        {
            alert('无选择人员！');
        }
        else {
            $.ajax({
                type: "post",
                async: false,
                url: "/activity/admin/TeachersState",
                data: {
                    '_token': csrf_token,
                    dataArr: ids,
                    activity_id:activity_ID,
                    newState: ChangeState
                },//传递学院名称
                success: function (result) {
                    alert(result);
                    $(".close").click();
                }
            });
        }
    });
    //未报名参加
    $("#review01").click(function(){
        var ChangeState = "未报名参加";
        var ids = $.map($("#ACteacherTable").bootstrapTable('getSelections'),function(row){//获取选中的行
            var obj = {
                id:row.id
            };
            return obj;
        });
        if(ids.length==0)
        {
            alert('无选择人员！');
        }
        else {
            $.ajax({
                type: "post",
                async: false,
                url: "/activity/admin/TeachersState",
                data: {
                    '_token': csrf_token,
                    dataArr: ids,
                    activity_id:activity_ID,
                    newState: ChangeState
                },//传递学院名称
                success: function (result) {
                    alert(result);
                    $(".close").click();
                    // window.location.reload();
                }
            });
        }
    });


    $("#export-teacher").click(function(){

        var act = $("#activityID").html();
        var aname = $("#activityName").html();
        window.open(getRootPath()+"/excel/teacherExport?activity="+act+"&ActName="+aname);
    });
    $("#export-activity").click(function(){
        window.open(getRootPath()+"/excel/ActivityExport?flag="+term);
    });
});
