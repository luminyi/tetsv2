/**
 * Created by computer on 2017/4/28.
 */
function actionFormatterNumber(value, row, index) {
    return index+1;
}

$(document).ready(function(){
    $("#del-consult").click(function(){
        var ids = $.map($("#consultTable").bootstrapTable('getSelections'),function(row){//获取选中的行
            var obj = {
                id:row.id
            };
            return obj;
        });
        if(ids.length==0)
        {
            alert('请选择需要删除的内容！');
        }
        else {
            $.ajax({
                type: "DELETE",
                async: false,
                url: "/consult/admin/delete",
                data: {
                    '_token': csrf_token,
                    dataArr: ids
                },
                success: function (result) {
                    alert(result);
                    window.location.reload();
                }
            });
        }
    });
});