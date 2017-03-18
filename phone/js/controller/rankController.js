/**
 * Created by ASUS1 on 2017/2/28.
 */
myApp.controller("rankController",["$scope","$http","factories",function($scope,$http,factories){
    console.log("rankController");

    $scope.light = function () {
        $('.weui-menu-inner').removeClass('nav-active')
        $('.weui-menu-inner').eq(3).addClass('nav-active');
    }
    $scope.light();

    $scope.getListInit = function(){
        var url = "index.php/Home/Competitor/ranking_list";
        var data = {lid:sessionStorage.lid,p:1};
        $scope.classifyList = new factories(url,data);
    }



    //获取赛区
    $scope.getlocation = function(){
        $http.get(baseUrl+'index.php/Home/Competitor/getlocation')
            .success(function (data) {
                console.log(data.resultinfo)
                switch(data.serviceResult){
                    case 1:{
                        $scope.locations = data.resultinfo;
                        sessionStorage.lid = "";
                        $scope.getListInit();
                        $scope.classifyList.nextPage();
                        break;
                    }
                    default:{
                        alert(data.resultinfo);
                        break;
                    }
                }
            })
    };

    $scope.getlocation();


    //切换地区
    $scope.getInfo = function (lid) {
        sessionStorage.lid = lid;
        $scope.getListInit();
        $scope.classifyList.nextPage();
    };

}]);