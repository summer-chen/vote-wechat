<?php
/**
 * Created by PhpStorm.
 * User: Hokkaido
 * Date: 2017/2/20
 * Time: 19:46
 */

/**
 * 上传图片
 * @param $file
 * @param $picdir   图片的文件夹  "dirname/"
 * @return bool|string
 */
function uploadimg($file,$picdir){
	$head_path = "Public/Uploads/";
	$content = base64_decode($file);
	$firname = date('Y-m-d',time());
	if(!file_exists($head_path.$picdir.$firname)){
		mkdir($head_path.$picdir.$firname);
	}
	$path = $firname.'/'.uniqid().'.jpg';
	$result = file_put_contents($head_path.$picdir.$path,$content);
	if($result>0){
		return $picdir.$path;
	}else{
		$this->error = "上传失败,请重试";
		return false;
	}
}

/**
 * 根据结果生成交互数据
 *
 * @param boolean $userToken 用户是否登录
 * @param int $serviceResult 有无出错 1正常 0错误
 * @param array $resultinfo 返回结果
 **/

function getjsondata($serviceResult,$resultinfo){
    $res = array(
        'serviceResult'=>$serviceResult,
        'resultinfo'=>$resultinfo,
    );

    return json_encode($res);
}

/**
 * 文件上传
 *
 * @param string $filepath 上传图片的路径 格式:'test/' 如何这样写,则文件将保存在./Public/Uploads/test/路径下
 * @return 一维数组 array('success'=>成功或失败,'info'=>'成功或失败之后对应的信息')
 */
function upload($filepath){

    $upload = new \Think\Upload();// 实例化上传类
    $upload->maxSize   =     C('filemaxsize') ;// 设置附件上传大小
    $upload->exts      =     C('fileext');// 设置附件上传类型
    $upload->rootPath  =      './Public/Uploads/'; // 设置附件上传根目录
    $upload->savePath  =      $filepath; // 设置附件上传（子）目录
    // 上传文件
    $info   =   $upload->upload();
    if(!$info) {// 上传错误提示错误信息
        return array(
            'success'=>false,
            'info'=>$upload->getError(),
        );
    }else{// 上传成功 获取上传文件信息
        return array(
            'success'=>true,
            'info'=>$info,
        );
    }
}

/**
 * 分页 主要处理上一页和下一页的配置
 *
 * @param int $count  总记录数
 * @param int $perpage 每页显示的记录数
 * @return $pageObj  分页类对象 以便下面继续操作
 */
function page($count,$perpage){
    $pageObj = new \Think\Page($count,$perpage);
    $pageObj->setConfig('prev','上一页');
    $pageObj->setConfig('next','下一页');
    return $pageObj;
}