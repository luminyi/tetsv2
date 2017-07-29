<ul class="nav navbar-nav">
    @if (Auth::check())
        <li @if (Request::is('activity/*')) class="active" @endif>
            <a href="/activity/index">我要报名</a>
        </li>
        <li @if (Request::is('consult/*')) class="active" @endif>
            <a href="/consult/index">我要咨询</a>
        </li>
        <li @if (Request::is('teachEvaluation/*')) class="active" @endif>
            <a href="/teachEvaluation/index">我的评价</a>
        </li>
        <li @if (session('role')!='教师') class="active">
            <a href="/index">教评平台</a>
            @endif
        </li>
    @endif
</ul>

<ul class="nav navbar-nav navbar-right">
    @if (Auth::guest())
        <li><a href="/auth/login">Login</a></li>
    @else
        <li class="dropdown">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button"
               aria-expanded="false">
                {{ Auth::user()->name }}
                <span class="caret"></span>
            </a>
            <ul class="dropdown-menu" role="menu">
                <li><a href="/TeacherChangePass">更改密码</a></li>
                <li><a href="/TeacherUserManage">个人信息</a></li>
                <li><a href="/logout">登出</a></li>

            </ul>
        </li>
    @endif
</ul>