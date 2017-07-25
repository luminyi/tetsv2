<!DOCTYPE html>
<meta name="render" content="webkit|ie-comp|ie-stand">
<meta http-equiv="X-UA-Compatible" content="IE=11">
<html lang="en">
<style type="text/css">
    *{font-family:"Microsoft YaHei"}
    .nav_a{
        cursor: pointer;
    }
    .panel-add{
        color: #fff;
        background-color: #97d3c5 !important;
        border-color: #97d3c5 !important;
    }
    .panel-red{
        color: #fff;
        background-color: #f68484 !important;
        border-color: #f68484 !important;
    }
    .select{
        height: 34px;
        vertical-align: middle;
        border:1px solid #ccc;
        border-radius: 4px;
    }
    #search-suggest{
        position: absolute;
        display: none;
        /*z-index: 100;*/
    }
    .suggest{
        width:165px;
        background-color: white;
        /*border: 1px solid #999;*/
        border-radius:4px;
        left:805px;
        top: 142px;
    }
    .suggestClass{
        width:208px;
        background-color: white;
        /*border: 1px solid #999;*/
        border-radius:4px;
        z-index: 99;
        margin-left: -256px;
        margin-top: -36px;
    }
    .suggest ul,.suggestClass ul
    {
        list-style: none;
        margin: 0;
        padding: 0;
    }
    .suggest ul li,.suggestClass ul li{
        padding:3px;
        font-size: 14px;
        line-height: 25px;
        cursor: pointer;
    }
    .suggest ul li:hover,.suggestClass ul li:hover{
        text-decoration: underline;
        background-color: grey;
    }
    #newmain{
        overflow: auto;float: left;margin-left:2%;width: 1660px;
    }
    @media screen and (max-width: 768px){
        #newmain{
            overflow: auto;float: left;
            margin-left:38%;width: 1660px;
        }
    }
    @media screen and (max-width: 415px) {
        #newmain{
            overflow: auto;float: left;
            margin-left:91%;width: 1660px;
        }
    }
</style>
<head>
    <meta charset="utf-8" />
    <title>北京林业大学督导评价管理系统</title>
    <meta name="keywords" content="北京林业大学督导评价管理系统"/>
    <meta name="description" content="北京林业大学督导评价管理系统"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <!-- basic styles -->
    <link href="assets/css/bootstrap.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="assets/css/font-awesome.min.css" />
    <link rel="stylesheet" href="assets/css/dashboard.css" />
    <link rel="stylesheet" href="assets/css/common.css" />
    <link rel="stylesheet" href="assets/css/main.css" />
    <!--[if IE 7]>
    <link rel="stylesheet" href="assets/css/font-awesome-ie7.min.css" />
    <![endif]-->

    <!--[if lt IE 9]>
    <script src="assets/js/html5shiv.js"></script>
    <script src="assets/js/respond.min.js"></script>
    <![endif]-->
    <script src="assets/js/jquery-2.0.3.min.js"></script>
    <script src="assets/js/bootstrap.min.js"></script>
    {{--日历相关--}}
    <link rel="stylesheet" type="text/css" href="calendar/DateTimePicker.css" />
    <script type="text/javascript" src="calendar/jquery-1.11.0.min.js"></script>
    <link rel="stylesheet" type="text/css" href="calendar/DateTimePicker-ltie9.css" />
    <script type="text/javascript" src="calendar/DateTimePicker-ltie9.js"></script>

</head>

