@extends('ACSystem.Layout.layout')

@section('content')
    <div class="container-fluid">


        <div class="row">
            <div class="col-md-5 col-md-offset-1" >
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h3 class="panel-title">提交咨询</h3>
                    </div>
                    <div class="panel-body">

                        @include('ACSystem.partials.errors')
                        @include('acsystem.partials.success')

                        <form class="form-horizontal" role="form" method="POST" action="/consult/post">
                            <input type="hidden" name="_token" value="{{ csrf_token() }}">
                            <div class="form-group">
                                <label for="reverse_direction" class="col-md-3 control-label">
                                    咨询类别
                                </label>
                                <div class="col-md-7">
                                    @foreach($consultType as $consult)
                                        <label class="radio-inline">
                                            <input type="radio" name="consults_type_id"
                                                   checked=""
                                                   value="{{$consult->id}}">
                                            {{$consult->name}}
                                        </label>
                                    @endforeach
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="phone" class="col-md-3 control-label">
                                    电话
                                </label>
                                <div class="col-md-8">
                                    <input type="tel" class="form-control" name="phone" id="phone" value="{{$phone}}">
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="meta_description" class="col-md-3 control-label">
                                    咨询细节(选填)
                                </label>
                                <div class="col-md-8">
                                    <textarea class="form-control" id="meta_description" name="meta_description" rows="20">
                                    </textarea>
                                </div>
                            </div>

                            <div class="form-group">
                                <div class="col-md-7 col-md-offset-3">
                                    <button type="submit" class="btn btn-primary btn-md">
                                        <i class="fa fa-plus-circle"></i>
                                        确定
                                    </button>
                                </div>
                            </div>

                        </form>

                    </div>
                </div>
            </div>
            <div class="col-sm-5">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h3 class="panel-title">历史咨询</h3>
                    </div>
                    <div class="panel-body">
                        <table data-toggle="table" id="consultTable"
                               data-halign="center" data-align="center"
                               data-search="true"
                               data-url="/consult/ConsultHistory/{{Auth::User()->id}}">
                            <thead>
                            <tr>
                                <th data-field="Number" data-formatter="actionFormatterNumber" data-halign="center" data-align="center" >序号</th>
                                <th data-field="name" data-halign="center" data-align="center">咨询名称</th>
                                <th data-field="submit_time" data-halign="center" data-align="center">提交时间</th>
                                <th data-field="state" data-halign="center" data-align="center">协调状态</th>
                                <th data-field="action" data-halign="center" data-align="center"
                                    data-formatter="ConsultInfo" data-events="actionEvents" >咨询详情</th>
                            </tr>
                            </thead>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">

            <button id="check-consult" data-toggle="modal" data-target="#checkout-consult" style="display: none">
                查看活动
            </button>
            <!-- 查看详情的 模态框（Modal） -->
            <div class="modal fade" id="checkout-consult" tabindex="-1" role="dialog" aria-hidden="true">
                <div id="#add-activity-modal" class="modal-dialog" style="width:50%; margin-top: 10%">
                    <div class="modal-content">
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                <h2 class="panel-title">咨询详情
                                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
                                        &times;
                                    </button>
                                </h2>
                            </div>
                            <div class="panel-body">
                                <div class="row">
                                    <p><span style="font-weight: bold;">咨询名称：&nbsp;&nbsp;</span>
                                        <span id="act-name" ></span>
                                    </p>
                                    <p><span style="font-weight: bold;">其他信息：&nbsp;&nbsp;</span>
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

@stop

@section('scripts')
    <script src="/js/consult/index.js"></script>
@stop