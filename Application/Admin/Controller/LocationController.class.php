<?php
/**
 * Created by PhpStorm.
 * User: john zhou
 * Date: 2017/2/22
 * Time: 17:11
 */
namespace Admin\Controller;
use Think\Controller;
class LocationController extends BaseController{

    //展示赛区列表
    public function lst(){
        if(IS_POST){
            $locationModel = D('location');
            $data = $locationModel->select();
            echo getjsondata(1,$data);
        }else{
            $this->display();
        }
    }

    //添加赛区
    public function add(){
        if(IS_POST){
            $locationModel = D("location");
            if($locationModel->create(I('post.'))){
                $res = $locationModel->add(I('post.'));
                if($res){
                    $count = $locationModel->count();
                    echo getjsondata(1,array(
                        'index'=>$count,
                        'lid'=>$res,
                    ));
                    exit();
                }
            }
            echo getjsondata(0,$locationModel->getError());
        }
    }

    //修改赛区
    public function update(){
        if(IS_POST){
            $locationModel = D('location');
            if($locationModel->create(I('post.'))){
                if($locationModel->save(I('post.'))){
                    $data = $locationModel->find(I('post.lid'));
                    echo getjsondata(1,$data);
                    exit();
                }
            }
            echo getjsondata(0,$locationModel->getError());
        }
    }

    //删除赛区
    public function del(){
        if(IS_POST){
            $lid = I("post.lid");
            if($lid){
                $locationModel = D("location");
                if($locationModel->delete($lid)){
                    echo getjsondata(1,array(
                        'lid'=>$lid
                    ));
                }else{
                    echo getjsondata(0,$locationModel->getError());
                }
            }
        }
    }


}