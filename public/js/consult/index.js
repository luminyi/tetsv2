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

window.actionEvents = {
    'click .info': function (e, value, row, index) {
        $("#check-consult").click();
        $("#act-name").html(row.name);
        $("#act-info").html(row.meta_description);
        $("#act-content").html(row.content);
    }
};