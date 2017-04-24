/**
 * Created by Wendy on 2016/8/24.
 */

var MyDate = new Date();
var CurrentYear = MyDate.getFullYear();
var level = $('#getlevel').val();
$(document).ready(function() {
    $('.evaluated-menu').addClass('active');
    $('.group-menu').addClass('active');
    Calendat_function();

    if($('#getlevel').val()=='校级'||$('#getlevel').val()=='大组长')
    {
        $.ajax({
            type: "get",
            async: false,
            url: "/GroupEvaluationInfo",
            data:{year1:$("#year1").val(),year2:$("#year2").val(),semester:$("#terminal").val().match(/\d/g)},
            success: function (result) {
                if (result==-1)
                {
                    alert('无记录');
                    window.location.reload();
                }
                else {
                    console.log(result);
                    $("#OneGroup").bootstrapTable('load',result[2][0]);
                    Show_Sum($('#save0')[0],$('#finish0')[0],$('#listen0')[0],result[2][0]);
                    $("#TwoGroup").bootstrapTable('load',result[2][1]);
                    Show_Sum($('#save1')[0],$('#finish1')[0],$('#listen1')[0],result[2][1]);

                    $("#ThreeGroup").bootstrapTable('load',result[2][2]);
                    Show_Sum($('#save2')[0],$('#finish2')[0],$('#listen2')[0],result[2][2]);

                    $("#FourGroup").bootstrapTable('load',result[2][3]);
                    Show_Sum($('#save3')[0],$('#finish3')[0],$('#listen3')[0],result[2][3]);


                    $('.lighter').eq(0)[0].innerHTML=result[1][0]['group']+' （组长） '+result[1][0]['name'];
                    $('.lighter').eq(1)[0].innerHTML=result[1][1]['group']+' （组长） '+result[1][1]['name'];
                    $('.lighter').eq(2)[0].innerHTML=result[1][2]['group']+' （组长） '+result[1][2]['name'];
                    $('.lighter').eq(3)[0].innerHTML=result[1][3]['group']+' （组长） '+result[1][3]['name'];
                    $('.fixed-table-loading').hide();
                }
            }
        })
    }
    else if($('#getlevel').val()=='小组长')
    {
        $.ajax({
            type: "get",
            async: false,
            url: "/GroupEvaluationInfo",
            data:{year1:$("#year1").val(),year2:$("#year2").val(),semester:$("#terminal").val().match(/\d/g)},
            success: function (result) {
                if($('#getgroup').val()=='第一组')
                {
                    $('.lighter').eq(0)[0].innerHTML=result[1][0]['group']+' （组长） '+result[1][0]['name'];
                    Show_Sum($('#saveG')[0],$('#finishG')[0],$('#listenG')[0],result[2][0]);

                    $("#Group").bootstrapTable('load',result[2][0]);

                }
                if($('#getgroup').val()=='第二组')
                {
                    $('.lighter').eq(0)[0].innerHTML=result[1][1]['group']+' （组长） '+result[1][1]['name'];
                    Show_Sum($('#saveG')[0],$('#finishG')[0],$('#listenG')[0],result[2][1]);

                    $("#Group").bootstrapTable('load',result[2][1]);

                }
                if($('#getgroup').val()=='第三组')
                {
                    $('.lighter').eq(0)[0].innerHTML=result[1][2]['group']+' （组长） '+result[1][2]['name'];
                    Show_Sum($('#saveG')[0],$('#finishG')[0],$('#listenG')[0],result[2][2]);

                    $("#Group").bootstrapTable('load',result[2][2]);
                }
                if($('#getgroup').val()=='第四组')
                {
                    $("#Group").bootstrapTable('load',result[2][3]);
                    $('.lighter').eq(0)[0].innerHTML=result[1][3]['group']+' （组长） '+result[1][3]['name'];
                    Show_Sum($('#saveG')[0],$('#finishG')[0],$('#listenG')[0],result[2][3]);

                }
                $('.fixed-table-loading').hide();
            }
        })
    }

    //导出按钮被按下时
    $('#export').click(function (){
        if (level != '校级' && level != '大组长')
        {
            if (level == '小组长')
            {
                myyear=$("#year1").val()+'-'+$("#year2").val();
                window.open(getRootPath()+"/excel/StaticGroupExport?year="+myyear+"&semester="+$("#terminal").val().match(/\d/g)[0]+"&group="+$('#getgroup').val());
            }

        }
        else {
            myyear=$("#year1").val()+'-'+$("#year2").val();
            window.open(getRootPath()+"/excel/StaticExport?year="+myyear+"&semester="+$("#terminal").val().match(/\d/g)[0]);
        }
    });

    //日期确定按钮按下时
    $('.dtpicker-buttonSet').click(function (){
        if($('#getlevel').val()=='校级'||$('#getlevel').val()=='大组长')
        {
            $.ajax({
                type: "get",
                async: false,
                url: "/GroupEvaluationInfo",
                data:{year1:$("#year1").val(),year2:$("#year2").val(),semester:$("#terminal").val().match(/\d/g)},
                success: function (result) {
                    if (result=='无记录')
                    {
                        alert('无记录');
                        window.location.reload();

                    }
                    else {
                        $("#OneGroup").bootstrapTable('load',result[2][0]);
                        Show_Sum($('#save0')[0],$('#finish0')[0],$('#listen0')[0],result[2][0]);
                        $("#TwoGroup").bootstrapTable('load',result[2][1]);
                        Show_Sum($('#save1')[0],$('#finish1')[0],$('#listen1')[0],result[2][1]);

                        $("#ThreeGroup").bootstrapTable('load',result[2][2]);
                        Show_Sum($('#save2')[0],$('#finish2')[0],$('#listen2')[0],result[2][2]);

                        $("#FourGroup").bootstrapTable('load',result[2][3]);
                        Show_Sum($('#save3')[0],$('#finish3')[0],$('#listen3')[0],result[2][3]);


                        $('.lighter').eq(0)[0].innerHTML=result[1][0]['group']+' （组长） '+result[1][0]['name'];
                        $('.lighter').eq(1)[0].innerHTML=result[1][1]['group']+' （组长） '+result[1][1]['name'];
                        $('.lighter').eq(2)[0].innerHTML=result[1][2]['group']+' （组长） '+result[1][2]['name'];
                        $('.lighter').eq(3)[0].innerHTML=result[1][3]['group']+' （组长） '+result[1][3]['name'];
                        $('.fixed-table-loading').hide();
                    }

                }
            })
        }
        else if($('#getlevel').val()=='小组长')
        {
            $.ajax({
                type: "get",
                async: false,
                url: "/GroupEvaluationInfo",
                data:{year1:$("#year1").val(),year2:$("#year2").val(),semester:$("#terminal").val().match(/\d/g)},
                success: function (result) {
                    if (result=='无记录')
                    {
                        alert('无记录');
                        window.location.reload();
                    }
                    else {
                        if($('#getgroup').val()=='第一组')
                        {
                            $('.lighter').eq(0)[0].innerHTML=result[1][0]['group']+' （组长） '+result[1][0]['name'];
                            Show_Sum($('#saveG')[0],$('#finishG')[0],$('#listenG')[0],result[2][0]);

                            $("#Group").bootstrapTable('load',result[2][0]);

                        }
                        if($('#getgroup').val()=='第二组')
                        {
                            $('.lighter').eq(0)[0].innerHTML=result[1][1]['group']+' （组长） '+result[1][1]['name'];
                            Show_Sum($('#saveG')[0],$('#finishG')[0],$('#listenG')[0],result[2][1]);

                            $("#Group").bootstrapTable('load',result[2][1]);

                        }
                        if($('#getgroup').val()=='第三组')
                        {
                            $('.lighter').eq(0)[0].innerHTML=result[1][2]['group']+' （组长） '+result[1][2]['name'];
                            Show_Sum($('#saveG')[0],$('#finishG')[0],$('#listenG')[0],result[2][2]);

                            $("#Group").bootstrapTable('load',result[2][2]);
                        }
                        if($('#getgroup').val()=='第四组')
                        {
                            $("#Group").bootstrapTable('load',result[2][3]);
                            $('.lighter').eq(0)[0].innerHTML=result[1][3]['group']+' （组长） '+result[1][3]['name'];
                            Show_Sum($('#saveG')[0],$('#finishG')[0],$('#listenG')[0],result[2][3]);

                        }
                        $('.fixed-table-loading').hide();
                    }

                }
            })
        }
    });
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
/*
* 计算每组的待提交总数，已提交总数，完成课时总数
* GroupData为每组督导听课信息
* */

function Show_Sum(save,finish,listen,GroupData)
{
    function Sum_Lession_State(GroupData)
    {
        var SavedSum = 0;
        var finishSum = 0;
        var listenedSum = 0;

        for (i=0;i<GroupData.length;i++)
        {
            SavedSum=SavedSum+GroupData[i]['save'];
            finishSum=finishSum+GroupData[i]['finish'];
            listenedSum=listenedSum+GroupData[i]['listened'];
        }
        return obj={
            SavedSum:SavedSum,
            finishSum:finishSum,
            listenedSum:listenedSum
        };
    }
    StaticSum = Sum_Lession_State(GroupData);
    save.innerHTML=StaticSum['SavedSum'];
    finish.innerHTML=StaticSum['finishSum'];
    listen.innerHTML=StaticSum['listenedSum'];

}

function getRootPath(){
    //获取当前网址，如： http://localhost:8083/uimcardprj/share/meun.jsp
    var curWwwPath=window.document.location.href;
    //获取主机地址之后的目录，如： uimcardprj/share/meun.jsp
    var pathName=window.document.location.pathname;
    var pos=curWwwPath.indexOf(pathName);
    //获取主机地址，如： http://localhost:8083
    var localhostPaht=curWwwPath.substring(0,pos);
    //获取带"/"的项目名，如：/uimcardprj
    var projectName=pathName.substring(0,pathName.substr(1).indexOf('/')+1);
    return(localhostPaht+projectName);
}