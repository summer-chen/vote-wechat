<?php
namespace Home\Controller;
use Think\Controller;
use Home\Model\Wechat;
use Home\Model\Jssdk;

class IndexController extends Controller {

    private $appid = "wxf633460ea7e938e2";
    private $secret ="a57f9d7b25935cd3b40c68934eae9d2b";

    //链接:https://open.weixin.qq.com/connect/oauth2/authorize?appid=wxdf27e74d068b2ba1&redirect_uri=http://l-chuzhou.cn/vote/index.php/Home/Index/index&response_type=code&scope=snsapi_base&state=123#wechat_redirect
    public function forward(){
        $jssdk = new Jssdk($this->appid, $this->secret);

        $news = array("Title" =>"微信公众平台开发实践", "Description"=>"本书共分10章，案例程序采用广泛流行的PHP、MySQL、XML、CSS、JavaScript、HTML5等程序语言及数据库实现。", "PicUrl" =>'http://images.cnitblog.com/i/340216/201404/301756448922305.jpg', "Url" =>'http://www.cnblogs.com/txw1958/p/weixin-development-best-practice.html');
        $signPackage = $jssdk->getSignPackage();
        $this->assign("signPackage",$signPackage);
        $this->assign("news",$news);
        $this->display();
    }

    public function forward1(){
        $jssdk = new Jssdk($this->appid, $this->secret);

        $news = array("Title" =>"forward微信公众平台开发实践", "Description"=>"本书共分10章，案例程序采用广泛流行的PHP、MySQL、XML、CSS、JavaScript、HTML5等程序语言及数据库实现。", "PicUrl" =>'http://images.cnitblog.com/i/340216/201404/301756448922305.jpg', "Url" =>'http://www.cnblogs.com/txw1958/p/weixin-development-best-practice.html');
        $signPackage = $jssdk->getSignPackage();
        $this->assign("signPackage",$signPackage);
        $this->assign("news",$news);
        $this->display();
    }

    /**
     * 微信端登录
     * 链接:https://open.weixin.qq.com/connect/oauth2/authorize?appid=wxdf27e74d068b2ba1&redirect_uri=http://l-chuzhou.cn/vote/index.php/Home/Index/index&response_type=code&scope=snsapi_base&state=123#wechat_redirect
     */
    public function login(){

        $jssdk = new Jssdk($this->appid, $this->secret);
        $code = $_POST['code'];

        //得到用户信息
        $userinfo = $jssdk->_getuserinfo($code);
        $userinfo = json_decode($userinfo);
        if($userinfo->nickname){
            $openid = $userinfo->openid;
            $userModel = M('user');
            $where = array(
                'openid'=>array('eq',$openid)
            );
            $userdata = $userModel->where($where)->select();
            if (!$userdata){
                $res = $userModel->add(array(
                    'username'=>$userinfo->nickname,
                    'openid'=>$openid,
                    'headimg'=>$userinfo->headimgurl
                ));
                if(!$res){
                    echo getjsondata(0,'登录失败,请重试');
                    exit();
                }
            }
            session('uid',$userdata[0]['uid']);
            session('username',$userdata[0]['username']);
            session('openid',$userdata[0]['openid']);
            echo getjsondata(1,'success');
        }else{
            echo getjsondata(0,'登录失败,请重试');
            exit();
        }
    }

    /**
     * 微信端首页
     */
    public function index(){
        //轮播图数据
        $carouselModel = D("carousel");
        $carouselData = $carouselModel->field("cid,picurl")->select();

        //大赛信息
        $infoModel = D('info');
        $infodata = $infoModel->select();

        foreach($infodata as $k=>$v){
            $infodata[$k]['content'] = base64_encode($infodata[$k]['content']);
        }

        echo getjsondata(1,array(
            'carouseldata' => $carouselData,
            'infodata' => $infodata
        ));
    }

    //链接:https://open.weixin.qq.com/connect/oauth2/authorize?appid=wxdf27e74d068b2ba1&redirect_uri=http://l-chuzhou.cn/vote/index.php/Home/Index/show&response_type=code&scope=snsapi_base&state=123#wechat_redirect
    public function show(){
        $jssdk = new Jssdk($this->appid, $this->secret);
        $signPackage = $jssdk->GetSignPackage();
        echo getjsondata(1,$signPackage);
    }

    /**
     * 从微信服务器下载图片
     */
    public function download(){

        $url = "http://summer.tunnel.qydev.com/vote/";
        $jssdk = new Jssdk($this->appid, $this->secret);

        $cid = I('post.cid');
        $media_id = I('post.media_id');
        file_put_contents("./media_id",$media_id);
        $path = $jssdk->saveMedia($media_id);
        if(strpos($path,".jpeg")){
             $url = $url.$path;
             $imageModel = M("image");
             $imageid = $imageModel->add(array(
                 'imageurl'=>$url,
             ));
             $competitor_imageModel = M("competitor_image");
             $data = array(
                 'imageid'=>$imageid,
                 'competitorid'=>$cid,
             );
             $competitor_imageModel->add($data);
             echo getjsondata(1,array(
                 'url'=>$url
             ));
         }else{
             echo getjsondata(0,"上传失败,请重试");
         }

    }

    /**
     * 图片预览
     */
    public function preview(){
        $jssdk = new Jssdk($this->appid, $this->secret);
        $signPackage = $jssdk->GetSignPackage();
        $imageModel = M("image");
        $data = $imageModel->field("imageurl")->select();
        $res = null;
        foreach($data as $k=>$v){
            $res[] = $v['imageurl'];
        }
        $this->assign("data",json_encode($res));
        $this->assign("signPackage",$signPackage);
        $this->display();
    }

    public function image(){
        $imageModel = M("image");
        $data = $imageModel->field("imageurl")->select();
        $res = null;
        foreach($data as $k=>$v){
            $res[] = $v['imageurl'];
        }
        echo json_encode($res);
    }

   /**
     * 判断是否登录
     */
    public function islogin(){
        $uid = session("uid");
        if($uid){
            echo getjsondata(1,'success');
        }else{
            echo getjsondata(0,"fail");
        }
    }
}