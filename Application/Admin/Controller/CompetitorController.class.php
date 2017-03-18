<?php
/**
 * Created by PhpStorm.
 * User: Hokkaido
 * Date: 2017/2/24
 * Time: 16:28
 */
namespace Admin\Controller;
use Think\Controller;
class CompetitorController extends BaseController{

    /**
     * 选手审核
     */
    public function lst(){
        $competitorModel = D("Competitor");
        $data = $competitorModel->lst();
        $this->assign($data);
        $this->display();
    }

    /**
     * 通过审核
     */
    public function check(){
        $cid = I('post.cid');
        if($cid){
            $competitorModel = D("competitor");
            $where = array(
                'cid' => array('eq',$cid),
            );
            $res = $competitorModel->where($where)->setField("is_pass",1);
            if(false !== $res){
                echo getjsondata(1,array(
                    'cid'=>$cid
                ));
            }else{
                echo getjsondata(0,'操作失败');
            }
        }else{
            echo getjsondata(1,"请传递通过审核的选手的id");
        }
    }

    /**
     * 获得通过审核的选手
     */
    public function pass(){
        $competitorModel = D("competitor");
        $data = $competitorModel->pass();
        $this->assign($data);
        $this->display();
    }

    /**
     * 根据选手的id获得其支持记录
     */
    public function record(){
        $cid = I("post.cid");
        if($cid){
            $competitorModel = D("competitor");
            $data = $competitorModel->record($cid);
            echo getjsondata(1,$data);
        }
    }

    //删除选手
    public function delete(){
        $cid = I("post.cid");
        if($cid){
            $competitorModel = M("competitor");
            $where = array(
                'cid'=>array('eq',$cid),
            );
            $res = $competitorModel->where($where)->setField("is_delete",1);
            if($res){
                echo getjsondata(1,"success");
            }else{
                echo getjsondata(0,$competitorModel->getError());
            }
        }else{
            echo getjsondata(0,"请传递要删除的选手的id");
        }
    }

    /**
     * 选手图片展示
     */
    public function show(){
        $cid = I("post.cid");
        if($cid){
            $competitorModel = D("competitor");
            $data = $competitorModel->show($cid);
            echo getjsondata(1,$data);
        }else{
            echo getjsondata(0,"请传递选手id");
        }

    }
}