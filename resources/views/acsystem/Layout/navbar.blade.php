<ul class="nav navbar-nav">
    @if (Auth::check())
        <li @if (Request::is('/activity/*')) class="active" @endif>
            <a href="/activity/index">我要报名</a>
        </li>
        <li @if (Request::is('/consult/*')) class="active" @endif>
            <a href="/consult/index">我要咨询</a>
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
                <li><a href="/auth/logout">更改密码</a></li>
            </ul>
            <ul class="dropdown-menu" role="menu">
                <li><a href="/auth/logout">个人信息</a></li>
            </ul>
            <ul class="dropdown-menu" role="menu">
                <li><a href="/auth/logout">Logout</a></li>
            </ul>
        </li>
    @endif
</ul>