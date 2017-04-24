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

    /*密码错误提示框*/
    .alert-danger{
        font-size: x-large;
        text-align: center;
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
                {{--<!-- .breadcrumb -->--}}
                <div class="breadcrumbs" id="breadcrumbs">
                    <ul class="breadcrumb" style="padding-top: 22px; padding-bottom: 12px;">
                        {{--<li>--}}
                            {{--<i class="icon-home home-icon"></i>--}}
                            {{--<a style="color: #225081;" href="#">用户管理</a>--}}
                        {{--</li>--}}
                        {{--<li style="color:gray">修改密码</li>--}}
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
                <div  class="form-div" style="margin-left: 50px;margin-right: 50px;background-color: #fff">
                    <div class="panel-heading">
                        {{--<h2 class="panel-title" style="font-family:'Microsoft YaHei'"><span>个人信息</span></h2>--}}
                    </div>
                    {{--<span class="required">*</span><span>详细信息</span>--}}


                    {{--{{$msg['first_info']}}--}}
                    {{--{{$msg['old_pass']}}--}}
                    <div class="panel-body ">
                        {{--<form action="/changePass" method="post" id="infoForm">--}}
                        <form action="#" method="post" id="infoForm">

                            <input type="hidden" name="_token" value="{!! csrf_token() !!}">
                            <div style="width: 800px; margin:0 auto;">
                                <img src="{{asset('assets/images/user.jpg')}}" style="margin-bottom:30px;">
                                {{--<a class="btn btn-warning xiugai" style="margin-left: 280px;width:100px;">修改密码</a>--}}
                                <div class="form-group">
                                    <span for="password_now">&nbsp;&nbsp;当前密码</span>
                                    <input class="form-control" name="password_now" type="password" id="password_now" value="" required>
                                </div>
                                <div class="form-group box_2">
                                    <span for="password_new">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;新密码</span>
                                    <input class="form-control input-small" name="password_new" type="password" id="password_new" value=""  required>
                                    <div class="info"></div>
                                </div>
                                <div class="form-group box_3">
                                    <span for="newPassword_confirmation">确认新密码</span>
                                    <input class="form-control" name="newPassword_confirmation" type="password" id="newPassword_confirmation" value=""  required>
                                    <div class="info"></div>
                                </div>
                                <div class="form-group">
                                    <span for="newPassword_confirmation">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;验证码</span>
                                    <input type="text" name="cpt" value="" style="height: 35px;width: 164px!important;margin-right: 10px!important;"/>
                                    <img src="{{ url('captcha/mews') }}" onclick="this.src='{{ url('captcha/mews') }}?r='+Math.random();" alt="" >
                                </div>
                                <button class="btn btn-info btn-raised"style="margin-left: 280px; width:100px;">保存</button>

                                {{--<input class="btn btn-primary submit" type="submit" value="确定">--}}
                            </div>

                        </form>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>
<!-- 面板结束 -->
@include('layout.footer')
</body>
<script src="assets/js/bootstrap.min.js"></script>
<script src="{{asset('js/changePass.js')}}"></script>
<script>
    if("{{ Cookie::get('message') }}" != ''){
        alert('{{ Cookie::get('message') }}');
        {{ Cookie::queue('message', null , -1) }}
    }
</script>
<script>
    $(document).ready(function()
    {
        var info_pwflag=1;
        var info_apwflag=1;

        <!--第一次密码验证-->

        $("#password_new").focus(function()
        {
            if($(this).val().length==0)
            {
                $(this).parent().css('border-color','#4DAFE4');
                $(".box_2 .info").css("color","#4DAFE4").text("请输入6-16位密码，不含空格！");
            }
            if(info_pwflag==1)
            {
                $(this).parent().css('border-color','#4DAFE4');
                $(".box_2 .info").css("color","#4DAFE4").text("请输入6-16位密码，不含空格！");
            }
            else
            {
                $(this).parent().css('border-color','red');
                $(".box_2 .info").css("color","red").text("请输入6-16位密码，不含空格！");
            }
        });
        $("#password_new").blur(function()
        {
            var temp=$(this).val();
            if(temp.length==0)
            {
                $(this).parent().css('border-color','red');
                $(".box_2 .info").css("color","red").text("请输入密码！");
            }

            else
            {
                if(info_pwflag==1)
                {
                    $(this).parent().css('border-color','#14BC3E');
                    $(".box_2 .info").css("color","#14BC3E").text("输入正确！");
                }
            }
            if(temp.length<6)
            {
                if(info_pwflag==1)
                {
                    $(this).parent().css('border-color','red');
                    $(".box_2 .info").css("color","red").text("请输入6-16位密码，不含空格！");
                    info_pwflag=0;
                }
            }
        });
        $("#password_new").keyup(function(event)
        {
            var info_user=$(this).val();
            if(info_user.length==0)
            {
                info_pwflag=1;
            }
            else
            {
                for(i=info_user.length-1;i>=0;i--)
                {
                    var temp=info_user.charAt(i);
                    if(temp==" ")
                    {
                        info_pwflag=0;
                        break;
                    }
                    else
                    {
                        info_pwflag=1;

                    }
                }
            }
            if(info_pwflag==1)
            {
                $(this).parent().css('border-color','#4DAFE4');
                $(".box_2 .info").css("color","#4DAFE4").text("请输入6-16位密码，不含空格！");
            }
            else
            {
                $(this).parent().css('border-color','red');
                $(".box_2 .info").css("color","red").text("请输入6-16位密码，不含空格！");
            }
        });

        <!--第二次密码验证-->

        $("#newPassword_confirmation").focus(function()
        {
            if($(this).val().length==0)
            {
                if(info_pwflag==1)
                {
                    $(this).parent().css('border-color','#4DAFE4');
                    $(".box_3 .info").css("color","#4DAFE4").text("确认密码！");
                }
                else
                {
                    $(this).parent().css('border-color','#CAC21F');
                    $(".box_3 .info").css("color","#CAC21F").text("第一次密码输入不正确！");
                }
            }
            else
            {
                if(info_pwflag==1)
                {
                    if(info_apwflag==1)
                    {
                        $(this).parent().css('border-color','#4DAFE4');
                        $(".box_3 .info").css("color","#4DAFE4").text("确认密码正确！");
                    }
                    else
                    {
                        $(this).parent().css('border-color','red');
                        $(".box_3 .info").css("color","red").text("确认密码不正确！");
                    }
                }
                else
                {
                    $(this).parent().css('border-color','#CAC21F');
                    $(".box_3 .info").css("color","#CAC21F").text("第一次密码输入不正确！");
                }
            }


        });
        $("#newPassword_confirmation").blur(function()
        {
            var temp=$(this).val();
            if(temp.length==0)
            {
                $(this).parent().css('border-color','red');
                $(".box_3 .info").css("color","red").text("请确认密码！");
            }
            else
            {
                if(info_pwflag==1)
                {
                    if(info_apwflag==1)
                    {
                        $(this).parent().css('border-color','#14BC3E');
                        $(".box_3 .info").css("color","#14BC3E").text("确认密码正确！");
                    }
                    else
                    {
                        $(this).parent().css('border-color','red');
                        $(".box_3 .info").css("color","red").text("确认密码不正确！");
                    }
                }
                else
                {
                    $(this).parent().css('border-color','#CAC21F');
                    $(".box_3 .info").css("color","#CAC21F").text("第一次密码输入不正确！");
                }
            }
        });
        $("#newPassword_confirmation").keyup(function(event)
        {
            var info_user=$(this).val();
            var info_pw=$("#password_new").val();
            if(info_pwflag==1)
            {
                if(info_user.length==0)
                {
                    info_apwflag=1;
                }
                else
                {
                    if(info_user==info_pw)
                    {
                        info_apwflag=1;
                    }
                    else
                    {
                        info_apwflag=0;
                    }
                }
            }
            //alert(info_pw);
            if(info_pwflag==1)
            {
                if(info_apwflag==1)
                {
                    $(this).parent().css('border-color','#4DAFE4');
                    $(".box_3 .info").css("color","#4DAFE4").text("确认密码正确！");
                }
                else
                {
                    $(this).parent().css('border-color','red');
                    $(".box_3 .info").css("color","red").text("确认密码不正确！");
                }
            }
            else
            {
                $(this).parent().css('border-color','#CAC21F');
                $(".box_3 .info").css("color","#CAC21F").text("第一次密码输入不正确！");
            }
        });
    });
</script>
</html>