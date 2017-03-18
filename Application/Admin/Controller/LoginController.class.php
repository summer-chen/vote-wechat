<?php
/**
 * Created by PhpStorm.
 * User: Hokkaido
 * Date: 2017/2/27
 * Time: 20:22
 */
namespace Admin\Controller;
use Think\Controller;
class LoginController extends Controller{

    /**
     * 登录逻辑
     */
    public function login(){
        if(IS_POST){
            $adminModel = D("admin");
            if($adminModel->create(I('post.'))){
                if($adminModel->login()){
                    echo getjsondata(1,'success');
                    exit();
                }
            }
            echo getjsondata(0,$adminModel->getError());
        }else{
            $this->display();
        }
    }

    /**
     * 生成验证码
     */
    public function getcode(){
        $config =    array(
            'fontSize'    =>    30,    // 验证码字体大小
            'length'      =>    2,     // 验证码位数
            'useNoise'    =>    true, // 关闭验证码杂点
        );
        $Verify =     new \Think\Verify($config);
        $Verify->entry();
    }

    /**
     * 修改密码
     */
    public function changepassword(){
        $newpassword = I("post.newpassword");
        if($newpassword){
            $adminModel = D("admin");
            $res = $adminModel->changepassword($newpassword);
            if($res['result']){
                echo getjsondata(1,'success');
            }else{
                echo getjsondata(0,$res['info']);
            }
        }else{
            echo getjsondata(0,"新密码不能为空");
        }
    }

    /**
     * 退出登录
     */
    public function logout(){
        session("adminid",null);
        session("adminname",null);
        $this->display("Login/login");
    }

}