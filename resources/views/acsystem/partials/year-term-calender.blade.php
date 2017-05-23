<input id="year-term-calender" type="text" data-field="date" readonly>

<div id="year-term-dtBox" class="dtpicker-overlay dtpicker-mobile" style="display: none;">
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
                                <a id="year1-term-plus" class="dtpicker-compButton increment">+</a>
                                <input id="year-term-year1" type="text" class="dtpicker-compValue" maxlength="4">
                                <a id="year1-term-minus" class="dtpicker-compButton decrement">-</a>
                            </div>
                        </div>

                        <div class="dtpicker-compOutline dtpicker-comp3">
                            <div class="dtpicker-comp ">
                                <a class="dtpicker-compButton increment "></a>
                                <input id="year-term-year2" type="text" class="dtpicker-compValue" disabled="disabled">
                                <a class="dtpicker-compButton decrement "></a>
                            </div>
                        </div>

                        <div class="dtpicker-compOutline dtpicker-comp3">
                            <div class="dtpicker-comp ">
                                <a class="dtpicker-compButton increment dtpicker-compButtonEnable">+</a>
                                <input id="year-term-terminal" type="text" class="dtpicker-compValue" disabled="disabled">
                                <a class="dtpicker-compButton decrement dtpicker-compButtonEnable">-</a>
                            </div>
                        </div>
                    </div>

                    <div class="dtpicker-buttonCont dtpicker-twoButtons">
                        <a id="year-term-sure" class="dtpicker-button dtpicker-buttonSet">确定</a>
                        <a class="dtpicker-button dtpicker-buttonClear">取消</a>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>