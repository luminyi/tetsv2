<?php
/**
 * Created by DFI.
 * User: ZHOUJIAN
 * Date: 2016/6/20
 * Time: 14:37
 */
?>
@if($errors->any())
    <ul class="list-group" style="margin-left:0px!important;margin-bottom:0px!important;">
        @foreach($errors->all() as $error)
            <li class="alert alert-danger" style='list-style:none'>{{ $error }}</li>
        @endforeach
    </ul>
@endif
