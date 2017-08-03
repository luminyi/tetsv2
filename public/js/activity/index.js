
function actionFormatterNumber(value, row, index) {
    return index+1;
}

function activityInfo(value, row, index) {
    return [
        '<a class="info seeDetail" href="javascript:void(0)" title="Info">详细信息</a>'
    ].join('');
}


function attendInfo(value, row, index) {

    if(row.state == '正在进行')
    {
        if(row.users.length != 0)
        {
            return [
                '<a class="cancel seeDetail" href="javascript:void(0)" title="cancel">取消预约</a>'
            ].join('');
        }
        else{
            return [
                '<a class="attend seeDetail" href="javascript:void(0)" title="attend">我要报名</a>'
            ].join('');
        }

    }
}

window.actionEvents = {
    'click .info': function (e, value, row, index) {
        $("#check-activity").click();
        $("#act-name").html(row.name);
        $("#act-place").html(row.place);
        $("#act-time").html(row.start_time +" ～ " + row.end_time);
        $("#act-info").html(row.information);
    },

    'click .attend': function (e, value, row, index) {
        $.ajax({
            type: "get",
            async: false,
            url: '/activity/teacher/enroll',
            data: {
                activityId:row.id,
                userId:userId,
                attendNum:row.attend_num,
                remainderNum:row.remainder_num

            },//传递学院名称
            success: function (result) {
                alert(result);
                window.location.reload();
            }
        });

    },

    'click .cancel': function (e, value, row, index) {
        $.ajax({
            type: "get",
            async: false,
            url: '/activity/teacher/cancel',
            data: {
                activityId:row.id,
                userId:userId,
                attendNum:row.attend_num,
                remainderNum:row.remainder_num
            },//传递学院名称
            success: function (result) {
                alert(result);
                window.location.reload();
            }
        });

    }
};

$(document).ready(function() {
    //


});

