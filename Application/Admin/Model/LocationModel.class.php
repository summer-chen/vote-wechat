<?php
/**
 * Created by PhpStorm.
 * User: john zhou
 * Date: 2017/2/22
 * Time: 19:44
 */
namespace Admin\Model;
use Think\Model;
class LocationModel extends Model{

    protected $insertFields = "lid,name";
    protected $updateFields = "name";

    protected $_validata = array(
        array('name','require','赛区名称不能为空',1),
    );
}