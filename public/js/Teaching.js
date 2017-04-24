/**
 * Created by computer on 2016/7/12.
 * 1、时间
 * 2、授课教师所属院系，姓名
 * 3、课程编号、课程名称、评价督导编号、姓名
 */
var partment=[
    '林学院','水土保持学院'
    ,'生物科技与技术学院','园林学院'
    ,'经济管理学院','工学院'
    ,'理学院','信息学院'
    ,'人文社会科学学院','外语学院'
    ,'材料科学与技术学院','自然保护区学院'
    ,'环境科学工程学院','艺术设计学院','图书馆'];

var MyDate = new Date();
var CurrentYear = MyDate.getFullYear();

var dashboard_row=0;//记录行
var dashboard_col=0;
var dashboard_index=0;

var department=null;
var yijizhibiao=null;
var erjizhibiao = null;

$(document).ready(function()
{
    $('.Teacher-Table').hide();
    Dashboard_Click(dashboard_row,dashboard_col);
    SideBar_function();
    Calendat_function();
    //search_layer();
    $('input[name="chkId"]').iCheck({
        checkboxClass: 'icheckbox_flat-red',
        radioClass: 'iradio_flat-red'
    });
    $('input[name="chkAll"]').iCheck({
        checkboxClass: 'icheckbox_flat-red',
        radioClass: 'iradio_flat-red'
    });

//    教师课表
    $('.input1').focus(
        function(){
            if($('.input1').val()=='')
            {
                $('.box_classify').css("display","block");
                search_ajax();
            }
            else{
                $('.box_classify').css("display","none");
            }
        }
    );

//督导选择框的确定事件
    var SuperVisorArray = [];
    //全选输入框被选中了
    $('input[name="chkAll"]').on('ifChecked',function(event){
        $('input').iCheck('check');
        $('#remove').attr('active');
    });
    //全选输入被取消
    $('input[name="chkAll"]').on('ifUnchecked',function(event){
        $('input').iCheck('uncheck');

    });

    $('.detail').click(function(){
        var course_id=$(this).parent().prevAll().eq(4).text();//获取评价课程id
        var Supervisor_name=$(this).parent().prevAll().eq(0).text();//获取评价课程id

        alert(course_id);
        $.ajax({
            type:"GET",
            url:"/treeDetail",
            data:{tree_name:tree,year:year},
            success:function(result){
                var temp='';
                for(var i=0;i<result.length;i++)
                {
                    temp+="<tr>";
                    for(var j=0;j<result[i].length;j++)
                    {
                        temp+="<td>"+result[i][j]+"</td>";
                    }
                    temp+="</tr>";
                }
                $('.table_detail2 tbody').children().remove();
                $('.table_detail2 tbody').append(temp);
            }
        });
    });

});
function AddTask_board(p)
{
    var lesson_info = p.parentNode.firstChild.innerHTML;
    $("#add").click();
    //alert(lesson_info);
}
function Dashboard_Click(dashboard_row,dashboard_col)
{

    function get_DashIndex(dashboard_row,dashboard_col)
    {
        if (dashboard_row==0 )
            dashboard_index = dashboard_col;
        else {
            dashboard_index = dashboard_col + (dashboard_row-1) * 4 + 3;
        }
        return dashboard_index;
    }

    //注意事件冒泡
    $(".page-content .aa").click(function () {
        department = $(this).text();
        dashboard_col = $(this).index();

    });

    $(".page-content .clearfix").click(function(){
        dashboard_row=$(this).index();
        get_DashIndex(dashboard_row,dashboard_col);

        $(".page-content").hide();
        $('.Teacher-Table').show();
        $.ajax({
            type: "get",
            async: false,
            url: "/teacherLesson",
            data: {name: department},//传递学院名称
            success: function (result) {

            }

        });
    });

}

