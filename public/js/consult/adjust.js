/**
 * Created by computer on 2017/5/1.
 */
function actionFormatterNumber(value, row, index) {
    return index+1;
}

function ConsultInfo(value, row, index)
{
    return [
        '<a class="info seeDetail" href="javascript:void(0)" title="Info">详细信息</a>'
    ].join('');
}

function Coordinate(value, row, index)
{
    /*
    return [
        '<a class="coor seeDetail" href="javascript:void(0)" title="coor">待协调</a>'
    ].join('');
    */

    return [
        '<a class="coor seeDetail" href="javascript:void(0)" title="coor">待协调</a>'
    ].join('');
}


window.actionEvents = {
    'click .info': function (e, value, row, index) {
        $("#check-consult").click();
        $("#act-teacher-in").html(row.username);
        $("#act-name-in").html(row.name);
        $("#act-info-in").html(row.meta_description);
        if(row.state=="待协调")
        {
            row.content=" ";
        }
        $("#act-content-in").html(row.content);
    },
    'click .coor': function (e, value, row, index) {
        $("#coordinate").click();
        $("#act-teacher-co").html(row.username);
        $("#act-name-co").html(row.name);
        $("#act-info-co").html(row.meta_description);
        document.getElementById('consult_id').value=row.consult_id;
        document.getElementById('comment_user_id').value=row.user_id;
    },

};





/*
'click .coor': function (e, value, row, index) {
    $.ajax({
        type: "get",
        async: false,
        url: "/consult/admin/coordinate",
        data: {
            id: row.consult_id
        },
        success: function (result) {
            alert(result);
            window.location.reload();
        }
    });
}
*/