<?php

namespace Home\Model;

class Wechat{	


	private $appid;
	private $appsecret;
	private $access_token;

	function __construct($options){
		$this->appid = isset($options['appid'])?$options['appid']:'';
		$this->appsecret = isset($options['appsecret'])?$options['appsecret']:'';
		$this->_getAccesstoken($this->appid,$this->appsecret);
	}

	/**
	**发送post和get请求
	**/
	public function _request($curl, $https=true, $method='get', $data=null){
		$ch = curl_init();//初始化
		curl_setopt($ch, CURLOPT_URL, $curl);//设置访问的URL
		curl_setopt($ch, CURLOPT_HEADER, false);//设置不需要头信息
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);//只获取页面内容，但不输出
		if($https){
			curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);//不做服务器认证
			curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);//不做客户端认证
		}
		if($method == 'post'){
			curl_setopt($ch, CURLOPT_POST, true);//设置请求是POST方式
			curl_setopt($ch, CURLOPT_POSTFIELDS, $data);//设置POST请求的数据
		}
		$str = curl_exec($ch);//执行访问，返回结果
		curl_close($ch);//关闭curl，释放资源
		return $str;
	}


	/**
	 * 获得access_token
	**/
	public function _getAccesstoken($appid,$secret){

		$file = './access_token';
		if(file_exists($file)){
			$content = file_get_contents($file);
			$content = json_decode($content);
			if(time()-filemtime($file)<7200)
				$this->access_token = $content->access_token;
		}
		$content = $this->_request("https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid=$appid&secret=$secret");

		$content = json_decode($content);
		file_put_contents($file, $content->access_token);
		$this->access_token = $content->access_token;
	 }

	/**
	* 获取用户微信信息
	*/
	public function _getuserinfo($code){

	 $curl = "https://api.weixin.qq.com/sns/oauth2/access_token?appid=$this->appid&secret=$this->appsecret&code=$code&grant_type=authorization_code";
	 $res = $this->_request($curl,true,'get');
	 $res = json_decode($res);
	 $openid = $res->openid;
	 $curl = "https://api.weixin.qq.com/cgi-bin/user/info?access_token=%s&openid=%s&lang=zh_CN";

	 $curl = vsprintf($curl,array($this->access_token,$openid));

	 $res = $this->_request($curl,true,'get');
	 return $res;
	}


	/**
	* 获取用户微信信息(开发者中心时选用这种方法)
	*/
	public function _getuserinfoforopen($code){

	$access_tokenurl = "https://api.weixin.qq.com/sns/oauth2/access_token?appid=%s&secret=%s&code=%s&grant_type=authorization_code";
	$access_tokenurl = vsprintf($access_tokenurl,array($this->appid,$this->appsecret,$code));
	$content = $this->_request($access_tokenurl);

	$content = json_decode($content);
	$openid_open = $content->openid;
	$access_token_open = $content->access_token;

	$curl = "https://api.weixin.qq.com/sns/userinfo?access_token=$access_token_open&openid=$openid_open";
	$res = $this->_request($curl,true,'get');
	return $res;
	}

	/**
	* 获得ticket
	*/
	public function getticket(){
	 $file = "./ticket";
	 $ticket = null;
	 if(file_exists($file)){
		 $content = file_get_contents($file);
		 if(time()-filemtime($file)<7200) {
			 $ticket = $content;
			 return $ticket;
		 }
	 }

	 $content = $this->_request("https://api.weixin.qq.com/cgi-bin/ticket/getticket?access_token=".$this->access_token."&type=jsapi");

	 $content = json_decode($content);
	 file_put_contents($file, $content->ticket);
	 $ticket = $content->ticket;

	 return $ticket;
	}

	/**
	 * 签名算法的实现
	 * @return array
	 */
	public function getSignPackage() {
		$jsapiTicket = $this->getticket();

		// 注意 URL 一定要动态获取，不能 hardcode.
		$protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off' || $_SERVER['SERVER_PORT'] == 443) ? "https://" : "http://";
		$url = "$protocol$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";

		$timestamp = time();
		$nonceStr = $this->createNonceStr();

		// 这里参数的顺序要按照 key 值 ASCII 码升序排序
		$string = "jsapi_ticket=$jsapiTicket&noncestr=$nonceStr&timestamp=$timestamp&url=$url";

		$signature = sha1($string);

		$signPackage = array(
				"appId"     => $this->appid,
				"nonceStr"  => $nonceStr,
				"timestamp" => $timestamp,
				"url"       => $url,
				"signature" => $signature,
				"rawString" => $string
		);
		return $signPackage;
	}

	private function createNonceStr($length = 16) {
		$chars = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";
		$str = "";
		for ($i = 0; $i < $length; $i++) {
			$str .= substr($chars, mt_rand(0, strlen($chars) - 1), 1);
		}
		return $str;
	}
}
