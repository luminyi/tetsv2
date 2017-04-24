/**
 * Created by computer on 2016/11/22.
 */

var level  = $('#getlevel').val();
var group = $('#getgroup').val();

$(document).ready(function() {


    sidebar();

        $.ajax({
            type: "get",
            async: false,
            url: "/GetUnitUserInfo",
            data:{
                level:level,
                group:group
            },
            success: function (result)
            {
                //console.log(result);
                //data = JSON.parse(result);//console.log(data);

                $("#UnitUsertable").bootstrapTable({
                    data:result
                });
                $('.fixed-table-loading').hide();
            }
        });

    $("#reset").click(function (){
        $.ajax({
            type: "get",
            async: false,
            url: "/ResetPass",
            data:{
                data: $('#user_id').val()
            },
            success: function (result) {
                if(result!=0)
                    alert('重置密码成功！');
                else{
                    alert("重置密码失败！");
                }
            }
        });
    });
});

window.actionEvents = {
    'click .like': function (e, value, row, index) {
        $("#detail").click();
//            alert('You click like icon, row: ' + JSON.stringify(row));
        $.ajax({
            type: "get",
            async: false,
            url: "/GetSpecificUnitInfo",
            data: {data:row.user_id},//搜索框的值
            success: function (result) {
                $('#user_id').val(result[0]['user_id']);
                $('#account_name').val(result[0]['name']);
                $('#phone').val(result[0]['phone']);
                $('#email').val(result[0]['email']);
            }
        });
    }
};

function actionFormatterNumber(value, row, index) {
    return index+1;
}
function actionFormatter(value, row, index) {
    return [
        '<a class="like seeDetail" href="javascript:void(0)" title="Like">',
        '修改信息</i>',
        '</a>'
    ].join('');
}
function sidebar()
{
    $(".Unituser-menu").addClass('active');

}
