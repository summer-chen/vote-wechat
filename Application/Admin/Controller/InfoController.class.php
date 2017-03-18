<?php
/**
 * Created by PhpStorm.
 * User: john zhou
 * Date: 2017/2/22
 * Time: 15:59
 */
namespace Admin\Controller;
use Think\Controller;
class InfoController extends BaseController{

    public function info(){
        $this->display();
    }

    //添加比赛信息详情
    public function add(){
        if(IS_POST){
            $infoModel = D("info");
            if($infoModel->create($_POST)){
                if($infoModel->save($_POST)){
                    echo getjsondata(1,'success');
                    exit();
                }
            }
            echo getjsondata(0,$infoModel->getError());
        }
    }

    //获得全部信息
    public function getall(){
        if(IS_POST){
            $infoModel = D("info");
            $data = $infoModel->select();
            echo getjsondata(1,$data);
        }
    }

}