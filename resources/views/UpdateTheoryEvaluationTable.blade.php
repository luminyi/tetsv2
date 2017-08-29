<!DOCTYPE html>
<meta name="render" content="webkit|ie-comp|ie-stand">
<meta http-equiv="X-UA-Compatible" content="IE=11">
<html lang="en">
{{--<link rel="stylesheet" href="css/Theory.css" />--}}

<head>
    <meta charset="utf-8" />
    <title>北林教学评价系统</title>
    <meta name="keywords" content="北林教学评价系统" />
    <meta name="description" content="北林教学评价系统" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <!-- basic styles -->
    {{--<link href="assets/css/bootstrap.min.css" rel="stylesheet" />--}}

    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="css/bootstrap-theme.min.css" rel="stylesheet">
    <link href="css/codemirror.css" rel="stylesheet">
    <link href="css/form_builder.css" rel="stylesheet">

    <link rel="stylesheet" href="assets/css/font-awesome.min.css" />
    <link rel="stylesheet" href="assets/css/dashboard.css" />
    <link rel="stylesheet" href="assets/css/evaluation-table.css" />
    <link rel="stylesheet" href="assets/css/bootstrap-material-btndesign.css" />
    <!--[if IE 7]>
    <link rel="stylesheet" href="assets/css/font-awesome-ie7.min.css" />
    <![endif]-->

    <!--[if lt IE 9]>
    <script src="assets/js/html5shiv.js"></script>
    <script src="assets/js/respond.min.js"></script>
    <![endif]-->

</head>
<style>
    .col-lg-1{
        width: 6.7%!important;
        float:left!important;
        padding-left:10px!important;
        padding-right:0!important;
        text-align: center;
    }
    .col-sm-1 {
        width: 10.33333%!important;
    }
    .nav-tabs>li>a, .nav-tabs>li>a:focus {
        border-radius: 0!important;
        background-color: #f9f9f9;
        color: #999;
        margin-right: -1px;
        line-height: 16px;
        position: relative;
        z-index: 11;
        border-color: #c5d0dc;
    }
</style>

{{--日历相关--}}
<link rel="stylesheet" href="calendar1/css/bootstrap-datetimepicker.css" />

<!--[if lt IE 9]>
<link rel="stylesheet" type="text/css" href="calendar/DateTimePicker-ltie9.css" />
<script type="text/javascript" src="calendar/DateTimePicker-ltie9.js"></script>
<![endif]-->
<script src="assets/js/jquery-2.0.3.min.js"></script>
<script src="assets/js/bootstrap.min.js"></script>
<script src="js/jquery.min.js"></script>
<script src="js/jquery-ui.min.js"></script>
<script src="js/bootstrap.min.js"></script>
<script src="js/form_builder.min.js"></script>
<script src="js/codemirror.min.js"></script>
<script src="js/formatting.js"></script>
<body onLoad="isReady=true">

@include('layout.header')

