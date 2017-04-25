<!DOCTYPE html>
<meta name="render" content="webkit|ie-comp|ie-stand">
<meta http-equiv="X-UA-Compatible" content="IE=11">
<html lang="en">
<style type="text/css">

</style>
<head>
    <meta charset="utf-8" />
    <title>北京林业大学教评中心业务平台</title>

    <meta name="viewport" content="width=device-width, initial-scale=1.0" />

    <!-- basic styles -->

    <link href="{{asset('origin_bootstrap/css/bootstrap.min.css')}}" rel="stylesheet" />
    <link rel="stylesheet" href="{{asset('assets/css/font-awesome.min.css')}}" />

    <!--[if IE 7]>
    <link rel="stylesheet" href="{{asset('assets/css/font-awesome-ie7.min.css')}}" />
    <![endif]-->

    <!-- page specific plugin styles -->

    <!-- fonts -->



    <!-- ace styles -->

    <link rel="stylesheet" href="{{asset('assets/css/ace.min.css')}}" />
    <link rel="stylesheet" href="{{asset('assets/css/ace-rtl.min.css')}}" />

    <!--[if lte IE 8]>
    <link rel="stylesheet" href="{{asset('assets/css/ace-ie.min.css')}}" />
    <![endif]-->

    <!-- inline styles related to this page -->

    <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->

    <!--[if lt IE 9]>
    <script src="//cdn.bootcss.com/html5shiv/r29/html5.js"></script>
    <script src="//cdn.bootcss.com/respond.js/1.4.2/respond.js"></script>
    <![endif]-->
</head>

<body class="login-layout">
<img style="position:absolute;left:0px;top:0px;width:100%;height:100%;z-Index:-1;" src="{{asset('assets/images/gallery/login.png')}}" />

<div class="main-container"  style="margin-top: 10%">
    <div class="main-content">
        {{--<div class="col-md-5 col-md-offset-1"><img src="/assets/images/gallery/bg.png" style="width: 95%;height: 95%;" alt=""></div>--}}
        <div class="col-md-12">
            <div class="col-sm-10 col-sm-offset-1">
                <div class="login-container">
                    <div class="center" style="margin-top:60px;">
                        <h1>
                            <img src="{{asset('assets/images/logo.png')}}" alt="" style="width: 12%;margin-right:8px;">
                            <!--<span class="red"></span>-->
                            <span style="color: #424242">督导教学评价系统</span>
                        </h1>

                    </div>

                    <div class="space-6"></div>

                    <div class="position-relative">
                        <div id="login-box" class="login-box visible widget-box no-border" style="margin-top: 30px;box-shadow: 0 8px 17px 0 rgba(0, 0, 0, 0.2), 0 6px 20px 0 rgba(0, 0, 0, 0.19);">
                            <div class="widget-body">
                                <div class="widget-main">
                                    <h4 class="header lighter bigger" style="color: #424242;">
                                        <i class="icon-coffee "></i>
                                        用户登录
                                    </h4>
                                    @include('errors.list')
                                    <div class="space-6"></div>

                                    <form id="formid" method="post" action="/login">
                                        {{ csrf_field() }}
                                        <fieldset>
                                            <label class="block clearfix">
														<span class="block input-icon input-icon-right">
															{{--<input type="hidden" name="_token" value="{{ csrf_token() }}" />--}}
                                                            <input type="text" name="user_id" class="form-control" value="" placeholder="" />
															<i class="icon-user"></i>
														</span>
                                            </label>

                                            <label class="block clearfix">
														<span class="block input-icon input-icon-right">
															<input type="password" name="password" class="form-control" value="" placeholder="" />
															<i class="icon-lock"></i>
														</span>
                                            </label>

                                            <input type="text" name="cpt" value="" style="height: 35px; padding: 0;"/>

                                            <img src="{{ asset('captcha/makecode') }}" onclick="this.src='{{ asset('captcha/makecode') }}?r='+Math.random();" alt="" >
                                            {{--<img src="/captcha/mews" onclick="this.src='/captcha/mews?r='+Math.random();" alt="" >--}}

                                            <div style="width: 50px;!important;float: right;">点击图片刷新</div>

                                            <div class="space"></div>

                                            <div class="clearfix">
                                                <label class="inline">
                                                    <input type="checkbox" class="ace" name="remember" value="1"/>
                                                    <span class="lbl"> 记住我</span>
                                                </label>

                                                <button type="button" class="width-35 pull-right btn btn-sm btn-primary" onclick='$("#formid").submit()'>
                                                    <i class="icon-key" ></i>
                                                    登录
                                                </button>
                                            </div>

                                            <div class="space-4"></div>
                                        </fieldset>
                                    </form>


                                </div><!-- /widget-main -->

                                {{--<div class="toolbar clearfix" style="text-align: center">--}}
                                {{--<h4 class="white">&copy; 数字林业研究所</h4>--}}
                                {{--</div>--}}
                            </div><!-- /widget-body -->
                        </div><!-- /login-box -->




                    </div><!-- /position-relative -->
                </div>
            </div><!-- /.col -->
        </div><!-- /.row -->
    </div>
</div><!-- /.main-container -->

<!-- basic scripts -->

<!--[if !IE]> -->

<script src="{{asset('assets/js/jquery-2.0.3.min.js')}}"></script>

<!-- <![endif]-->

<!--[if IE]>
<script src="{{asset('assets/js-master/jquery-1.10.2.min.js')}}"></script>
<![endif]-->

<!--[if !IE]> -->

<script type="text/javascript">
    window.jQuery || document.write("<script src='assets/js/jquery-2.0.3.min.js'>"+"<"+"/script>");
</script>

<!-- <![endif]-->

<!--[if IE]>
<script type="text/javascript">
    window.jQuery || document.write("<script src='assets/js/jquery-1.10.2.min.js'>"+"<"+"/script>");
</script>
<![endif]-->

<script type="text/javascript">
    if("ontouchend" in document) document.write("<script src='assets/js/jquery.mobile.custom.min.js'>"+"<"+"/script>");
</script>

<!-- inline scripts related to this page -->

<script type="text/javascript">
    function show_box(id) {
        jQuery('.widget-box.visible').removeClass('visible');
        jQuery('#'+id).addClass('visible');
    }

    document.onkeydown=function(event){
        var e = event || window.event || arguments.callee.caller.arguments[0];
        if(e && e.keyCode==13){ // enter 键
            $('.btn-primary').click();
        }
    };
</script>
</body>
</html>
