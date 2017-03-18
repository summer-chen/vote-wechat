/**
 * Created by john zhou on 2017/2/22.
 */
$(function(){
    UE.getEditor('info_desc', {
        initialFrameWidth: "98%",
        initialFrameHeight: 200
    });
    UE.getEditor('info_award', {
        initialFrameWidth: "98%",
        initialFrameHeight: 200
    });
    UE.getEditor('info_rule', {
        initialFrameWidth: "98%",
        initialFrameHeight: 200
    });

    /**
     * 设置信息
     */
    //延时800毫秒加载数据
    setTimeout(function(){
        var url = baseUrl + "index.php/Admin/Info/getall";
        $.post(url,null,function(result){
            if(result.serviceResult == 1){
                var info = result.resultinfo;
                console.log(info);
                $(info).each(function(index,value){
                    if(value.iid == 1){
                        UE.getEditor("info_desc").setContent(value.content);
                    }else if(value.iid == 2){
                        UE.getEditor("info_award").setContent(value.content);
                    }else if(value.iid == 3){
                        UE.getEditor("info_rule").setContent(value.content);
                    }
                });
            }
        },'json');
    },800);
});

/**
 * 提交信息
 */
var desc = function(){
    var url = baseUrl + "index.php/Admin/Info/add";
    var content = UE.getEditor("info_desc").getContent();
    var data = {
        iid:1,
        content:content
    };
    $.post(url,data,function(result){
        if(result.serviceResult == 1){
            layer.alert("操作成功");
        }else{
            layer.alert(result.resultinfo);
        }
    },'json');
};

var award = function(){
    var url = baseUrl + "index.php/Admin/Info/add";
    var content = UE.getEditor("info_award").getContent();
    var data = {
        iid:2,
        content:content
    };
    $.post(url,data,function(result){
        if(result.serviceResult == 1){
            layer.alert("操作成功");
        }else{
            layer.alert(result.resultinfo);
        }
    },'json');
};

var rule = function(){
    var url = baseUrl + "index.php/Admin/Info/add";
    var content = UE.getEditor("info_rule").getContent();
    var data = {
        iid:3,
        content:content
    };
    $.post(url,data,function(result){
        if(result.serviceResult == 1){
            layer.alert("操作成功");
        }else{
            layer.alert(result.resultinfo);
        }
    },'json');
};