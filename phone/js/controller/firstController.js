/**
 * Created by ASUS1 on 2017/2/27.
 */
myApp.controller('firstController',["$scope","$http","$sce",function($scope,$http,$sce){

    /*轮播图初始化*/
    var mySwiper = new Swiper ('.swiper-container', {
        autoplay: 3000,//可选选项，自动滑动
        pagination: '.swiper-pagination',  //分页
        observer:true,//修改swiper自己或子元素时，自动初始化swiper
        observeParents:true,//修改swiper的父元素时，自动初始化swiper
    })

    $scope.light = function () {
        $('.weui-menu-inner').removeClass('nav-active')
        $('.weui-menu-inner').eq(0).addClass('nav-active');
    }
    $scope.light();

    $scope.getpic = function(){
        var base = new Base64();
        $http.post(baseUrl+"index.php/Home/Index/index")
            .success(function (data) {
                switch(data.serviceResult){
                    case 1:

                        $scope.carouseldata = data.resultinfo.carouseldata;
                        $scope.infodata = data.resultinfo.infodata;
                        var content1 = data.resultinfo.infodata[0].content;
                        content1 = base.decode(content1);
                        $scope.textContent1 = $sce.trustAsHtml(content1);
                        var content2 = data.resultinfo.infodata[1].content;
                        content2 = base.decode(content2);
                        $scope.textContent2 = $sce.trustAsHtml(content2);
                        var content3 = data.resultinfo.infodata[2].content;
                        content3 = base.decode(content3);
                        $scope.textContent3 = $sce.trustAsHtml(content3);

                        break;
                    default:
                        break;

                }
            })
    }

    $scope.getpic();




}]);