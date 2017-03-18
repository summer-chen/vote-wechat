/**
 * Created by ASUS1 on 2017/3/6.
 */
myApp.controller('peopleController',["$scope","$http","$stateParams","$location","factories","Services",function($scope,$http,$stateParams,$location,factories,Services){
    var cid = $stateParams.cid;

    //判断是否登录
    $scope.ifLogin = function () {
        sessionStorage.url = $location.absUrl();
        $http.post(baseUrl+"index.php/Home/Index/islogin")
            .success(function (data) {
                if(data.serviceResult == 0){
                    layer.open({type:2});
                    window.location.href = "https://open.weixin.qq.com/connect/oauth2/authorize?appid=wxf633460ea7e938e2&redirect_uri=http://summer.tunnel.qydev.com/vote/phone/index.html%23/login&response_type=code&scope=snsapi_base&state=123#wechat_redirect";
                }
            })
    };
    $scope.ifLogin();

    $scope.getimage = function(){

        var data = {cid:cid};
        $http.post(baseUrl+"index.php/Home/Competitor/getimage",data)
            .success(function(data){
                switch (data.serviceResult){
                    case 1:
                        $scope.headimage = data.resultinfo.imageurl;
                        break;
                }
            });

    };
    $scope.getimage();

    $scope.getInfo = function () {
        var data = {
            cid:cid
        };

        $http.post(baseUrl+"index.php/Home/Competitor/detail",data)
            .success(function (data) {
                switch(data.serviceResult){
                    case 1:
                        $scope.info = data.resultinfo;
                        break;
                    default:
                        alert(data.resultinfo);
                        break;
                }
            })
    };
    $scope.getInfo();

    $scope.getcount = function () {
        var data = {
            cid:cid
        };
        $http.post(baseUrl+"index.php/Home/Competitor/count",data)
            .success(function (data) {
                switch(data.serviceResult){
                    case 1:
                        $scope.count1 = data.resultinfo.vote ? data.resultinfo.vote : 0;
                        $scope.count2 = data.resultinfo.crown ? data.resultinfo.crown : 0;
                        $scope.count3 = data.resultinfo.kiss ? data.resultinfo.kiss : 0;
                        $scope.count4 = data.resultinfo.flower ? data.resultinfo.flower : 0;
                        break;
                    default:
                        alert(data.resultinfo);
                        break;
                }
            })
    };
    $scope.getcount();

    $scope.support = function () {
        var data = {
            cid:cid
        };

        $http.post(baseUrl+"index.php/Home/Competitor/support",data)
            .success(function (data) {
                switch(data.serviceResult){
                    case 1:
                        alert('投票成功!');
                        $scope.getcount();
                        break;
                    default:
                        alert(data.resultinfo);
                        break;
                }
            })
    };


    $scope.getPic = function () {
        var data = {
            cid:cid
        };

        $http.post(baseUrl+"index.php/Home/Competitor/show",data)
            .success(function (data) {
                switch(data.serviceResult){
                    case 1:
                        $scope.pics = data.resultinfo;
                        break;
                    default:
                        alert('获取失败,请重试');
                        break;
                }
            })
    };
    $scope.getPic();

    $scope.getRemark = function(){
        var url = "index.php/Home/Competitor/record";
        var data = {cid:cid,p:1};
        $scope.classifyList = new factories(url,data);
    };
    $scope.getRemark();

    //配置签名
    $scope.getsignature = function (){
       Services.getsignature();
       Services.share(cid);
    };
    $scope.getsignature();



    function upDownOperation(element)
    {
        var _input = element.parent().find('input'),
            _value = _input.val(),
            _step = _input.attr('data-step') || 1;
        //检测当前操作的元素是否有disabled，有则去除
        element.hasClass('disabled') && element.removeClass('disabled');
        //检测当前操作的元素是否是操作的添加按钮（.input-num-up）‘是’ 则为加操作，‘否’ 则为减操作
        if ( element.hasClass('weui-number-plus') )
        {
            var _new_value = parseInt( parseFloat(_value) + parseFloat(_step) ),
                _max = _input.attr('data-max') || false,
                _down = element.parent().find('.weui-number-sub');

            //若执行‘加’操作且‘减’按钮存在class='disabled'的话，则移除‘减’操作按钮的class 'disabled'
            _down.hasClass('disabled') && _down.removeClass('disabled');
            if (_max && _new_value >= _max) {
                _new_value = _max;
                element.addClass('disabled');
            }
        } else {
            var _new_value = parseInt( parseFloat(_value) - parseFloat(_step) ),
                _min = _input.attr('data-min') || false,
                _up = element.parent().find('.weui-number-plus');
            //若执行‘减’操作且‘加’按钮存在class='disabled'的话，则移除‘加’操作按钮的class 'disabled'
            _up.hasClass('disabled') && _up.removeClass('disabled');
            if (_min && _new_value <= _min) {
                _new_value = _min;
                element.addClass('disabled');
            }
        }
        _input.val( _new_value );
    }


    $(function(){
        $('.weui-number-plus').click(function(){
            upDownOperation( $(this) );
        });
        $('.weui-number-sub').click(function(){
            upDownOperation( $(this) );
        });
    });



}]);