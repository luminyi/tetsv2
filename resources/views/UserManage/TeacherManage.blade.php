<!DOCTYPE html>
<meta name="render" content="webkit|ie-comp|ie-stand">
<meta http-equiv="X-UA-Compatible" content="IE=11">
<html lang="en">
<style type="text/css">
    *{font-family:"Microsoft YaHei"}
    .nav_a{
        cursor: pointer;
    }
    #infoForm{
        margin: 0 40px 40px 40px;
        text-align: center;
    }

    #infoForm input{
        width: 300px!important;
        display: inline-block!important;
        margin: 11px 0px 14px 22px!important;
    }
    .submit{
        width: 400px!important;
    }
    #infoForm span{
        font-size: 16px;
    }
    #infoForm select{
        display: inline-block!important;
        width:300px;margin:11px 0px 14px 22px!important;
    }
    .error{
        text-align: center;
        list-style: none;
        margin-bottom: 0px!important;
        padding: 5px!important;
    }
    .required{
        font-size: 16px;
        color:#f00 ;
        margin-left:80px;
        font-weight:400;
    }
    .form-div{
        background-color: rgba(255, 255, 255, 0.27);
        border-radius: 10px;
        margin: 0 auto;
        padding: 30px 0 20px 0;
        font-size: 12px;
        box-shadow: inset 0 0 10px rgba(255, 255, 255, 0.5), 0 0 15px rgba(75, 75, 75, 0.3);
        text-align: left;
        /*margin-bottom: 50px;*/
        margin-top: 30px;;
    }
    #name{
        width: 220px;
        margin-left: 20px;
        padding: 8px;
    }
    .add_task{
        margin-left:30px;
    }
    #search-suggest{
        position: absolute;
        display: none;
        /*z-index: 100;*/
    }
    .suggest{
        width:183px;
        background-color: white;
        border: 1px solid #999;
        left:400px;
    }
    .suggest ul
    {

        list-style: none;
        margin: 0;
        padding: 0;
    }
    .suggest ul li{
        padding:3px;
        font-size: 14px;
        line-height: 25px;
        cursor: pointer;
    }
    .suggest ul li:hover{
        text-decoration: underline;
        background-color: grey;
    }
    .seeDetail{
        cursor: pointer;
        color: #428bca;
    }
    .modal-dialog{
        width: 1200px !important;
        padding-top: 60px !important;
        margin-left: 480px !important;
    }
    @media screen and (max-width: 1400px){
        .modal-dialog{
            width: 1120px !important;
            margin-left: 180px !important;
        }
    }

    .btn-add{
        background-color:#B6D9B1;
        border-color:#B6D9B1;
    }
    .btn-add,.btn-remove,.btn-daoru,.btn-daochu{
        color: #fff;
    }
    .btn:hover,.btn:focus{
        color: #fff !important;
    }
    .search input{
        margin-top: 10px;
    }
</style>
<head>
    <meta charset="utf-8" />
    <title>北林教学评价系统</title>
    <meta name="keywords" content="北林教学评价系统" />
    <meta name="description" content="北林教学评价系统" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <!-- basic styles -->
    <link href="assets/css/bootstrap.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="assets/css/font-awesome.min.css" />
    <link rel="stylesheet" href="assets/css/dashboard.css" />
    <link rel="stylesheet" href="assets/css/common.css" />
    <link rel="stylesheet" href="assets/css/bootstrap-material-btndesign.css" />
    {{--<link rel="stylesheet" href="calendar1/css/bootstrap-datetimepicker.css" />--}}


    {{--学期选择 日历相关--}}
    <link rel="stylesheet" type="text/css" href="calendar/DateTimePicker.css" />
    <script type="text/javascript" src="calendar/jquery-1.11.0.min.js"></script>
    <!--[if IE 7]>
    <link rel="stylesheet" href="assets/css/font-awesome-ie7.min.css" />
    <![endif]-->

    <!--[if lt IE 9]>
    <script src="assets/js/html5shiv.js"></script>
    <script src="assets/js/respond.min.js"></script>
    <![endif]-->

    <script src="assets/js/jquery-2.0.3.min.js"></script>
    <script src="assets/js/bootstrap.min.js"></script>
    <script src="assets/js/bootstrap-table.js"></script>
    <script src="assets/js/bootstrap-table-zh-CN.js"></script>
</head>

<body>
@include('layout.header')
@include('layout.sidebar')
<div class="col-sm-10 col-sm-offset-2 col-md-10 col-md-offset-2">
    <div class="row">
        <!-- .breadcrumb -->
        <div class="breadcrumbs" id="breadcrumbs">
            <ul class="breadcrumb" style="padding-top: 22px; padding-bottom: 12px;">
                {{--<li>--}}
                {{--<i class="icon-home home-icon"></i>--}}
                {{--<a style="color: #225081;" href="#">用户管理</a>--}}
                {{--</li>--}}
            </ul>
        </div>

        <div class="page-content col-md-12">
            @if(session('role')=='校级')
                <button id="btn_import" class="btn btn-success btn-raised" data-toggle="modal" data-target="#ImportTeacher">
                    <i class="glyphicon  glyphicon glyphicon-import"></i>导入</button>
                <!-- 导入必听课程的模态框（Modal） -->
                <div class="modal fade" id="ImportTeacher" tabindex="-1" role="dialog"
                     aria-labelledby="myModalLabel" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="close"
                                        data-dismiss="modal" aria-hidden="true">
                                    &times;
                                </button>
                                <h4 class="modal-title" id="myModalLabel">
                                    导入教师信息
                                </h4>
                            </div>
                            <div class="modal-body">
                                <form id="myform" action="" method="post" enctype="multipart/form-data">
                                    <input accept=".xls,.xlsx,.csv" type="file"  id="SelectFile" name="TeacherInfoImport" />
                                    <input type="hidden" name="_token" value="{!! csrf_token() !!}"/>
                                </form>
                            </div>
                            <div class="modal-footer">
                                <button id="sure" type="button" class="btn btn-primary btn-raised">
                                    提交
                                </button>
                                <button type="button" class="btn btn-default btn-raised"
                                        data-dismiss="modal">关闭
                                </button>

                            </div>
                        </div><!-- /.modal-content -->
                    </div><!-- /.modal -->
                </div>


            @endif
                <table
                        data-toggle="table"
                        id="activityTable"
                        data-halign="center" data-align="center"
                        data-query-params="queryParams"
                        data-pagination="true"
                        data-page-list="[5, 10, 20, 50, 100, 200]"
                        data-page-size="20"
                        data-url="/teacherInfo"
                        data-search="true">
                    <thead>
                    <tr>
                        <th data-field="name" data-halign="center" data-align="center">教师姓名</th>
                        <th data-field="sex" data-halign="center" data-align="center">性别</th>
                        <th data-field="email" data-halign="center" data-align="center">邮箱</th>
                        <th data-field="phone" data-halign="center" data-align="center">电话</th>
                        <th data-field="unit" data-halign="center" data-align="center">学院</th>
                        <th data-field="prorank" data-halign="center" data-align="center">职称</th>
                        <th data-field="skill" data-halign="center" data-align="center">专业领域</th>
                    </tr>
                    </thead>
                </table>
        </div>

    </div>


</div>
<script src="js/TeacherManage.js"></script>
@include('layout.footer')
</body>



</html>