/**
 * Created by computer on 2016/7/12.
 */
function sideBar() //    侧边栏移除活动效果，给当前选中区域添加选中效果
{

    var oli = document.getElementById('sidebar_id').getElementsByTagName("li");
    //顶级导航栏 标签编号：，0 1 4 8 9
    for (var i=0;i<oli.length;i++){
        if( oli[i].className == 'Upper-menu' )
        {
            oli[i].className='';
        }
    }
    //oli[0].className="active";
    // $('#sidebar_id li').eq(0).addClass("active");
}
//校级的饼状图
function PieChart()
{
    var data;
    $.ajax({
        type:"GET",
        url:"/NecessaryState",
        success:function(result){
            data = result;
            var myChart = echarts.init(document.getElementById('main1'));
            var  option =
            {
                title : {
                    x:'center'
                },
                tooltip : {
                    trigger: 'item',
                    formatter: "{a} <br/>{b} : {c} ({d}%)"
                },

                legend: {
                    orient: 'vertical',
                    left: 'left',
                    data: ['未完成','待提交','已完成']
                },
                series : [
                    {
                        name: '评价完成情况',
                        type: 'pie',
                        label:{
                            normal: {
                                position: 'inner'
                            }
                        },
                        radius : '60%',
                        center: ['50%', '60%'],
                        data:[
                            //{value:65, name:'未完成'},
                            //{value:90, name:'已完成'}

                            { value:data.Undo , name:'未完成' },
                            {value:data.Save, name:'待提交'},
                            { value:data.Do , name:'已完成'}
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
        }
    });
}
function BarChart()
{
    var databar=[];
    var name=[];
    $.ajax({
        type: "get",
        async: false,
        url: "/EvaluatedInUnit",
        databar:{},
        name:{},
        success: function (result) {
            // console.log(result);
            for( i=0; i<result.length;i++){
                name[i]=result[i].name;
                databar[i]=result[i].value;
            }
            var myChart = echarts.init(document.getElementById('main3'));
            var option = {
                tooltip : {
                    trigger: 'axis',
                    axisPointer : {            // 坐标轴指示器，坐标轴触发有效
                        type : 'shadow'        // 默认为直线，可选为：'line' | 'shadow'
                    }
                },
                legend: {
                    data:['已完成']
                },
                grid: {
                    left: '3%',
                    right: '4%',
                    top:'5%',
                    bottom: '6%',
                    containLabel: true
                },
                xAxis : [
                    {
                        type : 'category',
                        splitLine: {
                            interval:0
                        },
                        axisLabel: {
                            formatter:function(val){
                                return val.split("").join("\n");
                            }
                        },
                        data :name
                    }
                ],
                yAxis : [
                    {
                        type : 'value'
                    }
                ],
                series : [
                    {
                        name:'已完成',
                        type:'bar',
                        data:databar
                    }
                ]
            };
            myChart.setOption(option);
        }
    });
}
function Full_PartNum(level,unit,evaluationTime)
{
    var data;
    $.ajax({
        type:"GET",
        url:"/TimeSupervisorNumber",
        data:{
            level:level,
            unit:unit,
            evaluationTime:evaluationTime
        },
        success:function(result){
            data = result;
            var myChart = echarts.init(document.getElementById('main4'));
            var  option =
            {
                title : {
                    x:'center'
                },
                tooltip : {
                    trigger: 'item',
                    formatter: "{a} <br/>{b} : {c} ({d}%)"
                },
                legend: {
                    orient: 'vertical',
                    left: 'left',
                    data: ['未完成','已完成']
                },
                series : [
                    {
                        name: '督导类型占比情况',
                        type: 'pie',
                        radius : '80%',
                        center: ['50%', '50%'],
                        label:{
                            normal: {
                                position: 'inner'
                            }
                        },
                        data:[
                            { value:data.P , name:'兼职督导人数'},
                            { value:data.F , name:'专职督导人数'}
                        ],
                        itemStyle:
                        {
                            normal:{
                                label:{
                                    show: true,
                                    //formatter: '{b} : {c} '
                                },
                                labelLine :{show:true}
                            },
                            emphasis:
                            {
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
        }
    });
}
//院级的饼状图
function PieChartUnit(unit, evaluationTime)
{
    var data;
    $.ajax({
        type:"GET",
        url:"/UnitNecessaryState",
        data:{
            unit:unit,
            evaluationTime:evaluationTime
        },
        success:function(result){
            data = result;
            var myChart = echarts.init(document.getElementById('main1'));
            var  option =
            {
                title : {
                    x:'center'
                },
                tooltip : {
                    trigger: 'item',
                    formatter: "{a} <br/>{b} : {c} ({d}%)"
                },
                legend: {
                    orient: 'vertical',
                    left: 'left',
                    data: ['未完成','待提交','已完成']
                },
                series : [
                    {
                        name: '评价完成情况',
                        type: 'pie',
                        radius : '55%',
                        center: ['50%', '60%'],
                        data:[
                            //{value:65, name:'未完成'},
                            //{value:90, name:'已完成'}
                            { value:data.Undo , name:'未完成' },
                            {value:data.Save, name:'待提交'},
                            { value:data.Do , name:'已完成'}
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
        }
    });
}
function PieChartGroup(group, evaluationTime)
{
    var data;
    $.ajax({
        type:"GET",
        url:"/GroupNecessaryState",
        data:{
            group:group,
            evaluationTime:evaluationTime
        },
        success:function(result){
            data = result;
            var myChart = echarts.init(document.getElementById('main1'));
            var  option =
            {
                title : {
                    x:'center'
                },
                tooltip : {
                    trigger: 'item',
                    formatter: "{a} <br/>{b} : {c} ({d}%)"
                },
                legend: {
                    orient: 'vertical',
                    left: 'left',
                    data: ['未完成','待提交','已完成']
                },
                series : [
                    {
                        name: '评价完成情况',
                        type: 'pie',
                        radius : '55%',
                        center: ['50%', '60%'],
                        data:[
                            //{value:65, name:'未完成'},
                            //{value:90, name:'已完成'}
                            { value:data.Undo , name:'未完成' },
                            {value:data.Save, name:'待提交'},
                            { value:data.Do , name:'已完成'}
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
        }
    });
}


$(document).ready(function() {

    sideBar();
    //院级登录时获取
    var level = $('#getlevel').val();
    var unit = $('#getunit').val();
    var group = $('#getgroup').val();
    var myDate = new Date();
    if(myDate.getMonth() + 1<10)
        evaluationTime=myDate.getFullYear()+'-0'+(myDate.getMonth() + 1)+'-'+myDate.getDate();
    else
        evaluationTime=myDate.getFullYear()+'-'+(myDate.getMonth() + 1)+'-'+myDate.getDate();

    if (level != '校级' && level != '大组长')
    {

        if (level == '院级')
        {
            $.ajax({
                type:"GET",
                url:"/GetUnitNewList",
                data:{unit:unit,evaluationTime:evaluationTime},
                success:function(result){
                    for(var i=0;i<result.length;i++)
                    {
                        //console.log(result[i]);
                        //var temp='<tr><td>'+result[i]['督导姓名']+'</td>';
                        var temp='<tr><td>***</td>';
                        temp+='<td>'+result[i]['课程名称']+'</td>';
                        temp+='<td>'+result[i]['听课时间']+'</td></tr>';
                        $('.evaluate').append(temp);
                    }
                }
            });
            //1、获取本学院的督导人数
            //2、获取本学院的本学期必听课程
            //3、获取本学院的本学期已完成评价的必听课程
            //4、获取本学院的本学期已完成评价的课程
            $.ajax({
                type: "get",
                async: false,
                url: "/Unitindex",
                data:{unit:unit,evaluationTime:evaluationTime},
                success: function (result) {
                    $(".so_num").html(result['SupervisorNum']);
                    $(".nec_num").html(result['NecessaryTask']);
                    $(".FineshedNecess").html(result['FinishedNecess']);
                    $(".Fineshed").html(result['Finished']);
                }
            });
            PieChartUnit(unit, evaluationTime);
        }
        if (level == '小组长')
        {
            $.ajax({
                type:"GET",
                url:"/GetGroupNewList",
                data:{group:group,evaluationTime:evaluationTime},
                success:function(result){
                    for(var i=0;i<result.length;i++)
                    {
                        //console.log(result[i]);
                        var temp='<tr><td>'+result[i]['督导姓名']+'</td>';
                        temp+='<td>'+result[i]['课程名称']+'</td>';
                        temp+='<td>'+result[i]['听课时间']+'</td></tr>';
                        $('.evaluate').append(temp);
                    }
                }
            });

            $.ajax({
                type: "get",
                async: false,
                url: "/Groupindex",
                data:{group:group,evaluationTime:evaluationTime},
                success: function (result) {
                    $(".group_num").html(result['SupervisorNum']);
                    $(".group_nece_num").html(result['NecessaryTask']);
                    $(".group_FineshedNecess").html(result['FinishedNecess']);
                    $(".group_Fineshed").html(result['Finished']);
                }
            });
            PieChartGroup(group, evaluationTime);

            $(window).resize(function (){
                PieChartGroup(group, evaluationTime);
            })
        }

    }
    else {//校级and 大组长
        PieChart();
        //获取柱状图所需要的数据
        BarChart();

        $.ajax({
            type:"GET",
            url:"/GetNewList",
            data:{evaluationTime:evaluationTime},
            success:function(result){
                for(var i=0;i<result.length;i++)
                {
                    var temp='<tr><td>'+result[i]['督导姓名']+'</td>';
                    temp+='<td>'+result[i]['课程名称']+'</td>';
                    temp+='<td>'+result[i]['听课时间']+'</td></tr>';
                    $('.evaluate').append(temp);
                }
            }
        });

        $.ajax({
            type: "get",
            async: false,
            url: "/Schoolindex",
            data:{evaluationTime:evaluationTime},
            success: function (result) {
                //console.log(result);
                $(".so_num").html(result['SupervisorNum']);
                $(".nec_num").html(result['NecessaryTask']);
                $(".FineshedNecess").html(result['FinishedNecess']);
                $(".Fineshed").html(result['Finished']);
            }
        });

        $(window).resize(function (){
            BarChart();
            PieChart();
        })
    }

    if (level == '校级' || level == '大组长')
    {
        $(window).resize(function (){
            Full_PartNum(level,null,evaluationTime);
        });
        Full_PartNum(level,null,evaluationTime);
    }
    if (level == '小组长')
    {
        $(window).resize(function (){
            Full_PartNum(level,group,evaluationTime);
        });
        Full_PartNum(level,group,evaluationTime);
    }
    if (level == '院级')
    {
        $(window).resize(function (){
            Full_PartNum(level,unit,evaluationTime);
        });
        Full_PartNum(level,unit,evaluationTime);
    }
});
