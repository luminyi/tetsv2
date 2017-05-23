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
    return [
        '<a class="coor seeDetail" href="javascript:void(0)" title="coor">待协调</a>'
    ].join('');
}

window.actionEvents = {
    'click .info': function (e, value, row, index) {
        $("#check-consult").click();
        $("#act-teacher").html(row.username);
        $("#act-name").html(row.name);
        $("#act-info").html(row.meta_description);
    },
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
};