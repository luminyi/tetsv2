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

                        <form class="form-horizontal" role="form" method="POST" action="/admin/tag">
                            <input type="hidden" name="_token" value="{{ csrf_token() }}">
                            <div class="form-group">
                                <label for="reverse_direction" class="col-md-3 control-label">
                                    咨询类别
                                </label>
                                <div class="col-md-7">
                                    <label class="radio-inline">
                                        <input type="radio" name="ConsultType" id="OneToOne"
                                               checked=""
                                               value="0">
                                        寻求一对一指导
                                    </label>
                                    <label class="radio-inline">
                                        <input type="radio" name="ConsultType" id="TeachRequest"
                                               checked=""
                                               value="1">
                                        教学困惑咨询
                                    </label>
                                    <label class="radio-inline">
                                        <input type="radio" name="ConsultType" id="TrainRequest"
                                               checked=""
                                               value="2">
                                        培训需求提交
                                    </label>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="phone" class="col-md-3 control-label">
                                    电话
                                </label>
                                <div class="col-md-8">
                                    <input type="tel" class="form-control" name="phone" id="phone" value="">
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="meta_description" class="col-md-3 control-label">
                                    活动细节(选填)
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
                        <table id="tags-table" class="table table-striped table-bordered">
                        <thead>
                    <tr>
                        <th>ID</th>
                        <th>提交时间</th>
                        <th class="hidden-sm">咨询类别</th>
                        <th data-sortable="false">咨询详情</th>
                    </tr>
                    </thead>
                        <tbody>
                        {{--@foreach ($tags as $tag)--}}
                        <tr>
                            <td>1</td>
                            <td>2</td>
                            <td class="hidden-sm">3</td>
                            <td>
                                <a href="/admin/tag/8/edit" class="btn btn-xs btn-info">
                                    <i class="fa fa-edit"></i> Edit
                                </a>
                            </td>
                        </tr>
                        {{--@endforeach--}}
                        </tbody>
                </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@stop

@section('scripts')
    <script>
        $(function() {
            $("#tags-table").DataTable({
            });
        });
    </script>
@stop