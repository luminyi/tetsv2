<table data-toggle="table" id="DoneTable"
       data-halign="center" data-align="center"
       data-show-pagination-switch="true"
       data-query-params="queryParams"
       data-pagination="true"
       data-search = "true"
       data-page-size="20"
       data-search-text="{{$term}}"
       data-url="/consult/adjust/done">
    <thead>
    <tr>
        <th data-field="Number" data-formatter="actionFormatterNumber" data-halign="center" data-align="center" >序号</th>
        <th data-field="username" data-halign="center" data-align="center" >申请人姓名</th>
        <th data-field="unit" data-halign="center" data-align="center" >申请人所在学院</th>
        <th data-field="name" data-halign="center" data-align="center">咨询名称</th>
        <th data-field="submit_time" data-halign="center" data-align="center">提交时间</th>
        <th data-field="term" data-halign="center" data-align="center">提交学期</th>
        <th data-field="phone" data-halign="center" data-align="center">联系方式</th>
        <th data-field="state" data-halign="center" data-align="center">协调状态</th>
        <th data-field="action" data-halign="center" data-align="center"
            data-formatter="ConsultInfo" data-events="actionEvents" >咨询详情</th>
    </tr>
    </thead>
</table>