<?php
/**
 * Created by PhpStorm.
 * User: Hokkaido
 * Date: 2017/2/23
 * Time: 15:04
 */
namespace Home\Controller;
use Think\Controller;
class CompetitorController extends Controller{

    /**
     * 获得全部的赛区
     */
    public function getlocation(){
        $locationModel = M('location');
        $data = $locationModel->select();
        echo getjsondata(1,$data);
    }

    /**
     * 微信端选手报名
     */
    public function enroll(){
        if(IS_POST){
            $competitorModel = D("competitor");
            if($competitorModel->create(I('post.'))){
                $cid = $competitorModel->add(I('post.'));
                if($cid){
                    echo getjsondata(1,array(
                        'cid'=>$cid,
                    ));
                    exit();
                }
            }
            echo getjsondata(0,$competitorModel->getError());
        }
    }

    /**
     * 选手风采页
     */
    public function mien(){
        $competitorModel = D("competitor");
        $data = $competitorModel->mien();
        echo getjsondata(1,$data);
    }

    /**
     * 选手详情页面
     */
    public function detail(){
        $cid = I('post.cid');
        if($cid){
            $competitorModel = D("competitor");
            $data = $competitorModel->find($cid);
            echo getjsondata(1,$data);
        }else{
            echo getjsondata(0,"请传递要查询的选手的id");
        }
    }

    /**
     * 投票支持选手
     */
    public function support(){
        $cid = I('post.cid');
        if($cid){
            $uid = session("uid");
            if(!$uid){
                echo getjsondata(0,"请重新登录");
                exit();
            }

            //判断是否到达六次
            $recordModel = M("record");
            $where = array(
                'cid'=>array('eq',$cid),
                'pid'=>array('eq',1),
                'uid'=>array('eq',$uid),
                'time'=>array('eq',date('Y-m-d'),time()),
            );

            $count = $recordModel->where($where)->count();
            if($count >= 6){
                echo getjsondata(0,"每天只能投6票");
                exit();
            }

            $competitorModel = D("competitor");
            $competitorModel->startTrans();//开启事务
            //处理投票逻辑
            try{
                //看看该选手是否是第一次被投票
                $countModel = M('count');
                $where = array(
                    'competitor'=>array('eq',$cid),
                    'present'=>array('eq',1),
                );
                $count = $countModel->where($where)->count();
                if($count == 0){  //是第一次被投票 执行插入操作
                    $insert_data = array(
                        'competitor'=>$cid,
                        'present'=>1,
                        'count'=>1,
                    );
                    $res = $countModel->add($insert_data);
                    if(!$res){
                        throw new \Exception();
                    }
                } else{ //不是第一次被投票 执行修改操作
                    $res = $countModel->where($where)->setInc("count",1); //数量加1
                    if(!$res){
                        throw new \Exception();
                    }
                }

                //添加到记录表
                $insert_data = array(
                    'cid'=>$cid,
                    'pid'=>1,
                    'uid'=>$uid,
                    'time'=>date("Y-m-d",time()),
                );

                $res = $recordModel->add($insert_data);
                if(!$res){
                    throw new \Exception();
                }

                $competitorModel->commit();
                echo getjsondata(1,'success');
            }catch (\Exception $e){
                $competitorModel->rollback();
                echo getjsondata(0,$e->getMessage());
            }

        }else{
            echo getjsondata(0,"非法参数");
        }
    }

    /**
     * 礼物支持(涉及微信支付)
     */
    public function present(){

    }

    /**
     * 选手支持统计
     */
    public function count(){
        $cid = I("post.cid");
        if($cid){
            $countModel = D("count");
            $where = array(
                'competitor'=>array('eq',$cid),
            );
            $data = $countModel->where($where)->select();
            $res = array();
            foreach($data as $k=>$v){
                if($v['present'] == 1){
                    $res['vote'] = $v['count'];
                }

                if($v['present'] == 2){
                    $res['share'] = $v['count'];
                }

                if($v['present'] == 3){
                    $res['crown'] = $v['count'];
                }

                if($v['present'] == 4){
                    $res['kiss'] = $v['count'];
                }

                if($v['present'] == 5){
                    $res['flower'] = $v['count'];
                }
            }
            echo getjsondata(1,$res);
        }else{
            echo getjsondata(0,"请传递要查询的选手的id");
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

    /**
     * 获得支持记录
     */
    public function record(){
        $cid = I('post.cid');
        if($cid){
            $competitorModel = D("competitor");
            $data = $competitorModel->record($cid);
            echo getjsondata(1,$data);
        }else{
            echo getjsonadta(0,'请传递选手的id');
        }
    }

    /**
     * 选手排行榜
     */
    public function ranking_list(){
        $competitorModel = D("competitor");
        $data = $competitorModel->ranking_list();
        echo getjsondata(1,$data);
    }

   /**
     * 获得首张图片
     */
    public function getimage(){
        $cid = I("post.cid");
        if($cid){
            $competitorModel = D("competitor");
            $data = $competitorModel->getimage($cid);
            echo getjsondata(1,$data);
        }else{
            echo getjsondata(0,"请传递要查询的选手的id");
        }
    }

    /**
     * 分享时的数据
     */
    public function share(){
        $cid = I("post.cid");
        if($cid){
            $uid = session("uid");
            if(!$uid){
                echo getjsondata(0,"请先登录");
                exit();
            }
            $countModel = M("count");
            $countModel->startTrans();
            $recordModel = M("record");

            $where = array(
                'uid'=>array('eq',$uid),
                'cid'=>array('eq',$cid),
                'pid'=>array('eq',2),
                'time'=>array('eq',date("Y-m-d")),
            );
            $count = $recordModel->where($where)->count();
            if($count > 0){
                echo getjsondata(0,"每天的第一次分享才有票数添加哦");
                exit();
            }

            try{
                $where = array(
                    'competitor'=>array("eq",$cid),
                );
                $count = $countModel->field("count")->where($where)->select();
                $count = $count[0]["count"];
                if($count) {  //数据库有记录 修改数据库数据即可
                    $res = $countModel->where($where)->setField("count", intval($count) + 3);
                    if (!$res) {
                        throw new \Exception();
                    }
                }else{  //数据库没有数据 插入数据
                    $data = array(
                        "competitor"=>$cid,
                        'present'=>1,
                        'count'=>3
                    );
                    $res = $countModel->add($data);
                    if(!$res){
                        throw new \Exception();
                    }
                }
                $data = array(
                    'cid'=>$cid,
                    'pid'=>2,
                    'uid'=>$uid,
                    'time'=>date("Y-m-d",time())
                );
                $res = $recordModel->add($data);
                if(!$res) {
                    throw new \Exception();
                }
                $countModel->commit();
                echo getjsondata(1,"success");
            }catch(\Exception $e){
                $countModel->rollback();
                echo getjsondata(0,"系统异常,请稍后重试");
            }
        }else{
            echo getjsondata(0,"系统异常,请稍后重试");
        }
    }
}