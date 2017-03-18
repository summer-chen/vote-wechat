<?php
/**
 * Created by PhpStorm.
 * User: Hokkaido
 * Date: 2017/2/23
 * Time: 15:07
 */
namespace Home\Model;
use Think\Model;
class CompetitorModel extends Model{

    private $perpage = 6;
    protected $insertFields = "cid,name,age,height,weight,job,dream,family,location,telphone,email,hobby";
    protected $updateFields = "name,age,height,weight,job,dream,family,location,telphone,email,hobby";

    protected $_validate = array(
        array('name','require','名字不能为空',1),
        array('name','1,20','名字不能找过20个字符',1,'length'),

        array('age','require','年龄不能为空',1),
        array('age','number','年龄必须是数字',1),
        array('age','1,150','年龄不能超过150',1,'length'),

        array('height','require','身高不能为空',1),
        array('height','number','身高必须是数字',1,),
        array('height','1,250','身高不能超过250cm',1,'length'),

        array('weight','require','体重不能为空',1),
        array('weight','number','体重必须是数字',1,),
        array('weight','1,150','体重不能超过150kg',1,'length'),

        array('job','require','职业不能为空',1),
        array('job','1,20','职业不能超过20个字符',1,'length'),

        array('dream','require','梦想不能为空',1),
        array('dream','1,200','梦想字数不能超过200个',1,'length'),

        array('family','require','家庭简介不能为空',1),
        array('family','1,200','家庭简介字数不能超过200个',1,'length'),

        array('location','require','赛区不能为空',1),
        array('location','number','赛区必须为数字',1),

        array('telphone','require','手机号码不能为空',1),
        array('telphone','/^1[34578]\d{9}$/','手机格式不正确',1,'regex'),

        array('email','require','邮箱不能为空',1),
        array('email','email','邮箱格式不正确',1),

        array('hobby','require','爱好不能为空',1),
        array('hobby','1,200','爱好字数不能超过200个',1,'length'),
    );

    //添加选手前的钩子函数
    protected function _before_insert(&$data,$options){
        //处理图片
    }

    /**
     * 选手风采页面
     */
    public function mien(){

        $where = array(
            'a.is_pass' => array('eq', 1),
            'a.is_delete' => array('eq', 0)
        );

        $lid = I('post.lid');
        if ($lid) {
            $where['a.location'] = array('eq', $lid);
        }
        $name = I('post.name');
        if ($name) {
            $where['a.name'] = array('like', "%$name%");
        }

        //取出总的记录数
        $count = $this->alias("a")
                      ->where($where)
                      ->count();
        //计算总的页数
        $pagecount = ceil($count / $this->perpage);
        //获得当前页
        $currentpage = max(1, (int)I('post.p'), 1);//  =>1的整数
        //计算limit上的第一个参数
        $offset = ($currentpage - 1) * $this->perpage;

        $data = $this->alias("a")
                     ->field("a.family,a.name,a.cid,b.count")
                     ->where($where)
                     ->join("left join __COUNT__ b on a.cid=b.competitor and b.present=1")
                     ->limit("$offset,$this->perpage")
                     ->order("cid desc")
                     ->select();

        foreach($data as $k=>$v){
            $cid = $v['cid'];
            $competitor_imageModel = M("competitor_image");
            $where  = array(
                "competitorid"=>array('eq',$cid),
            );
            $imagedata = $competitor_imageModel->field("imageid")->where($where)->limit(1)->select();
            $imageModel = M("image");
            $where = array(
                "iid"=>array('eq',$imagedata[0]['imageid']),
            );
            $imageurl = $imageModel->field("imageurl")->where($where)->select();
            $data[$k]['imageurl'] = $imageurl[0]['imageurl'];
        }

        $res = array(
            'count' => $count,
            'pagecount' => $pagecount,
            'currentpage' => $currentpage,
            'data' => $data,
        );

        return $res;
    }

