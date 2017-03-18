/**
 * Created by Hokkaido on 2017/2/24.
 */
/**
 * 通过审核
 * @param cid
 */
var check = function(cid){
    if(confirm("确定通过审核吗?")){
        var url = baseUrl + "index.php/Admin/Competitor/check";
        var data = {
            cid:cid
        };
        $.post(url,data,function(result){
            if(result.serviceResult == 1){
                layer.alert("操作成功");
                $('#row'+result.resultinfo.cid).remove();
            }else{
                layer.alert(result.resultinfo);
            }
        },'json');
    }
};

var deletecompetitor = function(cid){
    if(confirm("你确定删除该选手吗?")){
        var url = baseUrl + "index.php/Admin/Competitor/delete";
        var data = {
            cid:cid
        };
        $.post(url,data,function(result){
            if(result.serviceResult == 1){
                layer.alert("删除成功");
                $("#row"+cid).remove();
            }else{
                layer.alert(result.resultinfo)
            }
        },'json');
    }
}

var showimage = function(cid){
    var url = baseUrl + "index.php/Admin/Competitor/show";
    var data = {
        cid:cid
    };
    $.post(url,data,function(result){
        if(result.serviceResult == 1){
            //$(result.resultinfo).each(function(index,object){
               // $("#showimage").append("<img width='100px' height='100px' src='"+object.imageurl+"'>");
            //});
             layer.photos({
                photos: result.resultinfo
                ,anim: 5 //0-6的选择，指定弹出图片动画类型，默认随机（请注意，3.0之前的版本用shift参数）
              });
        }else{
            layer.alert(result.resultinfo)
        }
    },'json');   
}

/**
 * 获得支持记录数据
 * @param cid
 */
var record = function(cid){
    var str = "";
    str += "<tr class='gradeX'>";
    str += "<th>头像</th>";
    str += "<th>种类</th>";
    str += "<th>时间</th>";
    str += "<th>微信昵称</th>";
    str += "</tr>";

    var url = baseUrl + "index.php/Admin/Competitor/record";
    var data = {
        cid:cid
    };
    $.post(url,data,function(result){
        if(result.serviceResult == 1){
            $("#record_table").children().each(function(){
                $(this).remove();
            });
            var data = result.resultinfo.data;
            $("#record_table").append(str);

            $(data).each(function(index,object){
                $("#record_table").append("<tr class='gradeX'>"
                    + "<td><img width='100px' height='100px' src='"+object.headimg+"'></td>"
                    + "<td>"+object.name+"</td>"
                    + "<td>"+object.time+"</td>"
                    + "<td>"+object.username+"</td>"
                    + "</tr>");
            });

            $("#pagerArea").cypager({
                pg_size:result.resultinfo.perpage,
                pg_nav_count:5,
                pg_total_count:result.resultinfo.count,
                pg_prev_name:'上一页',
                pg_next_name:'下一页',
                pg_call_fun:function(count){
                    $("#record_table").children().each(function(){
                        $(this).remove();
                    });
                    var data = {
                        cid:cid,
                        p:count
                    };
                    $.post(url,data,function(result){
                        if(result.serviceResult == 1){
                            var data = result.resultinfo.data;
                            $("#record_table").append(str);

                            $(data).each(function(index,object){
                                $("#record_table").append("<tr  class='gradeX'>"
                                    + "<td><img width='100px' height='100px' src='"+object.headimg+"'></td>"
                                    + "<td>"+object.name+"</td>"
                                    + "<td>"+object.time+"</td>"
                                    + "<td>"+object.username+"</td>"
                                    + "</tr>");
                            });
                        }
                    },'json');

            }});
        }
    },'json');
};