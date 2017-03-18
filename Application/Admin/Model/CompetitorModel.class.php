<?php
/**
 * Created by PhpStorm.
 * User: Hokkaido
 * Date: 2017/2/24
 * Time: 16:29
 */
namespace Admin\Model;
use Think\Model;
class CompetitorModel extends Model{

    private $perpage = 10;
    /**
     * 获得未审核的选手
     */
    public function lst(){
        $where = array(
            'is_pass'=>array('eq',0),
            'is_delete'=>array('eq',0),
        );
        $count = $this->where($where)->count();
        $pageObj = page($count,$this->perpage);

        $page = $pageObj->show();
        $data = $this->where($where)
                     ->limit($pageObj->firstRow.','.$pageObj->listRows)
                     ->order("cid desc")
                     ->select();

        return array(
            'page'=>$page,
            'data'=>$data,
        );
    }

    /**
     * 获得通过审核的选手
     */
    public function pass(){

        $where = array(
            'is_pass'=>1,
            'is_delete'=>0,
        );

        $count = $this->where($where)->count();
        $pageObj = page($count,$this->perpage);

        $page = $pageObj->show();
        $data = $this->where($where)
                     ->limit($pageObj->firstRow.','.$pageObj->listRows)
                     ->order("cid desc")
                     ->select();

        return array(
            'page'=>$page,
            'data'=>$data,
        );
    }

    /**
     * 选手支持记录
     */
    public function record($cid){

        $where = array(
            'a.cid' => array("eq",$cid),
        );

        $recordModel = M("record");

        //取出总的记录数
        $count = $recordModel->alias("a")->where($where)->count();
        //计算总的页数
        $pagecount = ceil($count/$this->perpage);
        //获得当前页
        $currentpage = max(1,(int)I('post.p'),1);//  =>1的整数
        //计算limit上的第一个参数
        $offset = ($currentpage - 1)*$this->perpage;

        $data = $recordModel->alias("a")
                            ->field("a.time,b.username,b.headimg,c.name")
                            ->join("left join __USER__ b on a.uid=b.uid")
                            ->join("left join __PRESENT__ c on a.pid=c.pid")
                            ->where($where)
                            ->limit("$offset,$this->perpage")
                            ->order("a.rid desc")
                            ->select();

        return array(
            'count'=>$count,
            'pagecount'=>$pagecount,
            'currentpage'=>$currentpage,
            'perpage'=>$this->perpage,
            'data'=>$data,
        );

    }

    /**
     * 获得选手的图片
     */
    public function show($cid){
        $competitor_imgaeModel = M("competitor_image");
        $where = array(
            'a.competitorid'=>array("eq",$cid),
        );

        $data = $competitor_imgaeModel->alias("a")
                                      ->field("b.iid,b.imageurl")
                                      ->join("left join __IMAGE__ b on a.imageid=b.iid")
                                      ->where($where)
                                      ->select();



        foreach($data as $k=>$v){
            $data[$k]['alt'] = "";
            $data[$k]['pid'] = $v['iid'];
            $data[$k]['src'] = $v['imageurl'];
            $data[$k]['thumb'] = $v['imageurl'];
        }
        $res = array();
        $res['title'] = "选手图片";
        $res['id'] = uniqid();
        $res['start'] = 0;
        $res['data'] = $data;                              
        return $res;
    }

}