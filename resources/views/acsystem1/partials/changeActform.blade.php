<div class="form-group">
    <label for="nameChange" class="col-md-2 control-label">活动名称</label>
    <div class="col-md-9">
        <input type="text" class="form-control" name="nameChange" id="nameChange" value=""
               autofocus>
    </div>
</div>

<div class="form-group">
    <label for="teacherChange" class="col-md-2 control-label">
        主讲教师
    </label>
    <div class="col-md-3">
        <input type="text" class="form-control" name="teacherChange" id="teacherChange" value="">
    </div>

    <label for="start_time" class="col-md-2 control-label col-md-offset-1">
        &nbsp;&nbsp;开始时间
    </label>
    <div class="col-md-3 ">
        <input type="text" class="form-control" name="start_timeChange" id="start_timeChange" value="">
    </div>

</div>

<div class="form-group">
    <label for="placeChange" class="col-md-2  control-label">
        活动地点
    </label>
    <div class="col-md-3">
        <input type="text" class="form-control" name="placeChange" id="placeChange" value="">
    </div>

    <label for="end_timeChange" class="col-md-2 control-label col-md-offset-1">
        &nbsp;&nbsp;结束时间
    </label>
    <div class="col-md-3 ">
        <input type="text" class="form-control" name="end_timeChange" id="end_timeChange" value="">
    </div>
</div>

<div class="form-group">
    <label for="termChange" class="col-md-2 control-label">
        活动学期
    </label>
    <div class="col-md-3">
        <input type="text" class="form-control" name="termChange" id="termChange" value="">
    </div>

    <label for="all_numChange" class="col-md-2 control-label col-md-offset-1">
       活动人数
    </label>
    <div class="col-md-3 ">
        <input type="text" class="form-control" name="all_numChange" id="all_numChange" value="">
    </div>
</div>

<div class="form-group">
    <label for="informationChange" class="col-md-2 control-label">
        活动详情
    </label>
    <div class="col-md-9">
        <textarea class="form-control" id="informationChange" name="informationChange">
        </textarea>
    </div>
</div>


<div class="form-group">
    <label for="stateChange" class="col-md-2 control-label">
        活动状态
    </label>
    <div class="col-md-9">
        <label class="radio-inline col-md-3">
            <input type="radio" name="stateChange"
                   checked="checked"
                   value="未开始">
            未开始
        </label>
        <label class="radio-inline col-md-3">
            <input type="radio" name="stateChange"
                   {{--checked="checked"--}}
                   value="正在进行">
            正在进行
        </label>
        <label class="radio-inline col-md-3">
            <input type="radio" name="stateChange"
                   {{--checked="checked"--}}
                   value="已结束">
            已结束
        </label>
    </div>
</div>