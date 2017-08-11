@extends('acsystem.Layout.layout')

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-10 col-md-offset-1">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h3 class="panel-title">活动概览</h3>
                    </div>
                    <div class="panel-body">

                        <table data-toggle="table" id="activity-table"
                               data-halign="center" data-align="center"
                               data-url="/activity/teacher/show/{{ Auth::User()->id}}">
                            <thead>
                            <tr>
                                <th data-field="Number" data-formatter="actionFormatterNumber" data-halign="center" data-align="center" >序号</th>
                                <th data-field="name" data-halign="center" data-align="center">活动名称</th>
                                <th data-field="teacher" data-halign="center" data-align="center">主讲人</th>
                                <th data-field="place" data-halign="center" data-align="center">活动地点</th>
                                <th data-field="start_time" data-halign="center" data-align="center">活动开始时间</th>
                                <th data-field="end_time" data-halign="center" data-align="center">活动结束时间</th>
                                <th data-field="apply_start_time" data-halign="center" data-align="center">报名开始时间</th>
                                <th data-field="apply_end_time" data-halign="center" data-align="center">报名结束时间</th>
                                <th data-field="remainder_num" data-halign="center" data-align="center">剩余名额</th>
                                <th data-field="apply_state" data-halign="center" data-align="center">报名状态</th>
                                <th data-field="action" data-halign="center" data-align="center"
                                    data-formatter="activityInfo" data-events="actionEvents" >活动详情</th>
                                <th data-field="attend" data-halign="center" data-align="center"
                                    data-formatter="attendInfo" data-events="actionEvents" >报名情况</th>
                            </tr>
                            </thead>
                        </table>
                    </div>
                </div>
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h3 class="panel-title">我参加过的活动</h3>
                    </div>
                    <div class="panel-body">
                        <table data-toggle="table" id="history-table"
                               data-halign="center" data-align="center"
                               data-search="true"
                               data-url="/activity/teacher/attend/{{ Auth::User()->id }}">
                            <thead>
                            <tr>
                                <th data-field="Number" data-formatter="actionFormatterNumber" data-halign="center" data-align="center" >序号</th>
                                <th data-field="name" data-halign="center" data-align="center">活动名称</th>
                                <th data-field="teacher" data-halign="center" data-align="center">主讲人</th>
                                <th data-field="place" data-halign="center" data-align="center">活动地点</th>
                                <th data-field="state" data-halign="center" data-align="center">活动状态</th>
                                <th data-field="term" data-halign="center" data-align="center">活动学期</th>
                                <th data-field="action" data-halign="center" data-align="center"
                                    data-formatter="activityInfo" data-events="actionEvents" >活动详情</th>
                            </tr>
                            </thead>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">

            <button id="check-activity" data-toggle="modal" data-target="#checkout-activity" style="display: none">
                查看活动
            </button>
            <!-- 查看详情的 模态框（Modal） -->
            <div class="modal fade" id="checkout-activity" tabindex="-1" role="dialog" aria-hidden="true">
                <div id="#add-activity-modal" class="modal-dialog" style="margin-top: 10%">
                    <div class="modal-content">
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                <h2 class="panel-title">活动详情
                                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
                                        &times;
                                    </button>
                                </h2>
                            </div>
                            <div class="panel-body">
                                <div class="row">
                                    <p><span style="font-weight: bold;">活动名称：&nbsp;&nbsp;</span>
                                        <span id="act-name" ></span>
                                    </p>
                                    <p><span style="font-weight: bold;">活动地点：&nbsp;&nbsp;</span>
                                        <span id="act-place" ></span>
                                    </p>
                                    <p><span style="font-weight: bold;">活动时间：&nbsp;&nbsp;</span>
                                        <span id="act-time" ></span>
                                    </p>
                                    <p><span style="font-weight: bold;">活动信息：&nbsp;&nbsp;</span>
                                        <span id="act-info" ></span>
                                    </p>
                                </div>
                            </div>
                        </div>

                    </div><!-- /.modal-content -->
                </div><!-- /.modal -->
            </div>

        </div>
    </div>
    <script>
        var userId='{{Auth::User()->id}}';
    </script>
    <script src="{{asset('js/activity/index.js')}}"></script>


@stop