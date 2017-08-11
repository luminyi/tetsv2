<div class="form-group">
    <label for="name" class="col-md-2 control-label">活动名称</label>
    <div class="col-md-9">
        <input type="text" class="form-control" name="name" id="name" value="{{ $name }}"
               autofocus>
    </div>
</div>

<div class="form-group">
    <label for="teacher" class="col-md-2 control-label">
        主讲教师
    </label>
    <div class="col-md-4">
        <input type="text" class="form-control" name="teacher" id="teacher" value="{{ $teacher }}">
    </div>

    <label for="place" class="col-md-2  control-label">
        活动地点
    </label>
    <div class="col-md-4">
        <input type="text" class="form-control" name="place" id="place" value="{{ $place }}">
    </div>

</div>

<div class="form-group">
    <label for="term" class="col-md-2 control-label">
        活动学期
    </label>
    <div class="col-md-4">
        <input type="text" class="form-control" name="term" id="term" value="{{ $term }}">
    </div>

    <label for="all_num" class="col-md-2 control-label">
        活动人数
    </label>
    <div class="col-md-4 ">
        <input type="text" class="form-control" name="all_num" id="all_num" value="{{ $all_num }}">
    </div>
</div>

<div class="form-group">

    <label for="start_time" class="col-md-2 control-label ">
        &nbsp;&nbsp;活动开始时间
    </label>
    <div class="col-md-4 ">
        <input type="text" class="form-control" name="start_time" id="start_time" value="{{ $start_time }}">
    </div>

    <label for="end_time" class="col-md-2 control-label">
        &nbsp;&nbsp;活动结束时间
    </label>
    <div class="col-md-4 ">
        <input type="text" class="form-control" name="end_time" id="end_time" value="{{ $end_time }}">
    </div>
</div>

<div class="form-group">

    <label for="apply_start_time" class="col-md-2 control-label ">
        &nbsp;&nbsp;报名开始时间
    </label>
    <div class="col-md-4 ">
        <input type="text" class="form-control" name="apply_start_time" id="apply_start_time" value="{{ $apply_start_time }}">
    </div>

    <label for="apply_end_time" class="col-md-2 control-label">
        &nbsp;&nbsp;报名结束时间
    </label>
    <div class="col-md-4 ">
        <input type="text" class="form-control" name="apply_end_time" id="apply_end_time" value="{{ $apply_end_time }}">
    </div>
</div>

<div class="form-group">
    <label for="information" class="col-md-2 control-label">
        活动详情
    </label>
    <div class="col-md-9">
        <textarea class="form-control" id="information" name="information">
            {{ $information }}
        </textarea>
    </div>
</div>


<div class="form-group">
    <label for="apply_state" class="col-md-2 control-label">
        报名状态
    </label>
    <div class="col-md-9">
        <label class="radio-inline col-md-3">
            <input type="radio" name="apply_state"
                   checked="checked"
                   value="未开始">
            未开始
        </label>
        <label class="radio-inline col-md-3">
            <input type="radio" name="apply_state"
                   {{--checked="checked"--}}
                   value="正在进行">
            正在进行
        </label>
        <label class="radio-inline col-md-3">
            <input type="radio" name="apply_state"
                   {{--checked="checked"--}}
                   value="已结束">
            报名结束
        </label>
    </div>
</div>