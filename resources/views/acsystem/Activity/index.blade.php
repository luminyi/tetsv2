@extends('ACSystem.Layout.layout')

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h3 class="panel-title">活动概览</h3>
                    </div>
                    <div class="panel-body">

                        <table id="activity-table" class="table table-striped table-bordered">
                            <thead>
                            <tr>
                                <th>活动题目</th>
                                <th>活动时间</th>
                                <th class="hidden-sm">活动地点</th>
                                <th data-sortable="false">活动信息</th>
                                <th data-sortable="false">活动状态</th>
                            </tr>
                            </thead>
                            <tbody>
                            {{--@foreach ($tags as $tag)--}}
                            <tr>
                                <td>1</td>
                                <td>2</td>
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
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h3 class="panel-title">我参加过的活动</h3>
                    </div>
                    <div class="panel-body">

                        <table id="history-table" class="table table-striped table-bordered">
                            <thead>
                            <tr>
                                <th>活动题目</th>
                                <th>活动时间</th>
                                <th class="hidden-sm">活动地点</th>
                                <th data-sortable="false">活动信息</th>
                                <th data-sortable="false">活动状态</th>
                            </tr>
                            </thead>
                            <tbody>
                            {{--@foreach ($tags as $tag)--}}
                            <tr>
                                <td>1</td>
                                <td>2</td>
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