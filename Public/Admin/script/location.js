/**
 * Created by john zhou on 2017/2/22.
 */

$(function(){
    lst();
});

/**
 * 添加赛区
 */
var add = function(){
    var url = baseUrl + "index.php/Admin/Location/add";
    var name = $('#location_name').val();
    var data = {
        name:name
    };

    $.post(url,data,function(result){
        if(result.serviceResult == 1){
            layer.alert("添加成功");
            $('#location_name').val('');
            var index = result.resultinfo.index;
            var lid = result.resultinfo.lid;
            $("#loca_content").append("<tr id='row"+lid+"' class='gradeX'>"
                + "<td>"+index+"</td>"
                + "<td id='name"+lid+"'>"+name+"</td>"
                + "<td>"
                + "<a onclick='setlid("+lid+")' class='btn btn-primary' data-toggle='modal' data-target='#myModalupdate'>修改</a>&nbsp;"
              //  + "<a onclick='del("+lid+")' class='btn btn-primary'>删除</a>"
                + "</td>"
                + "</tr>");
        }
    },'json');
};

/**
 * 列出所有信息
 */
var lst = function(){
    var url = baseUrl + "index.php/Admin/Location/lst";
    $.post(url,null,function(result){
        if(result.serviceResult == 1){
            $(result.resultinfo).each(function(index,object){
                $("#loca_content").append("<tr id='row"+object.lid+"' class='gradeX'>"
                   + "<td>"+(index+1)+"</td>"
                   + "<td id='name"+object.lid+"'>"+object.name+"</td>"
                   + "<td>"
                   + "<a onclick='setlid("+object.lid+")' class='btn btn-primary' data-toggle='modal' data-target='#myModalupdate'>修改</a>&nbsp;"
                //   + "<a onclick='del("+object.lid+")' class='btn btn-primary'>删除</a>"
                   + "</td>"
                   + "</tr>");
            });
        }
    },'json');
};

/**
 * 设置修改弹出框的lid
 * @param lid
 */
var setlid = function(lid){
    $("#lid").val(lid);
};

/**
 * 修改赛区名称
 */
var update = function(){
    var url = baseUrl + "index.php/Admin/Location/update";
    var data = {
        lid:$("#lid").val(),
        name:$("#newlocation_name").val()
    };
    $.post(url,data,function(result){
        if(result.serviceResult == 1){
            layer.alert("修改成功");
            $('#name'+result.resultinfo.lid).html(result.resultinfo.name);
            $("#newlocation_name").val();
        }else{
            layer.alert(result.resultinfo);
        }
    },'json');
};

/**
 * 删除赛区
 * @param lid
 */
var del = function(lid){
   if(confirm("你确定要删除吗?")){
       var url = baseUrl + "index.php/Admin/Location/del";
       var data = {
           lid:lid
       };
       $.post(url,data,function(result){
           if(result.serviceResult == 1){
               $("#row"+result.resultinfo.lid).remove();
           }else{
               layer.alert(result.resultinfo);
           }
       },'json');
   }
};