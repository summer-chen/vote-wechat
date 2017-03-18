<?php
/**
 * Created by PhpStorm.
 * User: john zhou
 * Date: 2017/2/22
 * Time: 9:04
 */
namespace Admin\Model;
use Think\Model;
class CarouselModel extends Model{

    //允许插入的字段
    protected $insertFields = "cid,picurl,content";
    //允许更新的字段
    protected $updateFields = "picurl,content";

    //自动校验
    protected $_validate = array(
        array('content','require','轮播图内容不能为空',1),
    );

    //插入数据前的钩子函数
    protected function _before_insert(&$data,$options){
        //上传图片
        $res = uploadimg($data['picurl'],"carousel/");
        if(!$res){
            return false;
        }

        //判断是否已经添加了5条数据 最多允许添加五条数据
        $count = $this->count();
        if($count >= 5){
            $this->error = "最多允许添加5条数据";
            return false;
        }

        $data['picurl'] = $res;
    }

    //修改数据前的钩子函数
    protected function _before_update(&$data,$options){
        //上传图片
        if($_FILES['picurl']){
            $res = upload("carousel/");
            if(!$res['success']){
                $this->error = $res['info'];
                return false;
            }

            $data['picurl'] = $res['info']['picurl']['savepath'].$res['info']['picurl']['savename'];
        }else{
            unset($data['picurl']);
        }
    }

    //删除数据前的钩子函数
    protected function _before_delete($options){
        $cid = $options['where']['cid'];
        $data  = $this->field("picurl")->find($cid);
        $path = $data['picurl'];
        unlink("./Public/Uploads/".$path);
    }
}