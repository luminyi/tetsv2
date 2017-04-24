<div style="width: 860px; margin:0 auto;">
    <div class="form-group">
        <img src="assets/images/user.jpg" style="margin-bottom:30px;">
    </div>

    <div style="float: left;">
        <div class="form-group" style="display: none;">
            <input class="form-control" type="text" name="tid" id="tid" value="">
        </div>
        <div class="form-group">
            <span for="name">督导ID</span>
            <input class="form-control" name="user_id" type="text" id="user_id"
                   value="" readonly="readonly" required>
        </div>
        <div class="form-group">
            <span class="h4">性&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;别</span>
            <select class="form-control" name="sex" id="sex" style="display: inline-block!important;">
                <option>男</option>
                <option>女</option>
            </select>
        </div>

        <div class="form-group">
                                                <span class="h4">教师状态
                                                <select class="form-control" name="state" id="state" style="display: inline-block!important;">
                                                    <option>在职</option>
                                                    <option>退休</option>
                                                </select>
                                            </span>
        </div>
        <div class="form-group">
            <span for="phone">电话号码</span>
            <input class="form-control" name="phone" type="number" id="phone" value="">
        </div>
        <div class="form-group ">
            <span for="email">签约状态</span>
            <select class="form-control" name="status" id="status">
                <option>活跃</option>
                <option>不再担任督导</option>
            </select>
        </div>
        <div class="form-group">
                                                <span class="h4">督导类型
                                                    <select class="form-control" name="workstate" id="workstate" style="display: inline-block!important;">
                                                        <option>专职</option>
                                                        <option>兼职</option>
                                                    </select>
                                                </span>
        </div>
        <div class="form-group">
            <span for="name">开始学期</span>
            <input class="form-control" name="change_begin_time" type="text"
                   id="change_begin_time" value="" required>
        </div>
        <div class="form-group">
                                            <span class="h4">专业领域
                                                <input name="skill" id="skill" type="text" class="form-control add_task">
                                            </span>
        </div>

    </div>
    <div style="float: right">
        <div class="form-group">
            <span for="name">姓&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;名</span>
            <input class="form-control" name="account_name" type="text" id="account_name" value="" required >
        </div>

        <div class="form-group">
                                                <span class="h4">所属机构
                                                <select class="form-control add_task" type="text" name="unit" id="unit" style="display: inline-block!important;">
                                                    <option>校级行政部门</option>
                                                    <option>水保学院</option>
                                                    <option>理学院</option>
                                                    <option>材料学院</option>
                                                    <option>保护区学院</option>
                                                    <option>环境学院</option>
                                                    <option>生物学院</option>
                                                    <option>经管学院</option>
                                                    <option>工学院</option>
                                                    <option>信息学院</option>
                                                    <option>人文学院</option>
                                                    <option>外语学院</option>
                                                    <option>园林学院</option>
                                                    <option>艺设学院</option>
                                                    <option>林学院</option>
                                                    <option>体育教学部</option>
                                                    <option>马克思主义学院</option>
                                                    <option>其他</option>
                                                </select>
                                                </span>
        </div>
        <div class="form-group ">
            <span for="email">邮&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 箱</span>
            <input class="form-control input-small" name="email" type="email" id="email" value="">
        </div>
        <div class="form-group">
                                                <span class="h4">组&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;别
                                                    <input class="form-control input-small" name="group"  id="group" value="" readonly="readonly">

                                                    {{--<select class="form-control" name="group" id="group" style="display: inline-block!important;" readonly="readonly">--}}
                                                    {{--<option>第一组</option>--}}
                                                    {{--<option>第二组</option>--}}
                                                    {{--<option>第三组</option>--}}
                                                    {{--<option>第四组</option>--}}
                                                    {{--</select>--}}
                                                </span>
        </div>
        <div class="form-group">
                                                <span class="h4">职&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;称
                                                    <select class="form-control" name="ProRank" id="ProRank" style="display: inline-block!important;">
                                                        <option>教授</option>
                                                        <option>副教授</option>
                                                        <option>讲师</option>
                                                    </select>
                                                </span>
        </div>
        <div class="form-group">
            <span for="name">结束学期</span>
            <input class="form-control" name="change_end_time" type="text"
                   id="change_end_time" value="" required>
        </div>
    </div>
    <div class="form-group">
                                                <span class="h4">用户角色
                                                    <div>
                                                        <input type="checkbox" class="ace" name="xiaoji" id="xiaoji"value="1"/>
                                                        <span class="lbl"> 校级</span>
                                                    </div>
                                                    <div>
                                                        <input type="checkbox" class="ace" name="dazuzhang" id="dazuzhang"  value="1"/>
                                                        <span class="lbl"> 大组长</span>
                                                    </div>
                                                    <div>
                                                        <input type="checkbox" class="ace" name="xiaozuzhang" id="xiaozuzhang" value="1"/>
                                                        <span class="lbl"> 小组长</span>
                                                    </div>
                                                    <div>
                                                        <input type="checkbox" class="ace" name="dudao" id="dudao" value="1"/>
                                                        <span class="lbl"> 督导</span>
                                                    </div>

                                                </span>
    </div>

</div>