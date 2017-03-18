<?php

namespace Home\Model;

class Jssdk{
  private $appId;
  private $appSecret;

  public function __construct($appId, $appSecret) {
    $this->appId = $appId;
    $this->appSecret = $appSecret;
  }

  public function getSignPackage() {
    $jsapiTicket = $this->getJsApiTicket();

    // 注意 URL 一定要动态获取，不能 hardcode.
    $protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off' || $_SERVER['SERVER_PORT'] == 443) ? "https://" : "http://";
//    $url = "$protocol$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
    $url = "http://summer.tunnel.qydev.com/vote/phone/index.html";

    $timestamp = time();
    $nonceStr = $this->createNonceStr();

    // 这里参数的顺序要按照 key 值 ASCII 码升序排序
    $string = "jsapi_ticket=$jsapiTicket&noncestr=$nonceStr&timestamp=$timestamp&url=$url";

    $signature = sha1($string);

    $signPackage = array(
      "appId"     => $this->appId,
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

  private function getJsApiTicket() {
    // jsapi_ticket 应该全局存储与更新，以下代码以写入到文件中做示例
    $data = json_decode($this->get_php_file("./jsapi_ticket.php"));
    if ($data->expire_time < time()) {
      $accessToken = $this->getAccessToken();
      // 如果是企业号用以下 URL 获取 ticket
      // $url = "https://qyapi.weixin.qq.com/cgi-bin/get_jsapi_ticket?access_token=$accessToken";
      $url = "https://api.weixin.qq.com/cgi-bin/ticket/getticket?type=jsapi&access_token=$accessToken";
      $res = json_decode($this->_request($url));
      $ticket = $res->ticket;
      if ($ticket) {
        $data->expire_time = time() + 7000;
        $data->jsapi_ticket = $ticket;
        $this->set_php_file("./jsapi_ticket.php", json_encode($data));
      }
    } else {
      $ticket = $data->jsapi_ticket;
    }

    return $ticket;
  }

  private function getAccessToken() {
    // access_token 应该全局存储与更新，以下代码以写入到文件中做示例
    $data = json_decode($this->get_php_file("./access_token.php"));
    if ($data->expire_time < time()) {
      // 如果是企业号用以下URL获取access_token
      // $url = "https://qyapi.weixin.qq.com/cgi-bin/gettoken?corpid=$this->appId&corpsecret=$this->appSecret";
      $url = "https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid=$this->appId&secret=$this->appSecret";
      $res = json_decode($this->_request($url));
      $access_token = $res->access_token;
      if ($access_token) {
        $data->expire_time = time() + 7000;
        $data->access_token = $access_token;
        $this->set_php_file("access_token.php", json_encode($data));
      }
    } else {
      $access_token = $data->access_token;
    }
    return $access_token;
  }

  private function httpGet($url) {
    $curl = curl_init();
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($curl, CURLOPT_TIMEOUT, 500);
    // 为保证第三方服务器与微信服务器之间数据传输的安全性，所有微信接口采用https方式调用，必须使用下面2行代码打开ssl安全校验。
    // 如果在部署过程中代码在此处验证失败，请到 http://curl.haxx.se/ca/cacert.pem 下载新的证书判别文件。
    curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, true);
    curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, true);
    curl_setopt($curl, CURLOPT_URL, $url);

    $res = curl_exec($curl);
    curl_close($curl);

    return $res;
  }

