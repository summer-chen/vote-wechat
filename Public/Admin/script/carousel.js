/**
 * Created by john zhou on 2017/2/21.
 */
$(function(){
    UE.getEditor('carousel_content', {
        initialFrameWidth: "98%",
        initialFrameHeight: 200
    });
});

/**
 * 添加轮播图
 */
var add = function(){
    var url = baseUrl + "index.php/Admin/Carousel/add";
    var formdata = new FormData();
    var content = UE.getEditor('carousel_content').getContent();
    formdata.append('content',content);
    formdata.append('picurl',arr);

    $.ajax({
        url:url,
        type:'POST',
        data:formdata,
        processData:false,
        contentType:false,
        success:function(result){
            result = eval("("+result+")");
            if(result.serviceResult == 1){
                layer.alert('添加成功');
            }else{
                layer.alert(result.resultinfo);
            }

        },
        error:function(result){
            alert("error");
        }

    });
};

/**
 * 展示轮播图数据
 */
var lst = function(){
    var url = baseUrl + "index.php/Admin/Carousel/lst";
    $.post(url,null,function(result){
        if(result.serviceResult == 1){
            $(result.resultinfo).each(function(index,object){
                $("#cour_content").append("<tr id='row"+object.cid+"' class='gradeX'>"
                    +  "<td>"+(index+1)+"</td>"
                    +  "<td><img id='pic"+object.cid+"' width='130px' src='"+baseUrl+"/Public/Uploads/"+object.picurl+"'></td>"
                    +  "<td>"
                  //  +  "<a onclick='getdata("+object.cid+")' data-toggle='modal' data-target='#myModal' class='btn btn-primary'>修改</a>"
                    +  "&nbsp;<a onclick='deletecar("+object.cid+")' class='btn btn-primary'>删除</a>"
                    +  "</td>"
                    +  "</tr>");
            });
        }
    },'json');
};

/**
 * 根据id获得相应的数据
 * @param cid
 */
var getdata = function(cid){
    var url = baseUrl + "index.php/Admin/Carousel/getdata";
    var data = {
        cid:cid
    };
    $.post(url,data,function(result){
        if(result.serviceResult == 1){
            UE.getEditor("carousel_content").setContent(result.resultinfo.content);
            $('#cid').val(result.resultinfo.cid);
        }
    },'json');
};

/**
 * 修改轮播图内容
 */
var update = function(){
    var url = baseUrl + "index.php/Admin/Carousel/update";
    var formdata = new FormData();
    var content = UE.getEditor('carousel_content').getContent();
    formdata.append('content',content);
    formdata.append('picurl',$('#upload')[0].files[0]);
    formdata.append('cid',$('#cid').val());

    $.ajax({
        url:url,
        type:'POST',
        data:formdata,
        processData:false,
        contentType:false,
        success:function(result){
            result = eval("("+result+")");
            if(result.serviceResult == 1){
                layer.alert('添加成功');
                $("#pic"+result.resultinfo.cid).attr('src',baseUrl+"Public/Uploads/"+result.resultinfo.picurl);
            }else{
                layer.alert(result.resultinfo);
            }
        },
        error:function(result){
            alert("error");
        }
    });
};

var deletecar = function(cid){
    if(confirm('你确定要删除吗?')){
        var url = baseUrl + "index.php/Admin/Carousel/del";
        var data = {
            cid:cid
        };
        $.post(url,data,function(result){
            if(result.serviceResult == 1){
                $('#row'+result.resultinfo.cid).remove();
            }else{
                layer.alert(result.resultinfo);
            }
        },'json');
    }
};