function SideBar_function()
{
    //    侧边栏移除活动效果，给当前选中区域添加选中效果
    var oli = document.getElementById('sidebar_id').getElementsByTagName("li");
    //顶级导航栏 标签编号：，0 1 4 8 9
    for (var i=0;i<oli.length;i++){
        if( oli[i].className == 'Upper_menu' )
        {
            oli[i].className='';
        }
    }
    oli[4].className="active";
    oli[4].getElementsByTagName("a")[0].className="nav-header";
    oli[4].getElementsByTagName("ul")[0].className="nav nav-list in";

}

function Calendat_function()
{
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
        $("#year2").val(CurrentYear+1);
    });
    //year1 - 按钮
    $("#year1_class2").click(function(){
        CurrentYear--;
        $("#year1").val(CurrentYear);
        $("#year2").val(CurrentYear+1);
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
                if ( parseInt(CurrentYear)>=2050 ||  parseInt(CurrentYear)<=1970 || CurrentYear.match(/^\d{4}$/) == null)
                {
                    alert("请输入正确的4位数字！有效范围为1970～2050");
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

function search_ajax(){//搜索框用的ajax函数

    //需要从数据库中获取每个老师的首字母，做为二级指标，首字母；一级指标：学院
    department=department.replace(/(^\s*)|(\s*$)/g, "");//正则表达式去除字符串两端空格
    $('.box_classify').css("display","block");
    $('.box_down_cate').children().remove();
    $('.box_down').children().remove();

    $('.water').removeClass('active1');
    $('.water').eq(dashboard_index).addClass('active1');//刚刚进入任务添加页面时候搜索框展示的学院

    yijizhibiao=partment[$(this).index()];
    //search_small_ajax();
    $('.water').hover(
        function(){
            $('.water').removeClass('active1');
            $(this).addClass('active1');
            yijizhibiao=partment[$(this).index()];
            $('.box_down_cate').children().remove();
            $('.box_down').children().remove();
            //search_small_ajax();
        });
}

function search_small_ajax(){
    $.ajax({ //搜索框最二级指标
        type: "get",
        async: false,
        url: "",
        data:{station_name: yijizhibiao},
        success: function (result) {
            for(var i=0;i<result.length;i++)
            {
                $('.box_down_cate').append("<div class='cate2_cont' onmouseover='erjizhibiao_hover(this)'>"+result[i]+"</div>");
            }
            $('.cate2_cont').eq(0).addClass('active2');
        }
    });
    erjizhibiao=$('.active2').text();
    $.ajax({//搜索框最小指标
        type: "get",
        async: false,
        url: "",
        data:{station_name:yijizhibiao,category_name:erjizhibiao},
        success: function (result) {
            for(var i=0;i<result.length;i++)
            {
                $('.box_down').append("<div class='index_detail' onclick='ok(this)'>"+result[i]+"</div>");
            }
        }
    });
}
function ok(obj)
{
    $('.input1').val($(obj).text());
    yijizhibiao=partment[$(this).index()];
    $('.box_classify').css("display","none");
}

function erjizhibiao_hover(obj){
    //二级指标的鼠标移动
    department=partment[$(this).index()];
    $('.cate2_cont').removeClass('active2');
    $(obj).addClass('active2');
    yijizhibiao=partment[$(this).index()];
    $('.box_down').children().remove();
    erjizhibiao=$('.active2').text();
    $.ajax({//搜索框最小指标
        type: "get",
        async: false,
        url: "",
        data:{station_name:yijizhibiao,category_name:erjizhibiao},
        success: function (result) {
            for(var i=0;i<result.length;i++)
            {
                $('.box_down').append("<div class='index_detail' onclick='ok(this)'>"+result[i]+"</div>");
            }
        }
    });
}

function search_layer(){

    $.ajax({ //搜索框1级指标
        type: "get",
        async: false,
        url: "",
        data:{station_name: department},
        success: function (result) {
            erjizhibiao=result[0];
        }});
    $.ajax({ //搜索框最小指标
        type: "get",
        async: false,
        url: "",
        data:{station_name:yijizhibiao,category_name:erjizhibiao},
        success: function (result) {
            indexXiao=result[0];
            $('.input1').val(result[0]);
        }
    });
}
