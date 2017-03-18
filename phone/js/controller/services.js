myApp.factory("Services", ["$location","$http", function($location,$http) {
	var sendCode;
	var loginCheck = function(userToken,tempUrl) {
		if(userToken == "true" || userToken == true) {
			return true;
		} else {
			sessionStorage.tempUrl = tempUrl;
			return false;
		}
	};
	var setSendCode = function(sendcode) {
		sendCode = sendcode;
	};
	var getSendCode = function() {
		return sendCode;
	};
	var isLogin = function(userToken) {
		sessionStorage.userToken = userToken;
		if(userToken == "true" || userToken == true) {
			return true;
		} else {
			if($location.path().indexOf("support")>=0){
				$location.path("/user");
				return false;
			} else {
				return false;
			}
		}
	};

	var getsignature = function(){
		$http.post(baseUrl + "index.php/Home/Index/show")
				.success(function(result){
					switch (result.serviceResult) {
						case 1:
							console.log();
							wx.config({
								debug: false,
								appId: result.resultinfo.appId,
								timestamp: result.resultinfo.timestamp,
								nonceStr: result.resultinfo.nonceStr,
								signature: result.resultinfo.signature,
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
							break;
						case 0:
							alert("页面加载错误,请重试");
							break;
					}
				});

	};

	var share = function(cid) {
		var data = {
			cid:cid
		};
		wx.onMenuShareAppMessage({
			title: '选美大赛',
			desc: '选美大赛',
			link: 'http://summer.tunnel.qydev.com/vote/phone/index.html#/people/'+cid,
			imgUrl: "http://wteam14.cn/vote/wximages/1489222854955.jpeg",
			trigger: function (res) {
				// 不要尝试在trigger中使用ajax异步请求修改本次分享的内容，因为客户端分享操作是一个同步操作，这时候使用ajax的回包会还没有返回
				//alert('用户点击发送给朋友');
			},
			success: function (res) {
				$http.post(baseUrl + "index.php/Home/Competitor/share",data)
						.success(function(result){
							switch (result.serviceResult){
								case 1:
									alert("分享成功!");
									break;
								case 0:
									alert(result.resultinfo);
									break;
							}
						});
			},
			cancel: function (res) {
				//alert('已取消');
			},
			fail: function (res) {
				//alert(JSON.stringify(res));
			}
		});

		wx.onMenuShareTimeline({
			title: '选美大赛',
			link: 'http://summer.tunnel.qydev.com/vote/phone/index.html#/people/'+cid,
			imgUrl: "http://wteam14.cn/vote/wximages/1489222854955.jpeg",
			trigger: function (res) {
				// 不要尝试在trigger中使用ajax异步请求修改本次分享的内容，因为客户端分享操作是一个同步操作，这时候使用ajax的回包会还没有返回
				//alert('用户点击分享到朋友圈');
			},
			success: function (res) {
				$http.post(baseUrl + "index.php/Home/Competitor/share",data)
						.success(function(result){
							switch (result.serviceResult){
								case 1:
									alert("分享成功!");
									break;
								case 0:
									alert(result.resultinfo);
									break;
							}
						});
			},
			cancel: function (res) {
				//alert('已取消');
			},
			fail: function (res) {
				//alert(JSON.stringify(res));
			}
		});
	};


	return {
		loginCheck:loginCheck,
		setSendCode:setSendCode,
		getSendCode:getSendCode,
		isLogin:isLogin,
		getsignature:getsignature,
		share:share
	};
}]);
