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
    <!--[if IE 7]>
    <link rel="stylesheet" href="assets/css/font-awesome-ie7.min.css" />
    <![endif]-->

    <!--[if lt IE 9]>
    <script src="assets/js/html5shiv.js"></script>
    <script src="assets/js/respond.min.js"></script>
    <![endif]-->
</head>
<script src="assets/js/jquery-2.0.3.min.js"></script>

<body>

@include('layout.header')
        <!-- 面板开始 -->
<div class="container-fluid" style="padding: 0 12px">
    <div class="row">
        <input type="hidden" id="hidden" name="_token" value="{{ csrf_token() }}" />
        @include('layout.sidebar')
        <div class="row">
            <div class="col-sm-10 col-sm-offset-2 col-md-10 col-md-offset-2">
                <!-- .breadcrumb -->
                <div class="breadcrumbs" id="breadcrumbs">
                    <ul class="breadcrumb" style="padding-top: 22px; padding-bottom: 12px;">
                        {{--<li>--}}
                            {{--<i class="icon-home home-icon"></i>--}}
                            {{--<a style="color: #225081;" href="#">用户管理</a>--}}
                        {{--</li>--}}
                        {{--<li style="color:gray">修改信息</li>--}}
                    </ul>
                </div>
                <!-- .breadcrumb -->
                @if($errors->any())
                    <ul class="list-group">
                        @foreach($errors->all() as $error)
                            <li class="alert alert-danger">{{ $error }}</li>
                        @endforeach
                    </ul>
                @endif
                @if( session('role')=='大组长' ||session('role')=='校级')
                <div  class="form-div" style="margin-left: 50px;margin-right: 50px;background-color: #fff;">
                    <div class="panel-heading">
                        {{--<h2 class="panel-title" style="font-family:'Microsoft YaHei'"><span>个人信息</span></h2>--}}
                    </div>
                    {{--<span class="required">*</span><span>详细信息</span>--}}

                    <div class="panel-body ">
                        <form action="/userManage" method="post" id="infoForm">

                            <input type="hidden" name="_token" value="{!! csrf_token() !!}">
                            <div style="width: 800px; margin:0 auto;">
                                {{--<img src="assets/images/user.jpg" style="margin:0 auto; display: block;">--}}
                                <img src="assets/images/user.jpg" style="margin-bottom:30px;">
                                {{--<a class="btn btn-warning xiugai" style="margin-left: 280px;width:100px;">修改密码</a>--}}
                                <div class="form-group">
                                    <span for="account_name">&nbsp;登 录 ID</span>
                                    <input class="form-control" name="user_id" type="text" id="user_id" value="{{$data['user_id']}}" required readonly="readonly">
                                </div>
                                <div class="form-group">
                                    <span for="username">&nbsp;用 户 名</span>
                                    <input class="form-control" name="name" type="text" id="name" value="{{$data['name']}}" required readonly="readonly">
                                </div>
                                <div class="form-group ">
                                    <span for="email">&nbsp;&nbsp;邮&nbsp;&nbsp;&nbsp;&nbsp; 箱</span>
                                    <input class="form-control input-small" name="email" type="email" id="email" value="{{$data['email']}}" required>
                                </div>
                                <div class="form-group">
                                    <span for="phone">电话号码</span>
                                    <input class="form-control" name="phone" type="text" id="phone" value="{{$data['phone']}}">
                                </div>

                                <button class="btn btn-info btn-raised" style="margin-left: 280px; width:100px;" >保存</button>
                                {{--<input class="btn btn-primary submit" type="submit" value="确定">--}}
                            </div>

                        </form>
                    </div>

                </div>
                @endif
                @if(session('role')=='小组长' || session('role')=='督导' || session('role')=='院级')
                    <div  class="form-div" style="margin-left: 50px;margin-right: 50px;background-color: #fff;">
                        <div class="panel-heading">
                            {{--<h2 class="panel-title" style="font-family:'Microsoft YaHei'"><span>个人信息</span></h2>--}}
                        </div>
                        {{--<span class="required">*</span><span>详细信息</span>--}}

                        <div class="panel-body ">
                            <form action="/userManage" method="post" id="infoForm">

                                <input type="hidden" name="_token" value="{!! csrf_token() !!}">
                                <div style="width: 800px; margin:0 auto;">
                                    {{--<img src="assets/images/user.jpg" style="margin:0 auto; display: block;">--}}
                                    <img src="assets/images/user.jpg" style="margin-bottom:30px;">
                                    {{--<a class="btn btn-warning xiugai" style="margin-left: 280px;width:100px;">修改密码</a>--}}
                                    <div class="form-group">
                                        <span for="account_name">&nbsp;登 录 ID</span>
                                        <input class="form-control" name="user_id" type="text" id="user_id" value="{{Auth::User()->user_id}}" required readonly="readonly">
                                    </div>
                                    <div class="form-group">
                                        <span for="username">&nbsp;用 户 名</span>
                                        <input class="form-control" name="name" type="text" id="name" value="{{Auth::User()->name}}" required readonly="readonly">
                                    </div>
                                    <div class="form-group ">
                                        <span for="email">&nbsp;&nbsp;邮&nbsp;&nbsp;&nbsp;&nbsp; 箱</span>
                                        <input class="form-control input-small" name="email" type="email" id="email" value="{{Auth::User()->email}}" required>
                                    </div>
                                    <div class="form-group">
                                        <span for="phone">电话号码</span>
                                        <input class="form-control" name="phone" type="text" id="phone" value="{{Auth::User()->phone}}">
                                    </div>

                                    <button class="btn btn-info" style="margin-left: 280px; width:100px;" >保存</button>
                                    {{--<input class="btn btn-primary submit" type="submit" value="确定">--}}
                                </div>

                            </form>
                        </div>

                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
<!-- 面板结束 -->
@include('layout.footer')
</body>
<script src="assets/js/bootstrap.min.js"></script>
<script src="{{asset('js/userManage.js')}}"></script>
<script>
    if("{{ Cookie::get('mess') }}" != ''){
        alert('{{ Cookie::get('mess') }}');
        {{ Cookie::queue('mess', null , -1) }}
    }
</script>

</html>