  private function get_php_file($filename) {
    return trim(substr(file_get_contents($filename), 15));
  }
  private function set_php_file($filename, $content) {
    $fp = fopen($filename, "w");
    fwrite($fp, "<?php exit();?>" . $content);
    fclose($fp);
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

  /*public function download($medis_id){
    ob_start();
    $filename=$fileurl;
    $date=date("Ymd-H:i:m");
    header( "Content-type:   application/octet-stream ");
    header( "Accept-Ranges:   bytes ");
    header( "Content-Disposition:   attachment;   filename= {$date}.doc");
    $size=readfile($filename);
    header( "Accept-Length: " .$size);
  }*/

  /**
   * 从服务器下载图片
   * @param $media_id
   * @param string $file
   * @param int $timeout
   * @return bool|mixed|string
   */
  function httpcopy($media_id, $file="./test.jpg", $timeout=60) {
    $accesstoken = $this->getAccessToken();
    $url = "http://file.api.weixin.qq.com/cgi-bin/media/get?access_token=$accesstoken&media_id=$media_id";
    $file = empty($file) ? pathinfo($url,PATHINFO_BASENAME) : $file;
    $dir = pathinfo($file,PATHINFO_DIRNAME);
    !is_dir($dir) && @mkdir($dir,0755,true);
    $url = str_replace(" ","%20",$url);

    if(function_exists('curl_init')) {
      $ch = curl_init();
      curl_setopt($ch, CURLOPT_URL, $url);
      curl_setopt($ch, CURLOPT_TIMEOUT, $timeout);
      curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
      $temp = curl_exec($ch);
      if(@file_put_contents($file, $temp) && !curl_error($ch)) {
        return $file;
      } else {
        return false;
      }
    } else {
      $opts = array(
          "http"=>array(
              "method"=>"GET",
              "header"=>"",
              "timeout"=>$timeout
      ));
      $context = stream_context_create($opts);
      if(@copy($url, $file, $context)) {
        //$http_response_header
        return $file;
      } else {
        return false;
      }
    }
  }

  //下载多媒体文件
  function saveMedia($media_id){
    $accesstoken = $this->getAccessToken();
    $url = "http://file.api.weixin.qq.com/cgi-bin/media/get?access_token=$accesstoken&media_id=$media_id";
    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_HEADER, 0);
    curl_setopt($ch, CURLOPT_NOBODY, 0);    //对body进行输出。
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    $package = curl_exec($ch);
    $httpinfo = curl_getinfo($ch);

    curl_close($ch);
    $media = array_merge(array('mediaBody' => $package), $httpinfo);

    //求出文件格式
    preg_match('/\w\/(\w+)/i', $media["content_type"], $extmatches);
    $fileExt = $extmatches[1];
    $filename = time().rand(100,999).".{$fileExt}";
    $dirname = "wximages/";
    if(!file_exists($dirname)){
      mkdir($dirname,0777,true);
    }
    file_put_contents($dirname.$filename,$media['mediaBody']);
    return $dirname.$filename;
  }

  /**
   * 获取用户微信信息
   */
  public function _getuserinfo($code){
    $access_token = $this->getAccessToken();
    $curl = "https://api.weixin.qq.com/sns/oauth2/access_token?appid=$this->appId&secret=$this->appSecret&code=$code&grant_type=authorization_code";
    $res = $this->_request($curl,true,'get');
    $res = json_decode($res);
    $openid = $res->openid;
    $curl = "https://api.weixin.qq.com/cgi-bin/user/info?access_token=%s&openid=%s&lang=zh_CN";

    $curl = vsprintf($curl,array($access_token,$openid));

    $res = $this->_request($curl,true,'get');
    return $res;
  }


  /**
   * 获取用户微信信息(开发者中心时选用这种方法)
   */
  public function _getuserinfoforopen($code){

    $access_tokenurl = "https://api.weixin.qq.com/sns/oauth2/access_token?appid=%s&secret=%s&code=%s&grant_type=authorization_code";
    $access_tokenurl = vsprintf($access_tokenurl,array($this->appId,$this->appSecret,$code));
    $content = $this->_request($access_tokenurl);

    $content = json_decode($content);
    $openid_open = $content->openid;
    $access_token_open = $content->access_token;

    $curl = "https://api.weixin.qq.com/sns/userinfo?access_token=$access_token_open&openid=$openid_open";
    $res = $this->_request($curl,true,'get');
    return $res;
  }

}