    /**
     * 获得某个选手的支持记录
     */
    public function record($cid){

        $recordModel = M("record");

        $where = array(
            'a.cid'=>array('eq',$cid),
        );

        //取出总的记录数
        $count = $recordModel->alias('a')->where($where)->count();
        //计算总的页数
        $pagecount = ceil($count/$this->perpage);
        //获得当前页
        $currentpage = max(1,(int)I('post.p'),1);//  =>1的整数
        //计算limit上的第一个参数
        $offset = ($currentpage - 1)*$this->perpage;

        $data = $recordModel->alias('a')
                            ->field("b.headimg,b.username,c.name,a.time,a.pid,GROUP_CONCAT(a.pid) as count")
                            ->join("left join __USER__ b on a.uid=b.uid")
                            ->join("left join __PRESENT__ c on a.pid=c.pid")
                            ->where($where)
                            ->limit("$offset,$this->perpage")
                            ->group("b.uid,a.pid,a.time")
                            ->order("rid desc")
                            ->select();

        foreach($data as $k=>$v){
            $str = $v['count'];
            $arr = explode(",",$str);
            $count = count($arr);
            $data[$k]['count'] = $count;
        }

        return array(
            'count'=>$count,
            'pagecount'=>$pagecount,
            'currentpage'=>$currentpage,
            'data'=>$data,
        );
    }

    /**
     * 选手排行榜
     */
    public function ranking_list(){

        $where = array(
            'a.is_pass'=>array('eq',1),
            'a.is_delete'=>array('eq',0),
        );

        $lid = I('post.lid');
        if($lid){
            $where['a.location'] = array('eq',$lid);
        }

        //取出总的记录数
        $count = $this->alias('a')->where($where)->count();
        //计算总的页数
        $pagecount = ceil($count/$this->perpage);
        //获得当前页
        $currentpage = max(1,(int)I('post.p'),1);//  =>1的整数
        //计算limit上的第一个参数
        $offset = ($currentpage - 1)*$this->perpage;

        $data = $this->alias("a")
                     ->field("a.family,a.cid,a.name,GROUP_CONCAT(b.present) as present,GROUP_CONCAT(b.count) as count")
                     ->join("left join __COUNT__ b on a.cid=b.competitor")
                     ->where($where)
                     ->limit("$offset,$this->perpage")
                     ->group("a.cid")
                     ->order("(select count from v_count where present=1 and competitor=a.cid) desc")
                     ->select();
        //处理礼物
        foreach($data as $k=>$v){
            $presents = $v['present'];
            $counts = $v['count'];
            $presents = explode(",",$presents);
            $counts = explode(",",$counts);
            $temp = array_flip($presents);

            if(in_array(1,$presents)){
                $index = $temp[1];
                $count = $counts[$index];
                $data[$k]['vote'] = $count;
            }else{
                $data[$k]['vote'] = 0;
            }

            if(in_array(2,$presents)){
                $index = $temp[2];
                $count = $counts[$index];
                $data[$k]['share'] = $count;
            }else{
                $data[$k]['share'] = 0;
            }

            if(in_array(3,$presents)){
                $index = $temp[3];
                $count = $counts[$index];
                $data[$k]['crown'] = $count;
            }else{
                $data[$k]['crown'] = 0;
            }

            if(in_array(4,$presents)){
                $index = $temp[4];
                $count = $counts[$index];
                $data[$k]['kiss'] = $count;
            }else{
                $data[$k]['kiss'] = 0;
            }

            if(in_array(5,$presents)){
                $index = $temp[5];
                $count = $counts[$index];
                $data[$k]['flower'] = $count;
            }else{
                $data[$k]['flower'] = 0;
            }

        }

        //获得图片
        foreach($data as $k=>$v){
            $cid = $v['cid'];
            $competitor_imageModel = M("competitor_image");
            $where  = array(
                "competitorid"=>array('eq',$cid),
            );
            $imagedata = $competitor_imageModel->field("imageid")->where($where)->limit(1)->select();
            $imageModel = M("image");
            $where = array(
                "iid"=>array('eq',$imagedata[0]['imageid']),
            );
            $imageurl = $imageModel->field("imageurl")->where($where)->select();
            $data[$k]['imageurl'] = $imageurl[0]['imageurl'];
        }

        return array(
            'count'=>$count,
            'pagecount'=>$pagecount,
            'currentpage'=>$currentpage,
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
                                      ->field("b.imageurl")
                                      ->join("left join __IMAGE__ b on a.imageid=b.iid")
                                      ->where($where)
                                      ->select();

        return $data;
    }

    /**
     * 获得选手的首张图片
     */
    public function getimage($cid){
        $competitor_imageModel = M("competitor_image");
        $where = array(
            "competitorid"=>array('eq',$cid),
        );

        $images = $competitor_imageModel->field("imageid")->where($where)->limit(1)->select();
        $imageid = $images[0]['imageid'];

        $imageModel = M("image");
        $data = $imageModel->field("imageurl")->find($imageid);

        return $data;
    }
}