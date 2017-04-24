/**
 * Created by computer on 2016/7/12.
 *
 * 1、页面默认第一个督导的听课任务
 * 2、添加、删除任务时
 *      （1）课程编号
 *      （2）督导姓名
 *      （3）传递当前学年、学期
 */
var MyDate = new Date();
var CurrentYear = MyDate.getFullYear();
var SearchValue=document.getElementById('SearchBar');

$(document).ready(function() {
    $('.setting-menu').addClass('active');
    $('.necessary-menu').addClass('active');



    Calendat_function();

    //给“学期关注课程”添加时间
    $('.type_tit2').html($("#calender").val()+" 关注课程列表");

//输入框的操作事宜
    $('#SearchBar').bind('input',function(){
        var searchText = $('#SearchBar').val();
        $.ajax({
            type: "get",
            async: false,
            url: "/GetLessonArrTNLN",
            data:{dataIn:searchText},
            dataType:'json',
            success: function (result) {
                console.log(result);
                var html='';
                for (var i=0;i<result.length;i++)
                    html+='<li>'+result[i]['lesson_name']+'_'+result[i]['lesson_teacher_name']+'</li>';
                $('#search_result').html(html);

                $('#search-suggest').show().css({
                    //top:$('#search-form').offset().top+$('#search-form').height(),
                    //left:$('#search-form').offset().left,
                    position:'absolute'
                });
            }
        })
        $(document).bind('click',function(){
            $('#search-suggest').hide();
        });
        $('#search_result').delegate('li','click',function(){
            SearchValue.value=$(this).text();
        });
    });
    if($('#getlevel').val() == '校级' || $('#getlevel').val() == '大组长')
    {
        $.ajax({
            type: "get",
            async: false,
            url: "/GetNecessaryTask",
            data: {
                year1: $("#year1").val(),
                year2:$("#year2").val(),
                semester:$("#terminal").val().match(/\d+/g),
                unit:null
            },//传递学院名称
            success: function (result) {
                result = JSON.parse(result);
                $("#table").bootstrapTable('load',result);

                //console.log(result);
                $("#table").bootstrapTable({
                    data:result
                });
            }
        });

        $("#btn_search").click(function (){
            $.ajax({
                type: "get",
                async: false,
                url: "/GetNecessaryTask",
                data: {
                    year1: $("#year1").val(),
                    year2:$("#year2").val(),
                    semester:$("#terminal").val().match(/\d+/g),
                    unit:null
                },//传递学院名称
                success: function (result) {

                    if(result == -1)
                        alert('无记录');
                    else{
                        $('.type_tit2').html($("#calender").val()+" 关注课程列表");
                        result = JSON.parse(result);
                        console.log(result);
                        $("#table").bootstrapTable('load',result);

                        $("#table").bootstrapTable({
                            data:result
                        });
                    }
                }
            });
        });
    }

    if($('#getlevel').val() == '小组长'||$('#getlevel').val() == '督导')
    {
        $.ajax({
            type: "get",
            async: false,
            url: "/GetNecessaryTask",
            data: {
                year1: $("#year1").val(),
                year2:$("#year2").val(),
                semester:$("#terminal").val().match(/\d+/g),
                group:$('#getgroup').val()
            },//传递学院名称
            success: function (result) {
                result = JSON.parse(result);
                //console.log(result);
                $("#table").bootstrapTable('load',result);

                $("#table").bootstrapTable({
                    data:result
                });
            }
        });

        $("#btn_search").click(function (){
            $.ajax({
                type: "get",
                async: false,
                url: "/GetNecessaryTask",
                data: {year1: $("#year1").val(),year2:$("#year2").val(),semester:$("#terminal").val().match(/\d+/g),unit:$('#getgroup').val()},//传递学院名称
                success: function (result) {
                    if(result == -1)
                        alert('无记录');
                    else{
                        $('.type_tit2').html($("#calender").val()+" 关注课程统计表");

                        result = JSON.parse(result);
                        $("#table").bootstrapTable('load',result);

                        //console.log(result);
                        $("#table").bootstrapTable({
                            data:result
                        });
                    }

                }
            });
        });
    }


    $("#btn_delete").click(function(){

        var ids = $.map($("#table").bootstrapTable('getSelections'),function(row){//获取选中的行
            //console.log(row);
            var obj = {
                lesson_name:row.lesson_name,
                lesson_teacher_name:row.lesson_teacher_name,
                lesson_teacher_unit:row.lesson_teacher_unit
            };
            return obj;
        });

        //console.log(ids);
        //后台删除
       $.ajax({
            type: "post",
            async: false,
            url: "/DeleteNecessaryTask",
            data: {
                '_token':csrf_token,
                year1: $("#year1").val(),
                year2:$("#year2").val(),
                semester:$("#terminal").val().match(/\d+/g)[0],
                dataArr:ids
            },//传递学院名称
            success: function (result) {
                alert(result);
                if (result.indexOf('删除成功') >=0 )
                {
                    window.location.reload();
                }
            }
        });

    });

    $("#sure").click(function(){
        if($('#SelectFile').val()!='')
        {
            var filename = $('#SelectFile').val().split("\\")[2];
            document.getElementById('myform').action="/excel/NecessaryTaskImport?filename="+filename;
            document.getElementById('myform').submit();
        }
        else{
            alert('未选择文件');
        }
    });
//清除输入框
    $('.icon-remove').click(function(){
        SearchValue.value=null;
    });

    $('#dui').click(function (){
        lesson = SearchValue.value.split("_")[0];
        teacher = SearchValue.value.split("_")[1];
        $.ajax({
            type: "get",
            async: false,
            url: "/AddNecessaryTask",
            data: {
                year1: $("#year1").val(),
                year2:$("#year2").val(),
                semester:$("#terminal").val().match(/\d+/g),
                lesson:lesson,
                teacher:teacher,
                group:$("#group").val(),
                reason:$("#reason").val()
            },//传递学院名称
            success: function (result) {
                alert(result);
                if (result.indexOf("添加成功")>=0 )
                {
                    window.location.reload();
                }
            }
        });
    });
    myyear = $("#year1").val()+'-'+$("#year2").val();

    $("#btn_export").click(function(){
        window.open(getRootPath()+"/excel/NecessaryTaskExport?year="+myyear+"&semester="+$("#terminal").val().match(/\d/g));
    })
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