<body>
@include('layout.header')
@include('layout.sidebar')
<div id="newmain" class="container-fluid clearfix">
    <div class="row clearfix">

        <div class="col-sm-10 col-sm-offset-2 col-md-10 col-md-offset-2 ">
            {{--<!-- .breadcrumb -->--}}
            <div class="breadcrumbs" id="breadcrumbs">
                <ul class="breadcrumb" style="padding-top: 22px; padding-bottom: 12px;">
                    {{--<li>--}}
                        {{--<i class="icon-home home-icon"></i>--}}
                        {{--<a style="color: #225081;" href="#">评价管理</a>--}}
                    {{--</li>--}}
                    {{--<li style="color:gray">督导听课数据统计</li>--}}
                </ul>
            </div>
            {{--<!-- .breadcrumb -->--}}
            <div class="page-content form-content">
                <div class="Statistics-Table">
                    {{--选择条件--}}
                    <p style="display: inline-block;margin-left: 10px;">学期学年</p><input id="calender" class="select" type="text" data-field="date" readonly>
                    <span  style="display: inline-block;">课程种类</span>
                    <select class="form-control" name="lesson" id="lesson"  style="width:200px;display: inline-block;margin-left:10px;">
                        <option>理论课</option>
                        <option>实践课</option>
                        <option>体育课</option>
                    </select>
                    <span  style="display: inline-block;">总体评价</span>
                    <select class="form-control" name="lesson" id="lesson"  style="width:200px;display: inline-block;margin-left:10px;">
                        <option>授课总体评价</option>
                        <option>听课总体评价</option>
                    </select>
                    <button class="btn btn-warning" id="draw" style="margin-left:10px;">绘制</button>
                    <div id="main1" style="width: 100%; height:650px;"></div>

                </div>

                <div id="dtBox" class="dtpicker-overlay dtpicker-mobile" style="display: none;">
                    <div class="dtpicker-bg">
                        <div class="dtpicker-cont">
                            <div class="dtpicker-content" style="margin-left: 266px;">
                                <div class="dtpicker-subcontent">

                                    <div class="dtpicker-header">
                                        <div class="dtpicker-title">选择学期</div>
                                        <a class="dtpicker-close">×</a>
                                        <!--<div class="dtpicker-value"></div>-->
                                    </div>


                                    <div class="dtpicker-components">
                                        <div class="dtpicker-compOutline dtpicker-comp3">
                                            <div class="dtpicker-comp year1_class">
                                                <a id="year1_class1" class="dtpicker-compButton increment">+</a>
                                                <input id="year1" type="text" class="dtpicker-compValue" maxlength="4">
                                                <a id="year1_class2" class="dtpicker-compButton decrement">-</a>
                                            </div>
                                        </div>

                                        <div class="dtpicker-compOutline dtpicker-comp3">
                                            <div class="dtpicker-comp ">
                                                <a class="dtpicker-compButton increment "></a>
                                                <input type="text" class="dtpicker-compValue" id="year2" disabled="disabled">
                                                <a class="dtpicker-compButton decrement "></a>
                                            </div>
                                        </div>

                                        <div class="dtpicker-compOutline dtpicker-comp3">
                                            <div class="dtpicker-comp ">
                                                <a class="dtpicker-compButton increment dtpicker-compButtonEnable">+</a>
                                                <input type="text" class="dtpicker-compValue" id="terminal" disabled="disabled">
                                                <a class="dtpicker-compButton decrement dtpicker-compButtonEnable">-</a>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="dtpicker-buttonCont dtpicker-twoButtons">
                                        <a class="dtpicker-button dtpicker-buttonSet">确定</a>
                                        <a class="dtpicker-button dtpicker-buttonClear">取消</a>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>




                {{--<p style="display: inline-block;">学期学年</p><input id="calender" class="select" type="text" data-field="date" readonly>--}}
                {{--<div style="display: inline-block;margin-left:20px;">--}}
                {{--<span  style="display: inline-block;">课程名称</span>--}}
                {{--<input type="text" class="form-control" id="LessonName" style="width:200px;display: inline-block;margin-left:10px;">--}}
                {{--<div class="suggestClass" id="Lesson-suggest">--}}
                {{--<ul id="Lesson_result">--}}

                {{--</ul>--}}
                {{--</div>--}}
                {{--</div>--}}
                {{--<span style="display: inline-block; margin-left:20px;">授课教师</span>--}}
                {{--<input type="text" class="form-control" id="Teacher" readonly="readonly" style="width:200px;display: inline-block;margin-left:10px;">--}}
                {{--<button class="btn btn-warning" id="draw" style="margin-left:10px;">绘制</button>--}}

            </div>
        </div>

    </div>
</div>

@include('layout.footer')
</body>

<script src="assets/js/echarts.min.js"></script>
{{--<script src="assets/js/vintage.js"></script>--}}
<script src="{{asset('js/DataStatistics.js')}}"></script>


</html>
