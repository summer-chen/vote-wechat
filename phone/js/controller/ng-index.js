/**
 * Created by ASUS1 on 2017/2/27.
 */
var myApp = angular.module('myApp',['ui.router','infinite-scroll'])

var baseUrl = "/vote/";

myApp.config(function ($stateProvider,$urlRouterProvider) {

    $urlRouterProvider.otherwise('/first');

    $stateProvider

        .state("first",{
            url:"/first",
            templateUrl:"first.html",
            controller:"firstController"
        })
        .state("login",{
            url:"/login",
            templateUrl:"login.html",
            controller:"loginController"
        })
        .state("enter",{
            url:"/enter",
            templateUrl:"enter.html",
            controller:"enterController"
        })
        .state("show",{
            url:"/show",
            templateUrl:"show.html",
            controller:"showController"
        })
        .state("rank",{
            url:"/rank",
            templateUrl:"rank.html",
            controller:"rankController"
        })
        .state("carousel",{
            url:"/first/:cid",
            templateUrl:"carousel.html",
            controller:"carouselController"
        })
        .state("pic",{
            url:"/pic/:cid",
            templateUrl:"pic.html",
            controller:"picController"
        })
        .state("people",{
            url:"/people/:cid",
            templateUrl:"people.html",
            controller:"peopleController"
        })
})
.config(function($httpProvider) {
    $httpProvider.defaults.transformRequest=function(obj){
        var str=[];
        for(var p in obj){
            str.push(encodeURIComponent(p)+"="+encodeURIComponent(obj[p]));
        }
        return str.join("&");
    };
    $httpProvider.defaults.headers.post = {
        'Content-Type': 'application/x-www-form-urlencoded',
    }
});

/*var navClick = function (a) {
    $('.weui-menu-inner').removeClass('nav-active')
    $('.weui-menu-inner').eq(a).addClass('nav-active');
}*/


var more = function () {
    $(function(){
//页数
        var page = 0;
        // 每页展示10个
        var size =10;
        $('.weui_panel').dropload({
            scrollArea : window,
            autoLoad : true,//自动加载
            domDown : {//上拉
                domClass   : 'dropload-down',
                domRefresh : '<div class="dropload-refresh f15 "><i class="icon icon-20"></i>上拉加载更多</div>',
                domLoad    : '<div class="dropload-load f15"><span class="weui-loading"></span>正在加载中...</div>',
                domNoData  : '<div class="dropload-noData">没有更多数据了</div>'
            },
            loadDownFn : function(me){//加载更多
                page++;
                window.history.pushState(null, document.title, window.location.href);
                var result = '';
                $.ajax({
                    type: 'GET',
                    url:'http://127.0.0.1/my.php?page='+page,
                    dataType: 'json',
                    success: function(data){
                        console.log(data);
                        var arrLen = data.length;
                        console.log(arrLen);
                        if(arrLen > 0){


                            for(var i=0; i<arrLen; i++){
                                result+='  <a href="" class="weui_media_box weui_media_appmsg">'
                                    +'<div class="weui_media_hd weui-updown">'
                                    +'</div>'
                                    +'<div class="weui_media_bd">'
                                    +'<h4 class="weui_media_title">'+data[i].name+' '+data[i].name+'</h4>'
                                    +'<p class="weui_media_desc">'+data[i].number+'</p>'
                                    +'</div>'
                                    +'</a>';
                            }
                            // 如果没有数据
                        }else{
                            // 锁定
                            me.lock();
                            alert('lock');
                            // 无数据
                            me.noData();
                            alert('no');
                        }

                        // 为了测试，延迟1秒加载
                        setTimeout(function(){
                            $('.weui_panel_bd').append(result);
                            var lazyloadImg = new LazyloadImg({
                                el: '.weui-updown [data-img]', //匹配元素
                                top: 50, //元素在顶部伸出长度触发加载机制
                                right: 50, //元素在右边伸出长度触发加载机制
                                bottom: 50, //元素在底部伸出长度触发加载机制
                                left: 50, //元素在左边伸出长度触发加载机制
                                qriginal: false, // true，自动将图片剪切成默认图片的宽高；false显示图片真实宽高
                                load: function(el) {
                                    el.style.cssText += '-webkit-animation: fadeIn 01s ease 0.2s 1 both;animation: fadeIn 1s ease 0.2s 1 both;';
                                },
                                error: function(el) {

                                }
                            });
                            //
                            // 每次数据加载完，必须重置
                            me.resetload();
                        },1000);
                    },
                    error: function(xhr, type){
                        console.log(123);
                        // 即使加载出错，也得重置
                        me.resetload();
                        // 锁定
                        me.lock();
                        // 无数据
                        me.noData();
                    }
                });
            }
        });






    });
}