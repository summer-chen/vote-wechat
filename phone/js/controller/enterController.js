/**
 * Created by ASUS1 on 2017/2/28.
 */

myApp.controller('enterController',["$scope","$http",function ($scope,$http) {

    $scope.light = function () {
        $('.weui-menu-inner').removeClass('nav-active')
        $('.weui-menu-inner').eq(1).addClass('nav-active');
    }
    $scope.light();
    //获取赛区
    $scope.getLocation = function(){
        $http.post(baseUrl+"index.php/Home/Competitor/getlocation")
            .success(function (data) {
                console.log(data)
                switch(data.serviceResult){
                    case 1:{
                        $scope.locations = data.resultinfo;
                        break;
                    }
                    default:{
                        break;
                    }

                }
            })
    }

    $scope.getLocation();

    //提交报名数据

    $scope.enroll = function(invalid){

            console.log(invalid);

            if(invalid){
                alert('个人信息未填写完整!');
                console.log("123");
               // window.location.href="index.html#/pic/2";

            }
            else{
                console.log($scope.lid);
                var data = {
                    name : $scope.name,
                    age : $scope.age,
                    height : $scope.height,
                    weight : $scope.weight,
                    job : $scope.job,
                    dream : $scope.dream,
                    family : $scope.family,
                    location : $scope.location,
                    telphone : $scope.telphone,
                    email : $scope.email,
                    hobby : $scope.hobby


                }
                console.log(data);
                $http.post(baseUrl+"index.php/Home/Competitor/enroll",data)
                    .success(function (data) {
                        switch(data.serviceResult){
                            case 1:{
                                layer.open({
                                    content: '操作成功'
                                    ,skin: 'msg'
                                    ,time: 2 //2秒后自动关闭
                                });
                                window.location.href="index.html#/pic/"+data.resultinfo.cid;
                                break;

                            }
                            default:
                                alert(data.resultinfo);
                                break;


                        }
                    })
            }
        }



}])