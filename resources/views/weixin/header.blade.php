<nav class="navbar navbar-default">
    <div class="container-fluid">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar-menu">
                <span class="sr-only">Toggle Navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="#">北京林业大学教评中心业务平台</a>
        </div>
        <div class="collapse navbar-collapse" id="navbar-menu">
            <ul class="nav navbar-nav">
                @if (Auth::check())
                    <li @if (Request::is('activity/*')) class="active" @endif>
                        <a href="/weixinTheoryEvaluationTableView"> 理论课评价用表</a>
                    </li>
                    <li @if (Request::is('consult/*')) class="active" @endif>
                        <a href="/weixinPracticeEvaluationTableView">实践课评价用表</a>
                    </li>
                    <li @if (Request::is('teachEvaluation/*')) class="active" @endif>
                        <a href="/weixinPhysicalEvaluationTableView">体育课评价用表</a>
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
                            <li><a href="/weixinChangePass">更改密码</a></li>
                            <li><a href="/weixinUserManage">个人信息</a></li>
                            <li><a href="/logout">登出</a></li>

                        </ul>
                    </li>
                @endif
            </ul>
        </div>
    </div>
</nav>