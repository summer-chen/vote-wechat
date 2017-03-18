<?php
/**
 * Created by PhpStorm.
 * User: john zhou
 * Date: 2017/2/22
 * Time: 15:59
 */
namespace Admin\Model;
use Think\Model;
class InfoModel extends Model{

    protected $updateFields = "content";

    protected $_validate = array(
        array('content','require', '内容不能为空',1),
    );
}
