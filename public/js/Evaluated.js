/**
 * Created by computer on 2016/7/12.
 */

var MyDate = new Date();
var CurrentYear = MyDate.getFullYear();
var terminal=null;

if ( (MyDate.getMonth()+1) <8 && (MyDate.getMonth()+1) >= 3)
{
    terminal="第2学期";
    year1 = parseInt(CurrentYear)-1;
    year2 = parseInt(CurrentYear);
}
else
{
    terminal="第1学期";

    if (MyDate.getMonth()+1 < 3)
    {
       year1=parseInt(CurrentYear)-1;
        year2=parseInt(CurrentYear);
    }
    if(MyDate.getMonth()+1 >= 8)
    {
        year1=parseInt(CurrentYear);
        year2=parseInt(CurrentYear)+1;
    }
}
semester=terminal.match(/\d+/g);

if(MyDate.getMonth() + 1<10)
    evaluationTime=MyDate.getFullYear()+'-0'+(MyDate.getMonth() + 1)+'-'+MyDate.getDate();
else
    evaluationTime=MyDate.getFullYear()+'-'+(MyDate.getMonth() + 1)+'-'+MyDate.getDate();

$(document).ready(function() {
    $('.group-menu').addClass('active');
    var level = $('#getlevel').val();
    var unit = $('#getunit').val();
    var group = $('#getgroup').val();
    if (level != '校级' && level != '大组长')
    {
        if (level == '院级')
        {
            //$.ajax({
            //    type: "get",
            //    async: false,
            //    url: "/UnitSaved",
            //    data: {year1:year1,year2:year2,semester:terminal,unit:unit},
            //    success: function (result) {
            //        result = JSON.parse(result);
            //        //console.log(result);
            //        $("#saved").bootstrapTable('load',result);
            //    }
            //});
            //已听课程完成情况
            $.ajax({
                type: "get",
                async: false,
                url: "/UnitEvaluated",
                data: {year1:year1,year2:year2,semester:terminal,unit:unit},
                success: function (result) {
                    result = JSON.parse(result);
                    //console.log(result);
                    $("#finished").bootstrapTable('load',result);
                }
            });

            //未听课程完成情况
            //$.ajax({
            //    type: "get",
            //    async: false,
            //    url: "/UnitUnEvaluated",
            //    data: {year1:year1,year2:year2,semester:terminal,unit:unit},//传递学院名称
            //    success: function (result) {
            //        result = JSON.parse(result);
            //        $("#unfinished").bootstrapTable('load',result);
            //    }
            //});

            $('.evaluated-menu').addClass('active');

            $.ajax({
                type:"GET",
                url:"/UnitNecessaryState",
                data:{unit:unit},
                success:function(result){
                    $(window).resize(function (){
                        create_pie(result);
                    });
                    create_pie(result);
                }});

            $('.fixed-table-loading').hide();
        }
        if(level == '小组长')
        {
            //已听课程待提交情况
            $.ajax({
                type: "get",
                async: false,
                url: "/GroupSaved",
                data: {year1:year1,year2:year2,semester:semester,group:group},
                success: function (result) {
                    result = JSON.parse(result);
                    console.log(result);
                    $("#saved").bootstrapTable('load',result);
                }
            });
            //已听课程完成情况
            $.ajax({
                type: "get",
                async: false,
                url: "/GroupEvaluated",
                data: {year1:year1,year2:year2,semester:semester,group:group},
                success: function (result) {
                    result = JSON.parse(result);
                    //console.log(result);
                    $("#finished").bootstrapTable('load',result);
                }
            });

            //未听课程完成情况
            $.ajax({
                type: "get",
                async: false,
                url: "/GroupUnEvaluated",
                data: {year1:year1,year2:year2,semester:semester,group:group},//传递学院名称
                success: function (result) {
                    result = JSON.parse(result);
                    //console.log(result);

                    $("#unfinished").bootstrapTable('load',result);
                }
            });

            $('.evaluated-menu').addClass('active');

            $.ajax({
                type:"GET",
                url:"/GroupNecessaryState",
                data:{group:group, evaluationTime:evaluationTime},
                success:function(result){
                    $(window).resize(function (){
                        create_pie(result);
                    });
                    create_pie(result);
                }});

            $('.fixed-table-loading').hide();
        }
    }
    else//校级
    {
        //已听课程完成情况
        $.ajax({
            type: "get",
            async: false,
            url: "/Evaluated",
            data: {year1:year1,year2:year2,semester:semester},
            success: function (result) {
                result = JSON.parse(result);
                //console.log(result);
                $("#finished").bootstrapTable('load',result);
            }
        });
        //已听课程待提交情况
        $.ajax({
            type: "get",
            async: false,
            url: "/Saved",
            data: {year1:year1,year2:year2,semester:semester},
            success: function (result) {
                result = JSON.parse(result);
                //console.log(result);
                $("#saved").bootstrapTable('load',result);
            }
        });

        //未听课程完成情况
        $.ajax({
            type: "get",
            async: false,
            url: "/UnEvaluated",
            data: {year1:year1,year2:year2,semester:semester},//传递学院名称
            success: function (result) {
                result = JSON.parse(result);
                $("#unfinished").bootstrapTable('load',result);
            }
        });

        $('.evaluated-menu').addClass('active');

        $.ajax({
            type:"GET",
            url:"/NecessaryState",
            success:function(result){
                $(window).resize(function (){
                    create_pie(result);
                });
                create_pie(result);
            }});

        $('.fixed-table-loading').hide();
    }

});


