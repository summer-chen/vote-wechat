/**
 * Created by ASUS1 on 2017/3/3.
 */
myApp.controller('carouselController',["$scope","$http","$stateParams",function($scope,$http,$stateParams){
    var cid = $stateParams.cid;

    console.log(cid)

    //通过图片id获取图片详情

    $scope.getPicsDetail = function(){
        var data = {
            cid:cid
        };
        console.log(data);
        $http.post(baseUrl+"index.php/Home/Carousel/detail",data)
            .success(function (data) {
                console.log(data.resultinfo.content);
                switch(data.serviceResult){
                    case 1:{
                        $scope.content = data.resultinfo.content;
                        $('#picContent').html(data.resultinfo.content)
                        break;
                    }
                    default:{
                        $('#msg2').fadeIn();
                        break;
                    }
                }
            })
    }

    $scope.getPicsDetail();


}])