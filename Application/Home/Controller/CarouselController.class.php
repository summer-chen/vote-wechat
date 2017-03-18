<?php
/**
 * Created by PhpStorm.
 * User: Hokkaido
 * Date: 2017/2/27
 * Time: 8:42
 */
namespace Home\Controller;
use Think\Controller;
class CarouselController extends Controller{

    /**
     * 根据id获得轮播图的详情
     */
    public function detail(){
        $cid = I('post.cid');
        if($cid){
            $carouselModel = D("carousel");
            $data = $carouselModel->field("content")->find($cid);
            echo getjsondata(1,$data);
        }else{
            echo getjsondata(0,'请传递要查询的id');
        }
    }

}