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
                        <h3 class="panel-title">修改信息</h3>
                    </div>
                    <div class="panel-body">
                        <form action="/TeacherUserManage" method="post" id="infoForm">

                            <input type="hidden" name="_token" value="{!! csrf_token() !!}">
                            <div>
                                {{--<img src="assets/images/user.jpg" style="margin:0 auto; display: block;">--}}
                                <img src="assets/images/user.jpg" style="margin-bottom:30px; margin-left: 40%;">
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

                                <button class="btn btn-info btn-raised" style="margin-left: 45%;" >保存</button>
                                {{--<input class="btn btn-primary submit" type="submit" value="确定">--}}
                            </div>

                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        if("{{ Cookie::get('mess') }}" != ''){
            alert('{{ Cookie::get('mess') }}');
            {{ Cookie::queue('mess', null , -1) }}
        }
    </script>
</body>
</html>