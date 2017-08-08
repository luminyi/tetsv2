<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>{{ config('blog.title') }} Admin</title>

    <link href="{{asset('origin_bootstrap/css/bootstrap.min.css')}}" rel="stylesheet">

    <link href="{{asset('assets/bootstrap-table/src/bootstrap-table.css')}}" rel="stylesheet"/>

    <script src="{{asset('assets/js/jquery-1.10.2.min.js')}}"></script>
    <script src="{{asset('origin_bootstrap/js/bootstrap.min.js')}}"></script>
    {{--活动表格--}}
    <script src="{{asset('assets/bootstrap-table/src/bootstrap-table.js')}}"></script>
    <script src="{{asset('assets/bootstrap-table/src/locale/bootstrap-table-zh-CN.js')}}"></script>

    @yield('styles')

        <!--[if lt IE 9]>
    <script src="//oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
    <script src="//oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
</head>
<body>
@include('weixin.header')
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-4 col-md-offset-4">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h3 class="panel-title">修改密码</h3>
                    </div>
                    @if($errors->any())
                        <ul class="list-group">
                            @foreach($errors->all() as $error)
                                <li class="alert alert-danger">{{ $error }}</li>
                            @endforeach
                        </ul>
                    @endif
                    <div class="panel-body">

                        <form action="#" method="post" id="infoForm">
                            <input type="hidden" name="_token" value="{!! csrf_token() !!}">
                            <div>
                                <img src="{{asset('assets/images/user.jpg')}}" style="margin-bottom:30px; margin-left: 40%;">
                                {{--<a class="btn btn-warning xiugai" style="margin-left: 280px;width:100px;">修改密码</a>--}}
                                <div class="form-group">
                                    <span for="password_now">当前密码</span>
                                    <input class="form-control" name="password_now" type="password" id="password_now" value="" required>
                                </div>
                                <div class="form-group box_2">
                                    <span for="password_new">新密码</span>
                                    <input class="form-control input-small" name="password_new" type="password" id="password_new" value=""  required>
                                    <div class="info"></div>
                                </div>
                                <div class="form-group box_3">
                                    <span for="newPassword_confirmation">确认新密码</span>
                                    <input class="form-control" name="newPassword_confirmation" type="password" id="newPassword_confirmation" value=""  required>
                                    <div class="info"></div>
                                </div>
                                <div class="form-group">
                                    <span for="newPassword_confirmation" class="col-md-3" style="margin-top: 10px">验证码</span>
                                    <input class="col-md-4" type="text" name="cpt" value="" style="height: 35px;width: 40%!important;margin-right: 10px!important;">
                                    <div class="col-md-3" >
                                        <img src="{{ url('captcha/mews') }}" onclick="this.src='{{ url('captcha/mews') }}?r='+Math.random();"
                                             alt="" >
                                    </div>
                                </div>
                                <button class="btn btn-info btn-raised" style="margin-top: 10px;margin-left:45%;">保存</button>

                                {{--<input class="btn btn-primary submit" type="submit" value="确定">--}}
                            </div>

                        </form>

                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        if("{{ Cookie::get('message') }}" != ''){
            alert('{{ Cookie::get('message') }}');
            {{ Cookie::queue('message', null , -1) }}
        }
    </script>

</body>
</html>