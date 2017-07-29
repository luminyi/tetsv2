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
    .widget-header {
        text-align: center;
        padding-left: 0;
        min-height: 38px;
    }
    .header-color-green {
        background: #75B9E6;
        color: white!important;
    }
    .widget-box-green{
        margin-top:20px;

    }
    .widget-box-red{
        margin-top:20px;
    }
    .header-color-red {
        background: #97D3C5;
        color: white!important;
    }
    .header-color-orange {
        background:#ECA347;
        border-color: #e8b10d;
        color: white!important;
    }
    .widget-body-orange{
        background-color: #FEFDE1;
    }
    .widget-header h5{
        line-height: 36px;
        font-size: 20px;
        margin-top: 0px!important;
        margin-bottom: 0px!important;
        font-weight: bold;
    }
    .widget-body{
        padding: 30px 20px 0 20px;
        height: 393px;
        overflow-y:auto;
    }
    .widget-group-body{
        padding: 30px 20px 0 20px;
        height: 593px;
        overflow-y:auto;
    }
    .widget-body li{
        margin-bottom: 6px;
    }
    .green{
        color: #87B87F;
    }
    .widget-body-red{
        background-color: rgba(167, 208, 198, 0.15);
    }
    .widget-body-blue{
        background-color: rgba(148, 193, 222, 0.14);
    }
    #newmain{
        overflow: auto;margin-left:30px;
    }
    @media screen and (max-width: 768px){
        #newmain{
            overflow: auto;float: left;
            margin-left:40%;width: 1660px;
        }
        #dtpick{
            left: 0%;
            top: 38%;
        }

    }
    @media screen and (max-width: 415px) {
        #newmain{
            overflow: auto;float: left;
            margin-left:70%;width: 1660px;
        }
        #minisize{
            float: none;
        }
        #dtpick{
            top: 20%;
            left: 10%;
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

        <input id="getlevel" value="{{session('role')}}" style="display: none"/>
        <input id="getunit" value="{{Auth::User()->unit}}" style="display: none"/>
        <input id="getgroup" value="{{Auth::User()->group}}" style="display: none"/>

        <div class="col-sm-10 col-sm-offset-2 col-md-10 col-md-offset-2 ">
            <!-- .breadcrumb -->
            <div class="breadcrumbs" id="breadcrumbs">
                <ul class="breadcrumb" style="padding-top: 22px; padding-bottom: 12px;">
                    {{--<li>--}}
                        {{--<i class="icon-home home-icon"></i>--}}
                        {{--<a style="color: #225081;" href="#">评价管理</a>--}}
                    {{--</li>--}}
                    {{--<li style="color:gray">小组听课情况</li>--}}
                </ul>
            </div>
            <!-- .breadcrumb -->
            <div class="page-content form-content">
                <div class="Statistics-Table">
                    {{--选择条件--}}
                    <p style="display: inline-block;margin-left: 10px;">学期学年</p><input id="calender" class="select" type="text" data-field="date" readonly>
                    @if(session('role')=='校级'||session('role')=='大组长' )
                        <button id="export" class="btn btn-back-message-list btn-raised">
                            <i class="glyphicon glyphicon-export"></i> 导出
                        </button>
                    @endif
                </div>

                <div id="dtBox" class="dtpicker-overlay dtpicker-mobile" style="display: none;">
                        <div class="dtpicker-bg">
                            <div id="dtpick" class="dtpicker-cont">
                                <div class="dtpicker-content" style="margin-left: 15%;">
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

                @if(session('role')=='校级'||session('role')=='大组长' )


                <div id="minisize" class="col-xs-6 col-sm-6">
                    <div class="widget-box-green">
                        <div class="widget-header header-color-green">
                            <h5 class="bigger lighter"></h5>
                        </div>
                        <div class="widget-body widget-body-blue">
                            <table id="OneGroup"
                                   data-toggle="table"
                                   data-classes="table table-hover table-bordered"
                                   data-pagination="true"
                                   data-page-size="5"
                                   data-page-list="[5, 10, 20, 50, 100, 200]" >
                                <thead>
                                <tr>
                                    <th data-field="user_id" data-halign="center" data-align="center" class="className">督导ID</th>
                                    <th data-field="name" data-halign="center" data-align="center" class="className">督导姓名</th>
                                    {{--<th data-field="level" data-halign="center" data-align="center" class="className">职务</th>--}}
                                    <th data-field="save" data-halign="center" data-align="center">待提交</th>
                                    <th data-field="finish" data-halign="center" data-align="center" class="classNum">已提交</th>
                                    <th data-field="listened" data-halign="center" data-align="center" class="classNum">完成总课时</th>
                                    <th data-field="listened_one" data-halign="center" data-align="center" class="classNum">只听1节课</th>
                                    <th data-field="listened_two" data-halign="center" data-align="center" class="classNum">连续完成2课时</th>
                                    <th data-field="listened_three" data-halign="center" data-align="center" class="classNum">连续完成3课时</th>
                                    <th data-field="listened_four" data-halign="center" data-align="center" class="classNum">连续完成4课时</th>
                                </tr>
                                </thead>
                                <tfoot>
                                    <tr>
                                        <th style="text-align: center">合计</th>
                                        <th style="text-align: center"></th>
                                        <th style="text-align: center"></th>
                                        <th style="text-align: center" id="save0"></th>
                                        <th style="text-align: center" id="finish0"></th>
                                        <th style="text-align: center" id="listen0"></th>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>
                </div>
                <div id="minisize" class="col-xs-6 col-sm-6">
                    <div class="widget-box-red">
                        <div class="widget-header header-color-red">
                            <h5 class="bigger lighter"></h5>
                        </div>

                        <div class="widget-body widget-body-red">
                            <table id="TwoGroup"
                                   data-toggle="table"
                                   data-classes="table table-hover table-bordered"
                                   data-pagination="true"
                                   data-page-size="5"
                                   >
                                <thead>
                                <tr>
                                    <th data-field="user_id" data-halign="center" data-align="center" class="className">督导ID</th>
                                    <th data-field="name" data-halign="center" data-align="center" class="className">督导姓名</th>
                                    {{--<th data-field="level" data-halign="center" data-align="center" class="className">职务</th>--}}
                                    <th data-field="save" data-halign="center" data-align="center">待提交</th>
                                    <th data-field="finish" data-halign="center" data-align="center" class="classNum">已提交</th>
                                    <th data-field="listened" data-halign="center" data-align="center" class="classNum">完成总课时</th>
                                    <th data-field="listened_one" data-halign="center" data-align="center" class="classNum">只听1节课</th>
                                    <th data-field="listened_two" data-halign="center" data-align="center" class="classNum">连续完成2课时</th>
                                    <th data-field="listened_three" data-halign="center" data-align="center" class="classNum">连续完成3课时</th>
                                    <th data-field="listened_four" data-halign="center" data-align="center" class="classNum">连续完成4课时</th>
                                </tr>
                                </thead>
                                <tfoot>
                                <tr>
                                    <th style="text-align: center">合计</th>
                                    <th style="text-align: center"></th>
                                    <th style="text-align: center"></th>
                                    <th style="text-align: center" id="save1"></th>
                                    <th style="text-align: center" id="finish1"></th>
                                    <th style="text-align: center" id="listen1"></th>
                                </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>
                </div>
                <div id="minisize" class="col-xs-6 col-sm-6">
                    <div class="widget-box-red">
                        <div class="widget-header header-color-red">
                            <h5 class="bigger lighter"></h5>
                        </div>

                        <div class="widget-body widget-body-red">
                            <table id="ThreeGroup"
                                   data-toggle="table"
                                   data-classes="table table-hover table-bordered"
                                   data-pagination="true"
                                   data-page-size="5"
                                   data-page-list="[5, 10, 20, 50, 100, 200]" >
                                <thead>
                                <tr>
                                    <th data-field="user_id" data-halign="center" data-align="center" class="className">督导ID</th>
                                    <th data-field="name" data-halign="center" data-align="center" class="className">督导姓名</th>
                                    {{--<th data-field="level" data-halign="center" data-align="center" class="className">职务</th>--}}
                                    <th data-field="save" data-halign="center" data-align="center">待提交</th>
                                    <th data-field="finish" data-halign="center" data-align="center" class="classNum">已提交</th>
                                    <th data-field="listened" data-halign="center" data-align="center" class="classNum">完成总课时</th>
                                    <th data-field="listened_one" data-halign="center" data-align="center" class="classNum">只听1节课</th>
                                    <th data-field="listened_two" data-halign="center" data-align="center" class="classNum">连续完成2课时</th>
                                    <th data-field="listened_three" data-halign="center" data-align="center" class="classNum">连续完成3课时</th>
                                    <th data-field="listened_four" data-halign="center" data-align="center" class="classNum">连续完成4课时</th>
                                </tr>
                                </thead>
                                <tfoot>
                                <tr>
                                    <th style="text-align: center">合计</th>
                                    <th style="text-align: center"></th>
                                    <th style="text-align: center"></th>
                                    <th style="text-align: center" id="save2"></th>
                                    <th style="text-align: center" id="finish2"></th>
                                    <th style="text-align: center" id="listen2"></th>
                                </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>
                </div>
                <div id="minisize" class="col-xs-6 col-sm-6">
                    <div class="widget-box-green">
                        <div class="widget-header header-color-green">
                            <h5 class="bigger lighter"></h5>
                        </div>
                        <div class="widget-body widget-body-blue">
                            <table id="FourGroup"
                                   data-toggle="table"
                                   data-classes="table table-hover table-bordered"
                                   data-pagination="true"
                                   data-page-size="5"
                                   data-page-list="[5, 10, 20, 50, 100, 200]" >
                                <thead>
                                <tr>
                                    <th data-field="user_id" data-halign="center" data-align="center" class="className">督导ID</th>
                                    <th data-field="name" data-halign="center" data-align="center" class="className">督导姓名</th>
                                    {{--<th data-field="level" data-halign="center" data-align="center" class="className">职务</th>--}}
                                    <th data-field="save" data-halign="center" data-align="center">待提交</th>
                                    <th data-field="finish" data-halign="center" data-align="center" class="classNum">已提交</th>
                                    <th data-field="listened" data-halign="center" data-align="center" class="classNum">完成总课时</th>
                                    <th data-field="listened_one" data-halign="center" data-align="center" class="classNum">只听1节课</th>
                                    <th data-field="listened_two" data-halign="center" data-align="center" class="classNum">连续完成2课时</th>
                                    <th data-field="listened_three" data-halign="center" data-align="center" class="classNum">连续完成3课时</th>
                                    <th data-field="listened_four" data-halign="center" data-align="center" class="classNum">连续完成4课时</th>

                                </tr>
                                </thead>
                                <tfoot>
                                <tr>
                                    <th style="text-align: center">合计</th>
                                    <th style="text-align: center"></th>
                                    <th style="text-align: center"></th>
                                    <th style="text-align: center" id="save3"></th>
                                    <th style="text-align: center" id="finish3"></th>
                                    <th style="text-align: center" id="listen3"></th>
                                </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>
                </div>
                @elseif(session('role')=='小组长')
                    <div class="col-lg-12 col-lg-12">
                        <div class="widget-box-green">
                            <div class="widget-header header-color-green">
                                <h5 class="bigger lighter"></h5>
                            </div>
                            <div class="widget-group-body widget-body-blue">
                                <table id="Group"
                                       data-toggle="table"
                                       data-classes="table table-hover table-bordered"
                                       data-pagination="true"
                                       data-page-size="10"
                                       data-page-list="[5, 10, 20, 50, 100, 200]" >
                                    <thead>
                                    <tr>
                                        <th data-field="user_id" data-halign="center" data-align="center" class="className">督导ID</th>
                                        <th data-field="name" data-halign="center" data-align="center" class="className">督导姓名</th>
                                        {{--<th data-field="level" data-halign="center" data-align="center" class="className">职务</th>--}}
                                        <th data-field="save" data-halign="center" data-align="center">待提交</th>
                                        <th data-field="finish" data-halign="center" data-align="center" class="classNum">已提交</th>
                                        <th data-field="listened" data-halign="center" data-align="center" class="classNum">完成总课时</th>
                                        <th data-field="listened_one" data-halign="center" data-align="center" class="classNum">只听1节课</th>
                                        <th data-field="listened_two" data-halign="center" data-align="center" class="classNum">连续完成2课时</th>
                                        <th data-field="listened_three" data-halign="center" data-align="center" class="classNum">连续完成3课时</th>
                                        <th data-field="listened_four" data-halign="center" data-align="center" class="classNum">连续完成4课时</th>
                                    </tr>
                                    </thead>
                                    <tfoot>
                                    <tr>
                                        <th style="text-align: center">合计</th>
                                        <th style="text-align: center"></th>
                                        <th style="text-align: center"></th>
                                        <th style="text-align: center" id="saveG"></th>
                                        <th style="text-align: center" id="finishG"></th>
                                        <th style="text-align: center" id="listenG"></th>
                                    </tr>
                                    </tfoot>
                                </table>
                            </div>
                        </div>
                    </div>
                @endif
            </div>
        </div>

    </div>
</div>

@include('layout.footer')
</body>

<script src="assets/js/bootstrap-table.js"></script>
<script src="assets/js/bootstrap-table-zh-CN.js"></script>
<script src="{{asset('js/Statistics.js')}}"></script>


</html>
