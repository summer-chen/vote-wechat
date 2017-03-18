<?php
/**
 * Created by PhpStorm.
 * User: john zhou
 * Date: 2017/2/21
 * Time: 20:43
 */
namespace Admin\Controller;
use Think\Controller;
class CarouselController extends BaseController{

    //添加轮播图
    public function add(){
        if(IS_POST){
            $carouselModel = D('Carousel');
            if($carouselModel->create($_POST)){
                if($carouselModel->add($_POST)){
                    echo getjsondata(1,'success');
                    exit();
                }
            }
            echo getjsondata(0,$carouselModel->getError());
        }else {
            $this->display();
        }
    }

    //轮播图列表
    public function lst(){
        if(IS_POST){
            $carouselModel = D('Carousel');
            $data = $carouselModel->field('cid,picurl')->select();
            echo getjsondata(1,$data);
        }else{
            $this->display();
        }
    }

    //根据id查询轮播图的信息
    public function getdata(){
        $cid = I("post.cid");
        if($cid){
            $carouselModel = D("Carousel");
            $data = $carouselModel->find($cid);
            echo getjsondata(1,$data);
        }
    }

    //修改轮播图
    public function update(){
        if(IS_POST){
            $carouselModel = D('Carousel');
            if($carouselModel->create($_POST)){
                if(false !== $carouselModel->save($_POST)){
                    $data = $carouselModel->field('cid,picurl')->find(I('post.cid'));
                    echo getjsondata(1,$data);
                    exit();
                }
            }
            echo getjsondata(0,$carouselModel->getError());
        }
    }

    //删除轮播图
    public function del(){
        $cid = I('post.cid');
        if($cid){
            $carouselModel = D('Carousel');
            if($carouselModel->delete($cid)){
                echo getjsondata(1,array(
                    'cid'=>$cid
                ));
            }else{
                echo getjsondata(0,$carouselModel->getError());
            }
        }
    }
}