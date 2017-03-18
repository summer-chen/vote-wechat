<?php
/**
 * Created by PhpStorm.
 * User: Hokkaido
 * Date: 2017/2/27
 * Time: 20:23
 */
namespace Admin\Model;
use Think\Model;
class AdminModel extends Model{

    //登录时的校验数据
    protected $_validate = array(
        array('adminname','require','账号不能为空',1),
        array('adminpass','require','密码不能为空',1),
        array('code','require','验证码不能为空',1),
        array('code','check_code','验证码不正确',1,'callback')
    );

    function check_code(){
        $code = I('post.code');
        $verify = new \Think\Verify();
        return $verify->check($code, '');
    }
    /**
     * 登录逻辑
     */
    public function login(){

        $adminname = I('post.adminname');
        $adminpass = I('post.adminpass');

        $where = array(
            'adminname'=>array('eq',$adminname),
            'adminpass'=>array('eq',$adminpass),
        );

        $admin = $this->where($where)->select();
        if($admin){
            session("adminid",$admin[0]['aid']);
            session("adminname",$admin[0]['adminname']);
            return true;
        }else{
            $this->error = "账号或密码错误";
            return false;
        }
    }

    /**
     * 修改密码
     */
    public function changepassword($newpassword){
        $aid = session("adminid");
        if($aid){
            $where = array(
                'aid'=>array('eq',$aid),
            );
            $res = $this->where($where)->setField("adminpass",md5($newpassword));
            if(false !== $res){
                return array(
                    'result'=>true,
                    'info'=>'success',
                );
            }else{
                return array(
                    'result'=>false,
                    'info'=>$this->getError(),
                );
            }
        }else{
            return array(
                'result'=>false,
                'info'=>'请重新登录',
            );
        }
    }

}