/**
 * Created by ASUS1 on 2017/3/16.
 */
myApp.controller('loginController',['$scope','$http',function ($scope,$http) {
    var url = document.URL;
    var firstindex = url.indexOf("=");
    var lastindex = url.indexOf("&");
    var code = url.substring(firstindex+1,lastindex);
    var data = {
        code:code
    };

    var url = sessionStorage.url ? sessionStorage.url : 'index.html';
    $http.post(baseUrl+'index.php/Home/Index/login',data)
        .success(function (data) {
             switch(data.serviceResult){
                case 1:
                    var i = layer.open({
                        type: 2,
                        content: '登录中',
                        shadeClose:false,
                        shade:'background-color:rgba(255,255,255,1)',
                        className:'loginLoading'
                    });
                    setTimeout(function() {
                        layer.close(i);
                    }, 3000);
                    sessionStorage.url='';
                    window.location.href = url;
                    break;
                default:
                    $('#msg2').fadeIn();
                    alert("登录失败,请重试");
                    break;
            }
        });
}]);