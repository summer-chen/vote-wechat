/**
 * Created by ASUS1 on 2017/2/28.
 */
myApp.controller('showController',["$scope","$http","$rootScope","factories",function($scope,$http,$rootScope,factories){

    //使底部栏跟着页面切换选中
    $scope.light = function () {
        $('.weui-menu-inner').removeClass('nav-active');
        $('.weui-menu-inner').eq(2).addClass('nav-active');
    };
    $scope.light();



    $scope.getListInit = function(){
        var url = "index.php/Home/Competitor/mien";
        var data = {lid:sessionStorage.lid,p:1};
        $scope.classifyList = new factories(url,data);
    };

    //获取地区
    $scope.getlocation = function(){
        $http.post(baseUrl + "index.php/Home/Competitor/getlocation")
            .success(function(data){
                    switch(data.serviceResult){
                    case 1:{
                        $scope.locations = data.resultinfo;
                        sessionStorage.lid = "";
                        $scope.getListInit();
                        $scope.classifyList.nextPage();
                        break;
                    }
                    default:{
                        layer.open({
                            content:data.resultinfo,
                            btn:'确定'
                        });
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