<div class="container-fluid clearfix">
    <div class="row clearfix">
        @include('layout.sidebar')
                <!-- 面板开始 -->
        <div class="col-sm-10 col-sm-offset-2 col-md-10 col-md-offset-2"  style="margin-top: 20px">
            <div class="page-content form-content">
                <div class="page-box">
                    <div class="panel panel-success">
                        <div class="panel-heading">
                            <p style="font-size:20px; " class="panel-title">北京林业大学本科教学督导听课评价表(理论课评价用表)</p>
                        </div>
                        <div class="panel-body">
                            <div class="alert alert-danger" style="font-size: 19px; text-align: center;">
                                <strong>  &nbsp;&nbsp;&nbsp;&nbsp; 规则：<br></strong>
                                （1）二级元素放置前必须至少放置一个一级元素<br>
                                （2）三级元素放置前必须至少放置一个二级元素<br>
                                （3）一级元素中的“其他”不能有任何子二级元素，三级元素<br>
                                （4）二级元素中，除了“二级标题”外，其他二级元素不能有任何子三级元素<br>
                            </div>



                            <ul id="myTab" class="nav nav-tabs">
                                <li class="active"><a href="#front" data-toggle="tab">评价表正面</a></li>
                                <li><a href="#back" data-toggle="tab" >评价表背面</a></li>
                            </ul>
                            <div id="myTabContent" class="tab-content content-font" style="padding-bottom: 70px">
                                <div class="tab-pane fade in active" id="front">
                                    <!-- Options Modal -->
                                    <div class="modal fade" id="options_modal1" tabindex="-1" role="dialog" aria-labelledby="options_modal_label" aria-hidden="true">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                                    <h4 class="modal-title" id="options_modal_label">Options</h4>
                                                </div>
                                                <div class="modal-body1"></div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-primary" id="save_options1">保存</button>
                                                    <button type="button" class="btn btn-default" data-dismiss="modal">关闭</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-lg-offset-1 col-sm-10 col-md-10">
                                            <div class="row">
                                                <div class="col-sm-6 col-md-6">
                                                    <h1>正面评价表</h1>
                                                    <hr>
                                                    <div class="tabbable">
                                                        <ul class="nav nav-tabs">
                                                        </ul>

                                                        <div class="tab-content">
                                                            <div class="tab-pane active" id="editor-tab">
                                                                <form id="content1" class="form-horizontal">
                                                                    <fieldset id="content_form_name">
                                                                        <legend>

                                                                        </legend>
                                                                    </fieldset>
                                                                </form>
                                                            </div>

                                                            <div class="tab-pane" id="source-tab">
                                                                <textarea id="source"></textarea>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="col-sm-6 col-md-6">
                                                    <h1>组件</h1>
                                                    <hr>
                                                    <div id="components-container" class="form-horizontal">

                                                        <div>
                                                            <label>1级元素：</label>
                                                        </div>

                                                        <div class="component1 form-group" data-type="static_text">
                                                            <label class="control-label col-sm-4">1级内容</label>
                                                            <div class="controls col-sm-8">
                                                                教师授课情况
                                                            </div>
                                                        </div>

                                                        <div>
                                                            <label>2级元素：</label>
                                                        </div>

                                                        <div class="component1 form-group" data-type="static_text">
                                                            <label class="control-label col-sm-4">2级内容</label>
                                                            <div class="controls col-sm-8">
                                                                授课态度
                                                            </div>
                                                        </div>

                                                        <div class="component1 form-group" data-type="radio">
                                                            <label class="control-label col-sm-4">单选</label>
                                                            <div class="controls col-sm-8">
                                                                <input type="text" name="" id="radio_text_input" placeholder="placeholder" class="form-control">
                                                                <div class="radio"><label class="" for="radio_1">
                                                                        <input type="radio" name="radio" id="radio_1">
                                                                        表现相当好
                                                                    </label></div>
                                                                <div class="radio"><label class="" for="radio_2">
                                                                        <input type="radio" name="radio" id="radio_2">
                                                                        表现不错
                                                                    </label></div>
                                                                <div class="radio"><label class="" for="radio_3">
                                                                        <input type="radio" name="radio" id="radio_3">
                                                                        表现还可以
                                                                    </label></div>
                                                            </div>
                                                        </div>

                                                        <div class="component1 form-group" data-type="checkbox">
                                                            <label class="control-label col-sm-4">多选</label>
                                                            <div class="controls col-sm-8">
                                                                <input type="text" name="" id="checkbox_text_input" placeholder="placeholder" class="form-control">
                                                                <div class="checkbox"><label class="" for="checkbox_1">
                                                                        <input type="checkbox" name="checkbox" id="checkbox_1">
                                                                        教师很投入
                                                                    </label></div>
                                                                <div class="checkbox"><label class="" for="checkbox_2">
                                                                        <input type="checkbox" name="checkbox" id="checkbox_2">
                                                                        教师有很好的讲授能力
                                                                    </label></div>
                                                                <div class="checkbox"><label class="" for="checkbox_3">
                                                                        <input type="checkbox" name="checkbox" id="checkbox_3">
                                                                        教师很有教学经验，能融合应用多方面理论与知识
                                                                    </label></div>
                                                            </div>
                                                        </div>

                                                        <div class="component1 form-group" data-type="textarea">
                                                            <label class="control-label col-sm-4" for="textarea">评述</label>
                                                            <div class="controls col-sm-8">
                                                                <textarea name="" class="form-control" id="textarea" placeholder="placeholder"></textarea>
                                                            </div>
                                                        </div>

                                                        <div>
                                                            <label>3级元素：</label>
                                                        </div>

                                                        <div class="component1 form-group" data-type="static_text">
                                                            <label class="control-label col-sm-4">3级内容</label>
                                                            <div class="controls col-sm-8">
                                                                仪表庄重、大方
                                                            </div>
                                                        </div>

                                                        <div>
                                                            <button type="button" class="btn btn-default" onclick="javascript:window.history.back();">退出修改</button>
                                                        </div>

                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="tab-pane fade" id="back">
                                    <!-- Options Modal -->
                                    <div class="modal fade" id="options_modal2" tabindex="-1" role="dialog" aria-labelledby="options_modal_label" aria-hidden="true">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                                    <h4 class="modal-title" id="options_modal_label">Options</h4>
                                                </div>
                                                <div class="modal-body2"></div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-primary" id="save_options2">保存</button>
                                                    <button type="button" class="btn btn-default" data-dismiss="modal">关闭</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-lg-offset-1 col-sm-10 col-md-10">
                                            <div class="row">
                                                <div class="col-sm-6 col-md-6">
                                                    <h1>背面评价表</h1>
                                                    <hr>
                                                    <div class="tabbable">
                                                        <ul class="nav nav-tabs">
                                                        </ul>

                                                        <div class="tab-content">
                                                            <div class="tab-pane active" id="editor-tab">
                                                                <form id="content2" class="form-horizontal">
                                                                    <fieldset id="content_form_name">
                                                                        <legend>

                                                                        </legend>
                                                                    </fieldset>
                                                                </form>
                                                            </div>

                                                            <div class="tab-pane" id="source-tab">
                                                                <textarea id="source"></textarea>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="col-sm-6 col-md-6">
                                                    <h1>组件</h1>
                                                    <hr>
                                                    <div id="components-container" class="form-horizontal">

                                                        <div>
                                                            <label>1级元素：</label>
                                                        </div>

                                                        <div class="component2 form-group" data-type="static_text">
                                                            <label class="control-label col-sm-4">1级内容</label>
                                                            <div class="controls col-sm-8">
                                                                教师授课情况
                                                            </div>
                                                        </div>

                                                        <div>
                                                            <label>2级元素：</label>
                                                        </div>

                                                        <div class="component2 form-group" data-type="static_text">
                                                            <label class="control-label col-sm-4">2级内容</label>
                                                            <div class="controls col-sm-8">
                                                                授课态度
                                                            </div>
                                                        </div>

                                                        <div class="component2 form-group" data-type="radio">
                                                            <label class="control-label col-sm-4">单选</label>
                                                            <div class="controls col-sm-8">
                                                                <input type="text" name="" id="radio_text_input" placeholder="placeholder" class="form-control">
                                                                <div class="radio"><label class="" for="radio_1">
                                                                        <input type="radio" name="radio" id="radio_1">
                                                                        表现相当好
                                                                    </label></div>
                                                                <div class="radio"><label class="" for="radio_2">
                                                                        <input type="radio" name="radio" id="radio_2">
                                                                        表现不错
                                                                    </label></div>
                                                                <div class="radio"><label class="" for="radio_3">
                                                                        <input type="radio" name="radio" id="radio_3">
                                                                        表现还可以
                                                                    </label></div>
                                                            </div>
                                                        </div>

                                                        <div class="component2 form-group" data-type="checkbox">
                                                            <label class="control-label col-sm-4">多选</label>
                                                            <div class="controls col-sm-8">
                                                                <input type="text" name="" id="checkbox_text_input" placeholder="placeholder" class="form-control">
                                                                <div class="checkbox"><label class="" for="checkbox_1">
                                                                        <input type="checkbox" name="checkbox" id="checkbox_1">
                                                                        教师很投入
                                                                    </label></div>
                                                                <div class="checkbox"><label class="" for="checkbox_2">
                                                                        <input type="checkbox" name="checkbox" id="checkbox_2">
                                                                        教师有很好的讲授能力
                                                                    </label></div>
                                                                <div class="checkbox"><label class="" for="checkbox_3">
                                                                        <input type="checkbox" name="checkbox" id="checkbox_3">
                                                                        教师很有教学经验，能融合应用多方面理论与知识
                                                                    </label></div>
                                                            </div>
                                                        </div>



                                                        <div class="component2 form-group" data-type="textarea">
                                                            <label class="control-label col-sm-4" for="textarea">评述</label>
                                                            <div class="controls col-sm-8">
                                                                <textarea name="" class="form-control" id="textarea" placeholder="placeholder"></textarea>
                                                            </div>
                                                        </div>

                                                        <div>
                                                            <label>3级元素：</label>
                                                        </div>

                                                        <div class="component2 form-group" data-type="static_text">
                                                            <label class="control-label col-sm-4">3级内容</label>
                                                            <div class="controls col-sm-8">
                                                                仪表庄重、大方
                                                            </div>
                                                        </div>

                                                        <div>
                                                            <button type="submit" class="btn btn-primary submitTable">提交评价表</button>
                                                            <button type="button" class="btn btn-default" onclick="javascript:window.history.back();">退出修改</button>
                                                        </div>

                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- .page-content 结束 -->
        </div>
        <!-- 面板结束 -->
    </div>
