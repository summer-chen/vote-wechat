/**
 * Created by ASUS1 on 2017/3/15.
 */
myApp.factory('isLogin',['$http','$location',function ($http,$location) {

    var login = {};
    var a;

    var runLogin = function () {
        /*$http.get(baseUrl+'index.php/Home/index/isLogin')
            .success(function (data) {
                alert(sessionStorage.url);
                switch(data.serviceResult){
                    case 1:
                        break;
                    default:
                        sessionStorage.url = $location.absUrl();
                        layer.open({
                            content: '你还未登录'
                            ,btn: '去登录'
                        });
                        window.location.href='https://open.weixin.qq.com/connect/oauth2/authorize?appid=wxf633460ea7e938e2&redirect_uri=http://summer.tunnel.qydev.com/vote/phone/index.html%23/login&response_type=code&scope=snsapi_base&state=123#wechat_redirect';
                }
            })*/
        window.location.href='https://open.weixin.qq.com/connect/oauth2/authorize?appid=wxf633460ea7e938e2&redirect_uri=http://summer.tunnel.qydev.com/vote/phone/index.html%23/login&response_type=code&scope=snsapi_base&state=123#wechat_redirect';

    };

    login.is_login = function(){
        $http.get(baseUrl+'index.php/Home/index/isLogin')
            .success(function (data) {
                console.log(data);
                switch(data.serviceResult){
                    case 1:
                        a=true;
                        break;
                    case 0:
                        a=false
                        break;
                }

            });

    };
    login.getA = function () {
        return a;
    }
    console.log(login.is_login);
    return login;

}]);