function create_pie( result)
{
    //    var myChart = echarts.init(document.getElementById('main'),'vintage');
    var myChart = echarts.init(document.getElementById('main'));
    // 指定图表的配置项和数据
    var  option = {
        title : {
            // text:Get_CurrentYear(CurrentYear),
            // x:'15%',
            // y:'4%'
        },
        tooltip : {
            trigger: 'item',
            formatter: "{a} <br/>{b} : {c} ({d}%)"
        },
        color:['#C23531','#2F4554','#91C7AE'],
        series : [
            {
                name: '完成情况',
                type: 'pie',
                radius : '60%',
                center: ['46%', '46%'],
                data:[
                    {value:result.Undo, name:'未完成'},
                    {value:result.Save, name:'待提交'},
                    {value:result.Do, name:'已完成'}
                ],
                itemStyle: {
                    emphasis: {
                        shadowBlur: 10,
                        shadowOffsetX: 0,
                        shadowColor: 'rgba(0, 0, 0, 0.5)'
                    }
                }
            }
        ]
    };
    // 使用刚指定的配置项和数据显示图表。
    myChart.setOption(option);
    myChart.on('click',function(params){
        if(params.dataIndex===0){//未完成
            $('.DoTitle').hide();
            $('.panel-success').hide();

            $('.UndoTitle').show();
            $('.panel-danger').show();
            $('#Undo').show();

            $('.SaveTitle').hide();
            $('.panel-info').hide();
        }
        else if(params.dataIndex===1)//以保存
        {
            $('.SaveTitle').show();
            $('.panel-info').show();
            $('#Save').show();

            $('.panel-danger').hide();
            $('.UndoTitle').hide();
            $('.DoTitle').hide();
            $('.panel-success').hide();
        }
        else {//已完成

            $('.DoTitle').show();
            $('.panel-success').show();

            $('.UndoTitle').hide();
            $('.panel-danger').hide();

            $('.SaveTitle').hide();
            $('.panel-info').hide();
        }
    });
}


function Get_CurrentYear(CurrentYear)
{
    if ( (MyDate.getMonth()+1) <8 && (MyDate.getMonth()+1) >= 3)
    {
        terminal="第2学期";
        year1 = parseInt(CurrentYear)-1;
        year2 = parseInt(CurrentYear);
    }
    else
    {
        terminal="第1学期";

        if (MyDate.getMonth()+1 < 3)
        {
            year1=parseInt(CurrentYear)-1;
            year2=parseInt(CurrentYear);
        }
        if(MyDate.getMonth()+1 >= 8)
        {
            year1=parseInt(CurrentYear);
            year2=parseInt(CurrentYear)+1;
        }
    }

    var title =year1+"～"+year2+"学年 "+terminal+"听课情况";
    return title;
}
$('.current-year').text(Get_CurrentYear(CurrentYear));