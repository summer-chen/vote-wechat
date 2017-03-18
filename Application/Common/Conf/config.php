<?php
return array(
	//'配置项'=>'配置值'

    /**---------上传参数配置------**/
    'filemaxsize'             => 3145728,
    'fileext'                 =>array('jpg', 'gif', 'png', 'jpeg'),

    /**---------数据库配置--------**/
    'DB_TYPE'               =>  'mysqli',     // 数据库类型
    'DB_HOST'               =>  '127.0.0.1', // 服务器地址
    'DB_NAME'               =>  'vote',          // 数据库名
    'DB_USER'               =>  'root',      // 用户名
    'DB_PWD'                =>  '',          // 密码
    'DB_PORT'               =>  '3306',        // 端口
    'DB_PREFIX'             =>  'v_',    // 数据库表前缀
);