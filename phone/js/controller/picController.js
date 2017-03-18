/**
 * Created by ASUS1 on 2017/3/5.
 */
myApp.controller('picController',["$scope","$http","$stateParams","Services",function($scope,$http,$stateParams,Services){
    console.log('pic');

    var images = new Array();
    $scope.show = function () {
        Services.getsignature();
    };

    $scope.show();
    
    $scope.chooseImage = function () {
        wx.chooseImage({
            count: 8-images.length, // 默认9
            sizeType: ['original', 'compressed'], // 可以指定是原图还是压缩图，默认二者都有
            sourceType: ['album', 'camera'], // 可以指定来源是相册还是相机，默认二者都有
            success: function (data) {
                for(var i=0;i<data.localIds.length;i++){
                    images.push(data.localIds[i].toString());
                    $('#showImage').append("<li class='weui_uploader_file' style='background-image:url("+data.localIds[i]+")'></li>")
                }
                angular.element('#picDisable').attr('disabled',false);
            }
        });
    };

    $scope.wxuploadImage = function () {
        angular.element('#picDisable').attr('disabled',true);
        var flag = 1 ;
        var index = layer.open({
            type:2,
            content:"上传中",
            shadeClose:false
        })
        for(var i=0;i<images.length;i++){
            wx.uploadImage({
                localId: images[i], // 需要上传的图片的本地ID，由chooseImage接口获得
                isShowProgressTips: 0, // 默认为1，显示进度提示
                success: function (res) {
                    mediaId = res.serverId; // 返回图片的服务器端ID
                    var url = baseUrl + "index.php/Home/Index/download";
                    var data = {
                        media_id:mediaId,
                        cid:$stateParams.cid
                    };
                    $.post(url,data,function(result){
                        if(result.serviceResult == 1){
                            flag++;
                        }else{
                            flag = false;
                        }
                    },'json');
                },
                fail: function (error) {
                    picPath = '';
                    localIds = '';
                    alert(Json.stringify(error));
                    angular.element('#picDisable').attr('disabled',false);

                }

            });
        }

        var interval = setInterval(function(){
            if(flag == (images.length+1)){
                layer.close(index);
                alert("上传成功");
                window.location.href='enterSuccess.html';
                clearInterval(interval);
            }
            if(flag == false){
                layer.close(index);
                alert("上传失败,请重试");
                window.location.href='index.html#/enter';
                clearInterval(interval);
            }
        },1000);
    }

}]);