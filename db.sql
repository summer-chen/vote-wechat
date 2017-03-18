CREATE DATABASE vote;

USE vote;

DROP TABLE IF EXISTS v_carousel;
CREATE TABLE v_carousel(
  cid tinyint unsigned not null auto_increment comment '轮播图id',
  picurl varchar(50) not null comment '图片路径',
  content text not null default '' comment '轮播图跳转的内容',
  primary key(cid)
)ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT '轮播图';

drop table if exists v_info;
create table v_info(
  iid tinyint unsigned not null auto_increment comment 'id',
  title varchar(20) not null comment '信息标题',
  content text not null default '' comment '信息内容',
  primary key(iid)
)engine=InnoDB default charset=utf8 comment '大赛信息';
insert into v_info values (1,'大赛简介','');
insert into v_info values (2,'大赛奖励','');
insert into v_info values (3,'报名细则','');

drop table if exists v_location;
create table v_location(
  lid tinyint unsigned not null auto_increment comment 'id',
  name varchar(10) not null comment '区域名称',
  primary key(lid)
)engine=InnoDB default charset=utf8 comment '赛区表';

drop table if exists v_present;
create table v_present(
  pid tinyint unsigned not null auto_increment comment 'id',
  name varchar(10) not null comment '礼物名称',
  primary key(pid)
)engine=InnoDB default charset=utf8 comment '礼物表';
insert into v_present values (1,'投票支持');
insert into v_present values (2,'转发支持');
insert into v_present values (3,'皇冠礼物');
insert into v_present values (4,'香吻礼物');
insert into v_present values (5,'鲜花礼物');

drop table if exists v_user;
create table v_user(
  uid int unsigned not null auto_increment comment 'id',
  username varchar(20) not null comment '用户名',
  openid char(32) not null comment '微信openid',
  headimg varchar(200) not null comment '微信头像',
  primary key(uid)
)engine=InnoDB default charset=utf8 comment '用户表';

drop table if exists v_competitor;
create table v_competitor(
  cid mediumint unsigned not null auto_increment comment 'id',
  name varchar(20) not null comment '姓名',
  age mediumint unsigned not null comment '年龄',
  height mediumint unsigned not null comment '身高(单位是厘米)',
  weight mediumint unsigned not null comment '体重(单位是千克)',
  job varchar(20) not null comment '职业',
  dream varchar(200) not null comment '梦想',
  family varchar(200) not null comment '家庭简介',
  location tinyint unsigned not null comment '所处赛区',
  telphone char(11) not null comment '手机号码',
  email varchar(20) not null comment '电子邮箱',
  hobby varchar(100) not null comment '爱好',
  is_pass tinyint unsigned not null default 0 comment '是否审核通过(0表示未审核,1表示审核通过)',
  is_delete tinyint unsigned not null default 0 comment '是否删除(0表示不删除,1表示删除)',
  primary key(cid),
  key location(location)
)engine=InnoDB default charset=utf8 comment '选手表';

drop table if exists v_record;
create table v_record(
  rid int unsigned not null auto_increment comment 'id',
  cid mediumint unsigned not null comment '选手',
  pid tinyint unsigned not null comment '礼物',
  uid int unsigned not null comment '用户',
  time date not null comment '投票时间',
  primary key(rid),
  key cid(cid),
  key pid(pid),
  key uid(uid)
)engine=InnoDB default charset=utf8 comment '投票记录表';

drop table if exists v_count;
create table v_count(
  cid int unsigned not null auto_increment comment 'id',
  competitor mediumint unsigned not null comment '选手',
  present tinyint unsigned not null comment '礼物',
  count int not null default 0 comment '支持总数',
  primary key(cid),
  key competitor(competitor),
  key present(present)
)engine=InnoDB default charset=utf8 comment '投票总数表';

drop table if exists v_image;
create table v_image(
  iid int unsigned not null auto_increment comment 'id',
  imageurl varchar(100) not null comment '图片路径',
  primary key(iid)
)engine=InnoDB default charset=utf8 comment '选手图片表';

drop table if exists v_competitor_image;
create table v_competitor_image(
  ciid int unsigned not null auto_increment comment 'id',
  imageid int unsigned not null comment '图片id',
  competitorid mediumint unsigned not null comment '选手id',
  primary key(ciid)
)engine=InnoDB default charset=utf8 comment '选手图片中间表';

drop table if exists v_admin;
create table v_admin(
  aid tinyint unsigned not null auto_increment comment 'id',
  adminname varchar(20) not null unique comment '管理员登录账号',
  adminpass char(32) not null comment '管理员登录密码',
  primary key(aid)
)engine=InnoDB default charset=utf8 comment '管理员表';

insert into v_admin values (1,'root','123');
/***
后台欠缺的功能:
    1.审核选手
    2.投票记录
***/