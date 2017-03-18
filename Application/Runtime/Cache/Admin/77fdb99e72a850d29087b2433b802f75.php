<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html lang="en">
<head>
    <title>后台管理界面</title>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" href="/vote/Public/Admin/css/bootstrap.min.css" />
    <link rel="stylesheet" href="/vote/Public/Admin/css/bootstrap-responsive.min.css" />
    <link rel="stylesheet" href="/vote/Public/Admin/css/fullcalendar.css" />
    <link rel="stylesheet" href="/vote/Public/Admin/css/matrix-style.css" />
    <link rel="stylesheet" href="/vote/Public/Admin/css/matrix-media.css" />
    <link rel="stylesheet" href="/vote/Public/Admin/css/jquery.gritter.css" />
    <link rel="stylesheet" href="/vote/Public/Admin/css/cypager.min.css"/>
    <link rel="stylesheet" href="/vote/Public/Admin/css/uploadPic.css"/>
    <script src="/vote/Public/Admin/js/jquery.min.js"></script>
    <script src="/vote/Public/Admin/layer/layer/layer.js"></script>

    <script type="text/javascript">
        var baseUrl = "/vote/";
    </script>
</head>
<body>

<!--Header-part-->
<div id="header">
    <h1><a href="dashboard.html">Matrix Admin</a></h1>
</div>
<!--close-Header-part-->


<!--top-Header-menu-->
<div id="user-nav" class="navbar navbar-inverse">
    <ul class="nav">
        <li class=""><a title="退出登录" href="<?php echo U('Login/logout'); ?>"><i class="icon icon-share-alt"></i> <span class="text">退出</span></a></li>
    </ul>
</div>
<!--close-top-Header-menu-->

<!--<div class="copyrights">Collect from <a href="http://www.cssmoban.com/" >免费模板</a></div>-->
<!--sidebar-menu-->
<div id="sidebar"><a href="#" class="visible-phone"><i class="icon icon-home"></i> Dashboard</a>
    <ul>
        <li><a href="<?php echo U('Carousel/add'); ?>"><i class="icon icon-signal"></i> <span>添加轮播图</span></a> </li>
        <li><a href="<?php echo U('Carousel/lst'); ?>"><i class="icon icon-signal"></i> <span>轮播图列表</span></a> </li>
        <li><a href="<?php echo U('Info/info'); ?>"><i class="icon icon-signal"></i> <span>大赛信息</span></a> </li>
        <li><a href="<?php echo U('Location/lst'); ?>"><i class="icon icon-inbox"></i> <span>赛区管理</span></a> </li>
        <li><a href="<?php echo U('Competitor/lst'); ?>"><i class="icon icon-th"></i> <span>选手审核</span></a></li>
        <li><a href="<?php echo U('Competitor/pass'); ?>"><i class="icon icon-th"></i> <span>支持记录</span></a></li>
    </ul>
</div>
<!--sidebar-menu-->



<!--main-container-part-->
<div id="content">
    <!--breadcrumbs-->
    <div id="content-header">
        <div id="breadcrumb"> <a href="#" class="tip-bottom"><i class="icon-home"></i> 大赛信息</a></div>
    </div>
    <!--End-breadcrumbs-->

    <div class="container-fluid">
        <div class="row-fluid">
            <div class="span12">
                <div class="widget-box">
                    <div class="widget-content nopadding">
                        <div class="widget-box">
                            <div class="widget-title">
                                <ul class="nav nav-tabs">
                                    <li class="active"><a data-toggle="tab" href="#tab1">大赛简介</a></li>
                                    <li><a data-toggle="tab" href="#tab2">大赛奖励</a></li>
                                    <li><a data-toggle="tab" href="#tab3">报名细则</a></li>
                                </ul>
                            </div>
                            <div class="widget-content tab-content">
                                <div id="tab1" class="tab-pane active">
                                    <div class="widget-content nopadding">
                                        <form class="form-horizontal" method="post" action="#" name="number_validate" novalidate="novalidate">
                                            <script id="info_desc" name="content" type="text/plain"></script>
                                            <div class="form-actions">
                                                <input type="button" onclick="desc()" value="大赛简介提交" class="btn btn-success">
                                            </div>
                                        </form>
                                    </div>
                                </div>
                                <div id="tab2" class="tab-pane">
                                    <div class="widget-content nopadding">
                                        <form class="form-horizontal" method="post" action="#" name="number_validate" novalidate="novalidate">
                                            <script id="info_award" name="content" type="text/plain"></script>
                                            <div class="form-actions">
                                                <input type="button" onclick="award()" value="大赛奖励提交" class="btn btn-success">
                                            </div>
                                        </form>
                                    </div>
                                </div>
                                <div id="tab3" class="tab-pane">
                                    <div class="widget-content nopadding">
                                        <form class="form-horizontal" method="post" action="#" name="number_validate" novalidate="novalidate">
                                            <script id="info_rule" name="content" type="text/plain"></script>
                                            <div class="form-actions">
                                                <input type="button" onclick="rule()" value="报名细则提交" class="btn btn-success">
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!--end-main-container-part-->
<!-- 富文本框  -->
<script type="text/javascript" charset="utf-8" src="/vote/Public/ueditor/ueditor.config.js"></script>
<script type="text/javascript" charset="utf-8" src="/vote/Public/ueditor/ueditor.all.min.js"> </script>
<script type="text/javascript" charset="utf-8" src="/vote/Public/ueditor/lang/zh-cn/zh-cn.js"></script>
<script type="text/javascript" src="/vote/Public/Admin/script/info.js"></script>

<!--end-main-container-part-->

<!--Footer-part-->

<div class="row-fluid">
    <div id="footer" class="span12"> 2013 &copy; Matrix Admin. More Templates <a href="http://www.cssmoban.com/" target="_blank" title="模板之家">模板之家</a> - Collect from <a href="http://www.cssmoban.com/" title="网页模板" target="_blank">网页模板</a> </div>
</div>

<!--end-Footer-part-->

<script src="/vote/Public/Admin/js/excanvas.min.js"></script>
<script src="/vote/Public/Admin/js/jquery.ui.custom.js"></script>
<script src="/vote/Public/Admin/js/bootstrap.min.js"></script>
<script src="/vote/Public/Admin/js/jquery.flot.min.js"></script>
<script src="/vote/Public/Admin/js/jquery.flot.resize.min.js"></script>
<script src="/vote/Public/Admin/js/jquery.peity.min.js"></script>
<script src="/vote/Public/Admin/js/fullcalendar.min.js"></script>
<script src="/vote/Public/Admin/js/matrix.js"></script>
<script src="/vote/Public/Admin/js/matrix.dashboard.js"></script>
<script src="/vote/Public/Admin/js/jquery.gritter.min.js"></script>
<script src="/vote/Public/Admin/js/matrix.interface.js"></script>
<script src="/vote/Public/Admin/js/matrix.chat.js"></script>
<script src="/vote/Public/Admin/js/jquery.validate.js"></script>
<script src="/vote/Public/Admin/js/matrix.form_validation.js"></script>
<script src="/vote/Public/Admin/js/jquery.wizard.js"></script>
<script src="/vote/Public/Admin/js/jquery.uniform.js"></script>
<script src="/vote/Public/Admin/js/select2.min.js"></script>
<script src="/vote/Public/Admin/js/matrix.popover.js"></script>
<script src="/vote/Public/Admin/js/jquery.dataTables.min.js"></script>
<script src="/vote/Public/Admin/js/matrix.tables.js"></script>
</body>
</html>