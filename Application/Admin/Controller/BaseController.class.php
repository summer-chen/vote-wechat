<?php
namespace Admin\Controller;
use Think\Controller;

class BaseController extends Controller{
	
	public function __construct(){
        parent::__construct();
        if(!session('adminid'))
          $this->error('请先登录!',U('Login/login'));
	}
}