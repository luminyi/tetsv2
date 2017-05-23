
$("#sure").click(function(){
    if($('#SelectFile').val()!='')
    {
        var filename = $('#SelectFile').val().split("\\")[2];
        document.getElementById('myform').action="/excel/ImportTeacher?filename="+filename;
        document.getElementById('myform').submit();
    }
    else{
        alert('未选择文件');
    }
});