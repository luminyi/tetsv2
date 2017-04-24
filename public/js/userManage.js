/**
 * Created by computer on 2016/7/12.
 */
$(document).ready(function() {
//    侧边栏移除活动效果，给当前选中区域添加选中效果
    var oli = document.getElementById('sidebar_id').getElementsByTagName("li");
    console.log(oli);
    console.log(oli.length);
    //顶级导航栏 标签编号：，0 1 4 8 9
    for (var i=0;i<oli.length;i++){
        if( oli[i].className == 'Upper_menu' )
        {
            oli[i].className='';
        }
    }
    oli[6].className="active";
    oli[6].getElementsByTagName("a")[0].className="nav-header";
    // oli[6].getElementsByTagName("ul")[0].className="nav nav-list in";
});