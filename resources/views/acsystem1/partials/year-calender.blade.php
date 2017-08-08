<input id="year-calender" type="text" data-field="date" readonly >

<div id="year-dtBox" class="dtpicker-overlay dtpicker-mobile" style="display: none;">
    <div class="dtpicker-bg">
        <div class="dtpicker-cont">
            <div class="dtpicker-content">
                <div class="dtpicker-subcontent">

                    <div class="dtpicker-header">
                        <div class="dtpicker-title">选择学期</div>
                        <a class="dtpicker-close">×</a>
                        <!--<div class="dtpicker-value"></div>-->
                    </div>

                    <div class="dtpicker-components">
                        <div class="dtpicker-compOutline dtpicker-comp3">
                            <div class="dtpicker-comp year-class">
                                <a id="year1-plus" class="dtpicker-compButton increment">+</a>
                                <input id="year-year1" type="text" class="dtpicker-compValue" maxlength="4">
                                <a id="year1-minus" class="dtpicker-compButton decrement">-</a>
                            </div>
                        </div>

                        <div class="dtpicker-compOutline dtpicker-comp3">
                            <div class="dtpicker-comp ">
                                <a class="dtpicker-compButton increment "></a>
                                <input id="year-year2" type="text" class="dtpicker-compValue" disabled="disabled">
                                <a class="dtpicker-compButton decrement "></a>
                            </div>
                        </div>
                        <div class="dtpicker-compOutline dtpicker-comp3" style="display: none">
                            <div class="dtpicker-comp ">
                                <a class="dtpicker-compButton increment dtpicker-compButtonEnable">+</a>
                                <input id="year-terminal" type="text" class="dtpicker-compValue" disabled="disabled">
                                <a class="dtpicker-compButton decrement dtpicker-compButtonEnable">-</a>
                            </div>
                        </div>

                    </div>

                    <div class="dtpicker-buttonCont dtpicker-twoButtons">
                        <a id="year-sure" class="dtpicker-button dtpicker-buttonSet">确定</a>
                        <a class="dtpicker-button dtpicker-buttonClear">取消</a>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>