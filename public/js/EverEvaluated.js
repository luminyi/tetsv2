/**
 * Created by computer on 2016/7/12.
 */
var MyDate = new Date();
var CurrentYear = MyDate.getFullYear();
var SearchValue=document.getElementById('name');
var GroupValue=document.getElementById('groupName');

var terminal = null;

var level = $('#getlevel').val();
var unit = $('#getunit').val();
var group = $('#getgroup').val();
var name = $('#getname').val();





$(document).ready(function() {
    $('.evaluated-menu').addClass('active');
    $('.college-menu').addClass('active');
    $('.myEvaluation').addClass('active');
    $('.group-menu').addClass('active');
    Calendat_function();

$(".fixed-table-loading").hide();
    //课程已完成的操作
    //缺省值
    if (level != '校级' && level != '大组长')
    {
        if (level == '院级')
        {
            $.ajax({
                type: "get",
                async: false,
                url: "/GetUnitEveryEvaluated",
                data: {year1:$("#year1").val(),year2:$("#year2").val(),semester:$("#terminal").val().match(/\d/g),unit:SearchValue.value},//传递学院名称
                success: function (result) {
                    result = JSON.parse(result);
                    //console.log(result);
                    $("#finished").bootstrapTable('load',result);

                }
            });
        }
        if (level == '小组长')
        {
            $.ajax({
                type: "get",
                async: false,
                url: "/GetGroupEveryEvaluated",
                data: {
                    year1:$("#year1").val(),
                    year2:$("#year2").val(),
                    semester:$("#terminal").val().match(/\d/g),
                    group:group},//传递学院名称
                success: function (result) {
                    result = JSON.parse(result);
                    //console.log(result);
                    $("#finished").bootstrapTable('load',result);

                }
            });
        }
        if (level == '督导')
        {
//督导登录时显示的统计表
            $.ajax({
                type: "get",
                async: false,
                url: "/GetEveryEvaluated",
                data: {
                    year1:$("#year1").val(),
                    year2:$("#year2").val(),
                    semester:$("#terminal").val().match(/\d/g),
                    supervisor:SearchValue.value},//传递学院名称
                success: function (result) {
                    result = JSON.parse(result);
                     //console.log(result);
                    $("#finished").bootstrapTable('load',result);

                }
            });
        }
    }
    else {//校级and 大组长
        $.ajax({
            type: "get",
            async: false,
            url: "/GetAllEveryEvaluated",
            data: {year1:$("#year1").val(),year2:$("#year2").val(),semester:$("#terminal").val().match(/\d/g)},//传递学院名称
            success: function (result) {
                result = JSON.parse(result);
                //console.log(result);
                $("#finished").bootstrapTable('load',result);


            }
        });
    }

    //课程已保存但未提交的操作
    //缺省值
    if (level != '校级' && level != '大组长')
    {
        if (level == '院级')
        {
            $.ajax({
                type: "get",
                async: false,
                url: "/GetUnitEverySaved",
                data: {year1:$("#year1").val(),year2:$("#year2").val(),semester:$("#terminal").val().match(/\d/g),unit:SearchValue.value},//传递学院名称
                success: function (result) {
                    result = JSON.parse(result);
                    $("#EverSaved").bootstrapTable('load',result);


                }
            });
        }
        if (level == '小组长')
        {
            $.ajax({
                type: "get",
                async: false,
                url: "/GetGroupEverySaved",
                data: {year1:$("#year1").val(),year2:$("#year2").val(),semester:$("#terminal").val().match(/\d/g),group:group},//传递学院名称
                success: function (result) {
                    result = JSON.parse(result);
                    //console.log(result);
                    $("#EverSaved").bootstrapTable('load',result);

                }
            });
        }
        if (level == '督导')
        {
//督导登录时显示的统计表
            $.ajax({
                type: "get",
                async: false,
                url: "/GetEverySaved",
                data: {year1:$("#year1").val(),year2:$("#year2").val(),semester:$("#terminal").val().match(/\d/g),supervisor:SearchValue.value},//传递学院名称
                success: function (result) {
                    result = JSON.parse(result);
                    $("#EverSaved").bootstrapTable('load',result);
                }
            });
            //督导点击评价详情事件

        }
    }
    else {
        $.ajax({
            type: "get",
            async: false,
            url: "/GetAllEverySaved",
            data: {year1:$("#year1").val(),year2:$("#year2").val(),semester:$("#terminal").val().match(/\d/g)},//传递学院名称
            success: function (result) {
                result = JSON.parse(result);
                //console.log(result);
                //result = JSON.parse(result);
                $("#EverSaved").bootstrapTable('load',result);
            }
        });
    }

    $('#view').click(function (){
        if (level != '校级' && level != '大组长')
        {
            if (level == '院级')
            {
                //完成情况
                $("#finished").bootstrapTable('removeAll');//清除表格数据

                $.ajax({
                    type: "get",
                    async: false,
                    url: "/GetUnitEveryEvaluated",
                    data: {year1:$("#year1").val(),year2:$("#year2").val(),semester:$("#terminal").val().match(/\d/g),unit:unit},//传递学院名称
                    success: function (result) {
                        result = JSON.parse(result);
                        $("#finished").bootstrapTable('load',result);
                        $(".h3").html(SearchValue.value+' 督导课程评价统计表');

                    }
                });
                //保存
                $("#EverSaved").bootstrapTable('removeAll');//清除表格数据

                $.ajax({
                    type: "get",
                    async: false,
                    url: "/GetUnitEverySaved",
                    data: {year1:$("#year1").val(),year2:$("#year2").val(),semester:$("#terminal").val().match(/\d/g),unit:SearchValue.value},//传递学院名称
                    success: function (result) {
                        result = JSON.parse(result);
                        $("#EverSaved").bootstrapTable('load',result);

                    }
                });
            }
            if (level == '小组长')
            {
                if($('#groupName').val()=='' || $('#groupName').val().indexOf('组')>=0)//查询小组
                {
                    $("#finished").bootstrapTable('removeAll');//清除表格数据

                    $.ajax({
                        type: "get",
                        async: false,
                        url: "/GetGroupEveryEvaluated",
                        data: {year1:$("#year1").val(),year2:$("#year2").val(),semester:$("#terminal").val().match(/\d/g),group:group},//传递学院名称
                        success: function (result) {
                            //console.log(result);
                            result = JSON.parse(result);
                            $("#finished").bootstrapTable('load',result);
                            $(".h3").html(group+' 督导课程评价统计表');

                        }
                    });
                    $("#EverSaved").bootstrapTable('removeAll');//清除表格数据
                    $.ajax({
                        type: "get",
                        async: false,
                        url: "/GetGroupEverySaved",
                        data: {year1:$("#year1").val(),year2:$("#year2").val(),semester:$("#terminal").val().match(/\d/g),group:group},//传递学院名称
                        success: function (result) {
                            result = JSON.parse(result);
                            //console.log(result);
                            $("#EverSaved").bootstrapTable('load',result);

                        }
                    });
                }
                else {
                    $("#finished").bootstrapTable('removeAll');//清除表格数据
                    $.ajax({
                        type: "get",
                        async: false,
                        url: "/GetEveryEvaluated",
                        data: {
                            year1:$("#year1").val(),
                            year2:$("#year2").val(),
                            semester:$("#terminal").val().match(/\d/g),
                            supervisor:$('#groupName').val().split(' ')[0].replace(/(^\s+)|(\s+$)/g,"")},//传递学院名称
                        success: function (result) {
                            result = JSON.parse(result);
                            $(".h3").html($('#groupName').val()+'督导课程评价统计表');

                            if (result != -1 || result==null)
                            {
                                $("#finished").bootstrapTable('load',result);
                            }
                            else {
                                $('#name').val('');
                            }
                        }
                    });
                    $("#EverSaved").bootstrapTable('removeAll');//清除表格数据

                    $.ajax({
                        type: "get",
                        async: false,
                        url: "/GetEverySaved",
                        data: {year1:$("#year1").val(),year2:$("#year2").val(),semester:$("#terminal").val().match(/\d/g),supervisor:$('#groupName').val().split(' ')[0].replace(/(^\s+)|(\s+$)/g,"")},//传递学院名称
                        success: function (result) {
                            result = JSON.parse(result);
                            $("#EverSaved").bootstrapTable('load',result);
                        }
                    });
                }

            }
            if (level == '督导')
            {
                //完成
                $("#finished").bootstrapTable('removeAll');//清除表格数据
                $.ajax({
                    type: "get",
                    async: false,
                    url: "/GetEveryEvaluated",
                    data: {year1:$("#year1").val(),year2:$("#year2").val(),semester:$("#terminal").val().match(/\d/g),supervisor:SearchValue.value},//传递学院名称
                    success: function (result) {
                        result = JSON.parse(result);
                        if (result != -1 || result==null)
                        {
                            $("#finished").bootstrapTable('load',result);
                            $(".h3").html(name+'督导课程评价统计表');
                        }
                    }
                });
                //保存
                $("#EverSaved").bootstrapTable('removeAll');//清除表格数据

                $.ajax({
                    type: "get",
                    async: false,
                    url: "/GetEverySaved",
                    data: {year1:$("#year1").val(),year2:$("#year2").val(),semester:$("#terminal").val().match(/\d/g),supervisor:SearchValue.value},//传递学院名称
                    success: function (result) {
                        result = JSON.parse(result);
                        //console.log(result);
                        $("#EverSaved").bootstrapTable('load',result);
                    }
                });
            }
        }
        else {//校级和大组长
            if (SearchValue.value=='')
            {
                //输入框为空时展现所有
                $("#finished").bootstrapTable('removeAll');//清除表格数据
                $.ajax({
                    type: "get",
                    async: false,
                    url: "/GetAllEveryEvaluated",
                    data: {year1:$("#year1").val(),year2:$("#year2").val(),semester:$("#terminal").val().match(/\d/g)},//传递学院名称
                    success: function (result) {
                        //result = JSON.parse(result);
                        result = JSON.parse(result);
                        $("#finished").bootstrapTable('load',result);
                        $(".h3").html('所有督导课程评价统计表');



                    }
                });
                //保存
                $("#EverSaved").bootstrapTable('removeAll');//清除表格数据
                $.ajax({
                    type: "get",
                    async: false,
                    url: "/GetAllEverySaved",
                    data: {year1:$("#year1").val(),year2:$("#year2").val(),semester:$("#terminal").val().match(/\d/g)},//传递学院名称
                    success: function (result) {
                        //result = JSON.parse(result);
                        result = JSON.parse(result);
                        //console.log(result);
                        $("#EverSaved").bootstrapTable('load',result);
                    }
                });
            }
            else
            {

                if(SearchValue.value.indexOf('学院')>=0 || SearchValue.value.indexOf('体育')>=0)
                {
                    //alert(SearchValue.value);
                    $("#finished").bootstrapTable('removeAll');//清除表格数据

                    $.ajax({
                        type: "get",
                        async: false,
                        url: "/GetUnitEveryEvaluated",
                        data: {year1:$("#year1").val(),year2:$("#year2").val(),semester:$("#terminal").val().match(/\d/g),unit:SearchValue.value},//传递学院名称
                        success: function (result) {
                            result = JSON.parse(result);
                            //console.log(result);
                            $("#finished").bootstrapTable('load',result);
                            $(".h3").html(SearchValue.value+' 课程评价统计表');


                        }
                    });

                    //保存
                    $("#EverSaved").bootstrapTable('removeAll');//清除表格数据

                    $.ajax({
                        type: "get",
                        async: false,
                        url: "/GetUnitEverySaved",
                        data: {year1:$("#year1").val(),year2:$("#year2").val(),semester:$("#terminal").val().match(/\d/g),unit:SearchValue.value},//传递学院名称
                        success: function (result) {
                            result = JSON.parse(result);
                            $("#EverSaved").bootstrapTable('load',result);

                        }
                    });

                }
                else if(SearchValue.value.indexOf('组')>=0)
                {
                    $("#finished").bootstrapTable('removeAll');//清除表格数据
                    $.ajax({
                        type: "get",
                        async: false,
                        url: "/GetGroupEveryEvaluated",
                        data: {year1:$("#year1").val(),year2:$("#year2").val(),semester:$("#terminal").val().match(/\d/g),group:SearchValue.value},//传递学院名称
                        success: function (result) {
                            //console.log(result);
                            result = JSON.parse(result);
                            $("#finished").bootstrapTable('load',result);
                            $(".h3").html(SearchValue.value+' 督导课程评价统计表');
                        }
                    });
                    //保存
                    $("#EverSaved").bootstrapTable('removeAll');//清除表格数据

                    $.ajax({
                        type: "get",
                        async: false,
                        url: "/GetGroupEverySaved",
                        data: {year1:$("#year1").val(),year2:$("#year2").val(),semester:$("#terminal").val().match(/\d/g),group:SearchValue.value},//传递学院名称
                        success: function (result) {
                            result = JSON.parse(result);
                            $("#EverSaved").bootstrapTable('load',result);
                        }
                    });

                }
                else {//按督导查询
                    $("#finished").bootstrapTable('removeAll');//清除表格数据
                    $.ajax({
                        type: "get",
                        async: false,
                        url: "/GetEveryEvaluated",
                        data: {year1:$("#year1").val(),year2:$("#year2").val(),semester:$("#terminal").val().match(/\d/g),supervisor:SearchValue.value.split(' ')[0]},//传递学院名称
                        success: function (result) {
                            result = JSON.parse(result);
                            //console.log(result);
                            if (result != -1 || result==null)
                            {
                                $("#finished").bootstrapTable('load',result);
                                $(".h3").html(SearchValue.value+'督导课程评价统计表');
                            }
                        }
                    });

                    //保存
                    //督导登录时显示的统计表
                    $("#EverSaved").bootstrapTable('removeAll');//清除表格数据
                    $.ajax({
                        type: "get",
                        async: false,
                        url: "/GetEverySaved",
                        data: {year1:$("#year1").val(),year2:$("#year2").val(),semester:$("#terminal").val().match(/\d/g),supervisor:SearchValue.value.split(' ')[0]},//传递学院名称
                        success: function (result) {
                            result = JSON.parse(result);
                            // console.log(result);
                            $("#EverSaved").bootstrapTable('load',result);

                        }
                    });
                }

            }
        }
    });


    $('#export').click(function (){
        if (level != '校级' && level != '大组长')
        {
            if (level == '院级')
            {
                myyear=$("#year1").val()+'-'+$("#year2").val();
                window.open(getRootPath()+"/excel/EvaluatedUnitExport?year="+myyear+"&semester="+$("#terminal").val().match(/\d/g)+"&unit="+$('#getunit').val());
            }
            if (level == '小组长')
            {
                myyear=$("#year1").val()+'-'+$("#year2").val();
                window.open(getRootPath()+"/excel/EvaluatedGroupExport?year="+myyear+"&semester="+$("#terminal").val().match(/\d/g)+"&group="+$('#getgroup').val());
            }
            if (level == '督导')
            {
                myyear=$("#year1").val()+'-'+$("#year2").val();
                window.open(getRootPath()+"/excel/EvaluatedPersonExport?year="+myyear+"&semester="+$("#terminal").val().match(/\d/g)+"&superid="+$('#getid').val()+"&supername="+$('#getname').val());
            }
        }
        else {
            myyear=$("#year1").val()+'-'+$("#year2").val();
            window.open(getRootPath()+"/excel/EvaluatedExport?year="+myyear+"&semester="+$("#terminal").val().match(/\d/g));
        }
    });


    //校级输入框的操作事宜

    $('#name').bind('click',function (ev){
        var way = $('#ViewWay').val();
        if (way == '学院')
        {
            $.ajax({
                type: "get",
                async: false,
                url: "/UnitName",
                dataType:'json',
                success: function (result) {
                    //console.log(result);
                    var html='';
                    for (var i=0;i<result.length;i++)
                        html+='<li>'+result[i]['lesson_unit']+'</li>';
                    $('#search_result').html(html);
                    //阻止事件冒泡
                    var oEvent = ev || event;
                    oEvent.stopPropagation();
                    $('#search-suggest').show().css({
                        /*top:$('#name').offset().top+$('#name').height(),
                        left:$('#name').offset().left,*/
                        position:'absolute',
                        height:'150px',
                        overflow:'auto'
                    });
                    $('#search-suggest').offset({top:$('#name').offset().top+$('#name').height()+13,
                        left:$('#name').offset().left});
                }
            });
        }
        if (way == '小组')
        {
            var data = ['第一组','第二组','第三组','第四组'];
            var html='';
            for (var i=0;i<data.length;i++)
                html+='<li>'+data[i]+'</li>';
            $('#search_result').html(html);
            //阻止事件冒泡
            var oEvent = ev || event;
            oEvent.stopPropagation();
            $('#search-suggest').show().css({
                /*top:$('#name').offset().top+$('#name').height(),
                left:$('#name').offset().left,*/
                position:'absolute'
            });
            $('#search-suggest').offset({top:$('#name').offset().top+$('#name').height()+13,
                left:$('#name').offset().left});
        }
        if (way == '督导')
        {
            $.ajax({
                type: "get",
                async: false,
                url: "/GetSupervisorName",
                dataType:'json',
                success: function (result) {
                    var html='';
                    for (var i=0;i<result.length;i++)
                    {
                        if (
                            result[i]['name'].indexOf('组')>=0
                            || result[i]['name'].indexOf('学院') >= 0
                            || result[i]['name'].indexOf('教学负责人') >= 0)
                            i++;
                        else
                            html+='<li>'+result[i]['user_id']+' '+result[i]['name']+'</li>';
                    }

                    $('#search_result').html(html);
                    //阻止事件冒泡
                    var oEvent = ev || event;
                    oEvent.stopPropagation();
                    $('#search-suggest').show().css({
/*                        top:$('#name').offset().top+$('#name').height(),
                        left:$('#name').offset().left,*/
                        position:'absolute',
                        height:'150px',
                        overflow:'auto'
                    });
                    $('#search-suggest').offset({top:$('#name').offset().top+$('#name').height()+13,
                        left:$('#name').offset().left});
                }
            });
        }

        $('#ViewWay').click(function (){
            $('#name').val('');
        });

        $(document).bind('click',function(){
            $('#search-suggest').hide();
        });
        $('#search_result').delegate('li','click',function(){
            SearchValue.value=$(this).text();
        });
    });

    //小组长输入框的操作事宜
    $('#groupName').bind('click',function (ev){

        $.ajax({
            type: "get",
            async: false,
            url: "/GetGroupSupervisorName",
            dataType:'json',
            data:{group:group,year1:$("#year1").val(),year2:$("#year2").val(),semester:$("#terminal").val().match(/\d/g)},
            success: function (result) {
                //console.log(result);

                var groupName_X = $('#groupName').position().left;
                var groupName_Y = $('#groupName').position().top;
                $(window).resize(function (){
                    groupName_X = $('#groupName').position().left;
                    groupName_Y = $('#groupName').position().top;
                });

                var html='';
                for (var i=0;i<result.length;i++)
                    html+='<li>'+result[i]['user_id']+' '+result[i]['name']+'</li>';
                $('#search_result').html(html);
                //阻止事件冒泡
                var oEvent = ev || event;
                oEvent.stopPropagation();
                $('#search-suggest').show().css({
/*                    top:$('#groupName').offset().top+$('#groupName').height(),
                    left:$('#groupName').offset().left,*/
                    position:'absolute'
                });
                $('#search-suggest').offset({top:$('#groupName').offset().top+$('#groupName').height(),
                    left:$('#groupName').offset().left});
            }
        });

        $(document).bind('click',function(){
            $('#search-suggest').hide();
        });
        $('#search_result').delegate('li','click',function(){
            GroupValue.value=$(this).text();
        });
    });
});

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
                //console.log(CurrentYear.match(/^\d{4}$/));
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


