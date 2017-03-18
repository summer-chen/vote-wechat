function login(url){
    if($("input[name='adminname']").val()==""){
        layer.alert("用户名不能为空");
        $("input[name='adminname']").focus();
        return false;

    }
    if($("input[name='adminpass']").val()==""){
        layer.alert("密码不能为空");
        $("input[name='adminpass']").focus();
        return false;
    }
    if($("input[name='code']").val()==""){
        layer.alert("验证码不能为空");
        $("input[name='code']").focus();
        return false;
    }

    var baseUrl = "/";
    var data = $("#mylogin").serialize();
    var string = url.split("/");
    if(string[1] !== "index.php"){
        baseUrl = "/"+string[1]+"/";
    }
    $.post(url,data,function(result){
        if(result.serviceResult == 1){
            location.href=baseUrl + "index.php/Admin/Carousel/add";
        }else{
            layer.alert(result.resultinfo);
        }
    },'json');
}