</div>
@include('layout.footer')
</body>
<script>
    $('.submitTable').click(function(){
        GetContent();
    });
    function GetContent(LessonState) {
        var Prelevel=0;
        var ok=true;
        var CSSstyle, Text, Level, ok, fid;
        var Frontlist=[];
        var Backlist=[];
        var object;

        for(var i=1;ok&&i<$('#content1').children().length;i++)
        {

            if($('#content1').children()[i].getAttribute('data-type')=="static_text")
            {
                CSSstyle=1;
                Level=parseInt($($('#content1').children()[i]).children()[1].innerText.charAt(0));
                Text=$($('#content1').children()[i]).children()[2].innerText;
                fid=0;
                if(Prelevel==0)
                        if(Level==1)
                            Prelevel=1;
                        else
                        {
                            ok=false;
                            alert('请至少放置一个一级标题');
                            break;
                        }
                switch(Prelevel)
                {
                    case 1:
                        if(Level==1);
                        if(Level==2)fid=i-1;
                        if(Level==3)
                        {
                            ok=false;
                            alert('一级标题后不能越级跟三级标题');
                            break;
                        }
                        break;
                    case 2:
                        if(Level==1);
                        if(Level==2)
                        {
                            var j;
                            for(j=Frontlist.length-1;j>=0;j--)
                                if(Frontlist[j].cssstyle==1&&Frontlist[j].level==1)break;
                            if(j<0)
                            {
                                ok=false;
                                alert('二级标题前请至少放置一个一级标题');
                                break;
                            }
                            fid=j+1;
                        }
                        if(Level==3)fid=i-1;
                        break;
                    case 3:
                        if(Level==1);
                        if(Level==2)
                        {
                            var j;
                            for(j=Frontlist.length-1;j>=0;j--)
                                if(Frontlist[j].cssstyle==1&&Frontlist[j].level==1)break;
                            if(j<0)
                            {
                                ok=false;
                                alert('二级标题前请至少放置一个一级标题');
                                break;
                            }
                            fid=j+1;
                        }
                        if(Level==3)
                        {
                            var j;
                            for(j=Frontlist.length-1;j>=0;j--)
                                if(Frontlist[j].cssstyle==1&&Frontlist[j].level==2)break;
                            if(j<0)
                            {
                                ok=false;
                                alert('三级标题前请至少放置一个二级标题');
                                break;
                            }
                            fid=j+1;
                        }
                        break;
                    default:
                        ok=false;
                        alert('请至少放置一个一级标题');
                        break;
                }
                object=
                {
                    datatype:"static-text",
                    fid:fid+1,
                    id:i+1,
                    level:Level,
                    cssstyle:CSSstyle,
                    text:Text
                };
                Frontlist.push(object);
            }
            if($('#content1').children()[i].getAttribute('data-type')=="radio")
            {
                CSSstyle=2;
                Level=2;
                var j;
                Textlist=[];
                for(j=1;j<$($($('#content1').children()[i]).children()[2]).children().length;j++)
                {
                    var Text=$($($($('#content1').children()[i]).children()[2]).children()[j]).children()[0].innerText;
                    Textlist.push(Text);
                }
                switch(Prelevel)
                {
                    case 1:
                        var j;
                        for(j=Frontlist.length-1;j>=0;j--)
                            if(Frontlist[j].cssstyle==1&&Frontlist[j].level==1)break;
                        if(j<0)
                        {
                            ok=false;
                            alert('单选前请放置一个一级标题，并且不得有其他二级标题以及三级标题');
                            break;
                        }
                        fid=j+1;
                        break;
                    case 2:
                        ok=false;
                        alert('单选前请放置一个一级标题，并且不得有其他二级标题以及三级标题');
                        break;
                    case 3:
                        ok=false;
                        alert('单选前请放置一个一级标题，并且不得有其他二级标题以及三级标题');
                        break;
                    default:
                        ok=false;
                        alert('单选前请放置一个一级标题，并且不得有其他二级标题以及三级标题');
                        break;
                }
                for(j=0;j<Textlist.length;j++)
                {
                    object=
                    {
                        datatype:"radio",
                        fid:fid+1,
                        id:i+1,
                        level:Level,
                        cssstyle:CSSstyle,
                        text:Textlist[j]
                    };
                    Frontlist.push(object);
                }

            }
            if($('#content1').children()[i].getAttribute('data-type')=="checkbox")
            {
                CSSstyle=3;
                Level=2;
                var j;
                Textlist=[];
                for(j=1;j<$($($('#content1').children()[i]).children()[2]).children().length;j++)
                {
                    var Text=$($($($('#content1').children()[i]).children()[2]).children()[j]).children()[0].innerText;
                    Textlist.push(Text);
                }
                switch(Prelevel)
                {
                    case 1:
                        var j;
                        for(j=Frontlist.length-1;j>=0;j--)
                            if(Frontlist[j].cssstyle==1&&Frontlist[j].level==1)break;
                        if(j<0)
                        {
                            ok=false;
                            alert('多选前请放置一个一级标题，并且不得有其他二级标题以及三级标题');
                            break;
                        }
                        fid=j+1;
                        break;
                    case 2:
                        ok=false;
                        alert('多选前请放置一个一级标题，并且不得有其他二级标题以及三级标题');
                        break;
                    case 3:
                        ok=false;
                        alert('多选前请放置一个一级标题，并且不得有其他二级标题以及三级标题');
                        break;
                    default:
                        ok=false;
                        alert('多选前请放置一个一级标题，并且不得有其他二级标题以及三级标题');
                        break;
                }
                for(j=0;j<Textlist.length;j++)
                {
                    object=
                    {
                        datatype:"checkbox",
                        fid:fid+1,
                        id:i+1,
                        level:Level,
                        cssstyle:CSSstyle,
                        text:Textlist[j]
                    };
                    Frontlist.push(object);
                }
            }

            if($('#content1').children()[i].getAttribute('data-type')=="textarea")
            {
                CSSstyle=4;
                Level=2;
                Title=$($('#content1').children()[i]).children()[1].innerText;
                switch(Prelevel)
                {
                    case 1:
                        var j;
                        for(j=Frontlist.length-1;j>=0;j--)
                            if(Frontlist[j].cssstyle==1&&Frontlist[j].level==1)break;
                        if(j<0)
                        {
                            ok=false;
                            alert('评述前请放置一个一级标题，并且不得有其他二级标题以及三级标题');
                            break;
                        }
                        fid=j+1;
                        break;
                    case 2:
                        var j;
                        for(j=Frontlist.length-1;j>=0;j--)
                            if(Frontlist[j].cssstyle==1&&Frontlist[j].level==1)break;
                        if(j<0)
                        {
                            ok=false;
                            alert('评述前请放置一个一级标题，并且不得有其他二级标题以及三级标题');
                            break;
                        }
                        fid=j+1;
                        break;
                    case 3:
                        ok=false;
                        alert('评述前请放置一个一级标题，并且不得有其他二级标题以及三级标题');
                        break;
                    default:
                        ok=false;
                        alert('评述前请放置一个一级标题，并且不得有其他二级标题以及三级标题');
                        break;
                }
                object=
                {
                    datatype:"textarea",
                    fid:fid+1,
                    id:i+1,
                    level:Level,
                    cssstyle:CSSstyle,
                    text:Title
                };
                Frontlist.push(object);
            }
            Prelevel=Level;
        }

        Prelevel=0;
        for(var i=1;ok&&i<$('#content2').children().length;i++)
        {
            if($('#content2').children()[i].getAttribute('data-type')=="static_text")
            {
                CSSstyle=1;
                Level=parseInt($($('#content2').children()[i]).children()[1].innerText.charAt(0));
                Text=$($('#content2').children()[i]).children()[2].innerText;
                fid=0;
                if(Prelevel==0)
                    if(Level==1)
                        Prelevel=1;
                    else
                    {
                        ok=false;
                        alert('请至少放置一个一级标题');
                        break;
                    }
                switch(Prelevel)
                {
                    case 1:
                        if(Level==1);
                        if(Level==2)fid=i-1;
                        if(Level==3)
                        {
                            ok=false;
                            alert('一级标题后不能越级跟三级标题');
                            break;
                        }
                        break;
                    case 2:
                        if(Level==1);
                        if(Level==2)
                        {
                            var j;
                            for(j=Backlist.length-1;j>=0;j--)
                                if(Backlist[j].cssstyle==1&&Backlist[j].level==1)break;
                            if(j<0)
                            {
                                ok=false;
                                alert('二级标题前请至少放置一个一级标题');
                                break;
                            }
                            fid=j+1;
                        }
                        if(Level==3)fid=i-1;
                        break;
                    case 3:
                        if(Level==1);
                        if(Level==2)
                        {
                            var j;
                            for(j=Backlist.length-1;j>=0;j--)
                                if(Backlist[j].cssstyle==1&&Backlist[j].level==1)break;
                            if(j<0)
                            {
                                ok=false;
                                alert('二级标题前请至少放置一个一级标题');
                                break;
                            }
                            fid=j+1;
                        }
                        if(Level==3)
                        {
                            var j;
                            for(j=Backlist.length-1;j>=0;j--)
                                if(Backlist[j].cssstyle==1&&Backlist[j].level==2)break;
                            if(j<0)
                            {
                                ok=false;
                                alert('三级标题前请至少放置一个二级标题');
                                break;
                            }
                            fid=j+1;
                        }
                        break;
                    default:
                        ok=false;
                        alert('请至少放置一个一级标题');
                        break;
                }
                object=
                {
                    datatype:"static-text",
                    fid:fid+1,
                    id:i+1,
                    level:Level,
                    cssstyle:CSSstyle,
                    text:Text
                };
                Backlist.push(object);
            }
            if($('#content2').children()[i].getAttribute('data-type')=="radio")
            {
                CSSstyle=2;
                Level=2;
                var j;
                Textlist=[];
                for(j=1;j<$($($('#content2').children()[i]).children()[2]).children().length;j++)
                {
                    var Text=$($($($('#content2').children()[i]).children()[2]).children()[j]).children()[0].innerText;
                    Textlist.push(Text);
                }
                switch(Prelevel)
                {
                    case 1:
                        var j;
                        for(j=Backlist.length-1;j>=0;j--)
                            if(Backlist[j].cssstyle==1&&Backlist[j].level==1)break;
                        if(j<0)
                        {
                            ok=false;
                            alert('单选前请放置一个一级标题，并且不得有其他二级标题以及三级标题');
                            break;
                        }
                        fid=j+1;
                        break;
                    case 2:
                        ok=false;
                        alert('单选前请放置一个一级标题，并且不得有其他二级标题以及三级标题');
                        break;
                    case 3:
                        ok=false;
                        alert('单选前请放置一个一级标题，并且不得有其他二级标题以及三级标题');
                        break;
                    default:
                        ok=false;
                        alert('单选前请放置一个一级标题，并且不得有其他二级标题以及三级标题');
                        break;
                }
                for(j=0;j<Textlist.length;j++)
                {
                    object=
                    {
                        datatype:"radio",
                        fid:fid+1,
                        id:i+1,
                        level:Level,
                        cssstyle:CSSstyle,
                        text:Textlist[j]
                    };
                    Backlist.push(object);
                }

            }
            if($('#content2').children()[i].getAttribute('data-type')=="checkbox")
            {
                CSSstyle=3;
                Level=2;
                var j;
                Textlist=[];
                for(j=1;j<$($($('#content2').children()[i]).children()[2]).children().length;j++)
                {
                    var Text=$($($($('#content2').children()[i]).children()[2]).children()[j]).children()[0].innerText;
                    Textlist.push(Text);
                }
                switch(Prelevel)
                {
                    case 1:
                        var j;
                        for(j=Backlist.length-1;j>=0;j--)
                            if(Backlist[j].cssstyle==1&&Backlist[j].level==1)break;
                        if(j<0)
                        {
                            ok=false;
                            alert('多选前请放置一个一级标题，并且不得有其他二级标题以及三级标题');
                            break;
                        }
                        fid=j+1;
                        break;
                    case 2:
                        ok=false;
                        alert('多选前请放置一个一级标题，并且不得有其他二级标题以及三级标题');
                        break;
                    case 3:
                        ok=false;
                        alert('多选前请放置一个一级标题，并且不得有其他二级标题以及三级标题');
                        break;
                    default:
                        ok=false;
                        alert('多选前请放置一个一级标题，并且不得有其他二级标题以及三级标题');
                        break;
                }
                for(j=0;j<Textlist.length;j++)
                {
                    object=
                    {
                        datatype:"checkbox",
                        fid:fid+1,
                        id:i+1,
                        level:Level,
                        cssstyle:CSSstyle,
                        text:Textlist[j]
                    };
                    Backlist.push(object);
                }
            }

            if($('#content2').children()[i].getAttribute('data-type')=="textarea")
            {
                CSSstyle=4;
                Level=2;
                Title=$($('#content2').children()[i]).children()[1].innerText;
                Placeholder=$($($('#content2').children()[i]).children()[2]).children()[0].getAttribute('placeholder');
                switch(Prelevel)
                {
                    case 1:
                        fid=i-1;
                        break;
                    case 2:
                        var j;
                        for(j=Backlist.length-1;j>=0;j--)
                            if(Backlist[j].cssstyle==1&&Backlist[j].level==1)break;
                        if(j<0)
                        {
                            ok=false;
                            alert('评述前请放置一个一级标题，并且不得有其他二级标题以及三级标题');
                            break;
                        }
                        fid=j+1;
                        break;
                    case 3:
                        ok=false;
                        alert('评述前请放置一个一级标题，并且不得有其他二级标题以及三级标题');
                        break;
                    default:
                        ok=false;
                        alert('评述前请放置一个一级标题，并且不得有其他二级标题以及三级标题');
                        break;
                }
                object=
                {
                    datatype:"textarea",
                    fid:fid+1,
                    id:i+1,
                    level:Level,
                    cssstyle:CSSstyle,
                    text:Title
                };
                Backlist.push(object);
            }
            Prelevel=Level;
        }
        if(Frontlist.length!=0&&Backlist.length!=0)
        {
            $.ajax({
                type: "post",
                async: false,
                url: "/DBTheoryEvaluationTable",
                data: {
                    '_token':'{{csrf_token()}}',
                    frontdata:Frontlist,
                    backdata:Backlist
                },
                success: function (result) {
                    alert('修改理论评价表成功！');
                }
            });
            {{--$.ajax({--}}
                {{--type: "post",--}}
                {{--async: false,--}}
                {{--url: "/CreateTheoryEvalutionFrontTable",--}}
                {{--data: {--}}
                    {{--'_token':'{{csrf_token()}}',--}}
                    {{--frontdata:Frontlist,--}}
                    {{--backdata:Backlist--}}
                {{--},--}}
                {{--success: function (result) {--}}
                    {{--alert('创建正面理论评价记录表成功！');--}}
                {{--}--}}
            {{--});--}}
        }

        else
        {
            if(Frontlist.length==0)alert("正面评价表为空");
            if(Backlist.length==0)alert("背面评价表为空");
        }
    }
</script>
</html>
