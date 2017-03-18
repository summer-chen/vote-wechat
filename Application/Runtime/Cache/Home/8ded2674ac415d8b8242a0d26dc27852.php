<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>分享到朋友圈</title>
</head>
<body>
    <button onclick="test()">点击分享</button>
</body>
<script src="http://res.wx.qq.com/open/js/jweixin-1.0.0.js"></script>
<script type="text/javascript">

    wx.config({
        debug: true,
        appId: '<?php echo $signPackage["appId"];?>',
        timestamp: '<?php echo $signPackage["timestamp"];?>',
        nonceStr: '<?php echo $signPackage["nonceStr"];?>',
        signature: '<?php echo $signPackage["signature"];?>',
        jsApiList: [
            // 所有要调用的 API 都要加到这个列表中
            // 必填，需要使用的JS接口列表，所有JS接口列表见附录2
            'checkJsApi',
            'openLocation',
            'getLocation',
            'onMenuShareTimeline',
            'onMenuShareAppMessage',
            'chooseImage',
            'uploadImage'
        ]
    });

    wx.ready(function(){

        wx.onMenuShareAppMessage({
            title: '<?php echo $news["Title"];?>',
            desc: '<?php echo $news["Description"];?>',
            link: '<?php echo $news["Url"];?>',
            imgUrl: '<?php echo $news["PicUrl"];?>',
            trigger: function (res) {
                // 不要尝试在trigger中使用ajax异步请求修改本次分享的内容，因为客户端分享操作是一个同步操作，这时候使用ajax的回包会还没有返回
                alert('用户点击发送给朋友');
            },
            success: function (res) {
                alert('已分享了啊');
            },
            cancel: function (res) {
                alert('已取消');
            },
            fail: function (res) {
                alert(JSON.stringify(res));
            }
        });

        function share() {
            alert("haha");
        }

    });

    function test(){
        wx.onMenuShareAppMessage({
            title: '<?php echo $news["Title"];?>',
            desc: '<?php echo $news["Description"];?>',
            link: '<?php echo $news["Url"];?>',
            imgUrl: '<?php echo $news["PicUrl"];?>',
            trigger: function (res) {
                // 不要尝试在trigger中使用ajax异步请求修改本次分享的内容，因为客户端分享操作是一个同步操作，这时候使用ajax的回包会还没有返回
                alert('用户点击发送给朋友');
            },
            success: function (res) {
                console.log(res);
                alert('已分享了啊');
            },
            cancel: function (res) {
                alert('已取消');
            },
            fail: function (res) {
                alert(JSON.stringify(res));
            }
        });
    }


</script>
</html>