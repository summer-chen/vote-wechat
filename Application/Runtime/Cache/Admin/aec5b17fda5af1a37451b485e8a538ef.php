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
    <script src="/vote/Public/Admin/js/jquery.min.js"></script>
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
        <li  class="dropdown" id="profile-messages" ><a title="" href="#" data-toggle="dropdown" data-target="#profile-messages" class="dropdown-toggle"><i class="icon icon-user"></i>  <span class="text">Welcome User</span><b class="caret"></b></a>
            <ul class="dropdown-menu">
                <li><a href="#"><i class="icon-user"></i> My Profile</a></li>
                <li class="divider"></li>
                <li><a href="#"><i class="icon-check"></i> My Tasks</a></li>
                <li class="divider"></li>
                <li><a href="login.html"><i class="icon-key"></i> Log Out</a></li>
            </ul>
        </li>
        <li class="dropdown" id="menu-messages"><a href="#" data-toggle="dropdown" data-target="#menu-messages" class="dropdown-toggle"><i class="icon icon-envelope"></i> <span class="text">Messages</span> <span class="label label-important">5</span> <b class="caret"></b></a>
            <ul class="dropdown-menu">
                <li><a class="sAdd" title="" href="#"><i class="icon-plus"></i> new message</a></li>
                <li class="divider"></li>
                <li><a class="sInbox" title="" href="#"><i class="icon-envelope"></i> inbox</a></li>
                <li class="divider"></li>
                <li><a class="sOutbox" title="" href="#"><i class="icon-arrow-up"></i> outbox</a></li>
                <li class="divider"></li>
                <li><a class="sTrash" title="" href="#"><i class="icon-trash"></i> trash</a></li>
            </ul>
        </li>
        <li class=""><a title="" href="#"><i class="icon icon-cog"></i> <span class="text">Settings</span></a></li>
        <li class=""><a title="" href="login.html"><i class="icon icon-share-alt"></i> <span class="text">Logout</span></a></li>
    </ul>
</div>
<!--close-top-Header-menu-->

<div class="copyrights">Collect from <a href="http://www.cssmoban.com/" >免费模板</a></div>
<!--sidebar-menu-->
<div id="sidebar"><a href="#" class="visible-phone"><i class="icon icon-home"></i> Dashboard</a>
    <ul>
        <li class="submenu"><a href="#"><i class="icon icon-th-list"></i> <span>轮播图管理</span></a>
            <ul>
                <li><a href="<?php echo U('Carousel/add'); ?>">添加轮播图</a></li>
                <li><a href="<?php echo U('Carousel/lst'); ?>">轮播图列表</a></li>
            </ul>
        </li>
        <li><a href="<?php echo U('Info/info'); ?>"><i class="icon icon-signal"></i> <span>大赛信息</span></a> </li>
        <li><a href="<?php echo U('Location/lst'); ?>"><i class="icon icon-inbox"></i> <span>赛区管理</span></a> </li>
        <li><a href="<?php echo U('Competitor/lst'); ?>"><i class="icon icon-th"></i> <span>选手管理</span></a></li>
        <li><a href="grid.html"><i class="icon icon-fullscreen"></i> <span>Full width</span></a></li>
        <li class="submenu"> <a href="#"><i class="icon icon-th-list"></i> <span>Forms</span> <span class="label label-important">3</span></a>
            <ul>
                <li><a href="form-common.html">Basic Form</a></li>
                <li><a href="form-validation.html">Form with Validation</a></li>
                <li><a href="form-wizard.html">Form with Wizard</a></li>
            </ul>
        </li>
        <li><a href="buttons.html"><i class="icon icon-tint"></i> <span>Buttons &amp; icons</span></a></li>
        <li><a href="interface.html"><i class="icon icon-pencil"></i> <span>Eelements</span></a></li>
        <li class="submenu"> <a href="#"><i class="icon icon-file"></i> <span>Addons</span> <span class="label label-important">5</span></a>
            <ul>
                <li><a href="index2.html">Dashboard2</a></li>
                <li><a href="gallery.html">Gallery</a></li>
                <li><a href="calendar.html">Calendar</a></li>
                <li><a href="invoice.html">Invoice</a></li>
                <li><a href="chat.html">Chat option</a></li>
            </ul>
        </li>
        <li class="submenu"> <a href="#"><i class="icon icon-info-sign"></i> <span>Error</span> <span class="label label-important">4</span></a>
            <ul>
                <li><a href="error403.html">Error 403</a></li>
                <li><a href="error404.html">Error 404</a></li>
                <li><a href="error405.html">Error 405</a></li>
                <li><a href="error500.html">Error 500</a></li>
            </ul>
        </li>
    </ul>
</div>
<!--sidebar-menu-->



<!--main-container-part-->
<div id="content">
    <!--breadcrumbs-->
    <div id="content-header">
        <div id="breadcrumb"> <a href="#" class="tip-bottom"><i class="icon-home"></i> 添加轮播图</a></div>
    </div>
    <!--End-breadcrumbs-->

    <div class="container-fluid">
        <div class="dataTables_paginate fg-buttonset ui-buttonset fg-buttonset-multi ui-buttonset-multi paging_full_numbers" id="DataTables_Table_0_paginate">
            <a tabindex="0" class="first ui-corner-tl ui-corner-bl fg-button ui-button ui-state-default" id="DataTables_Table_0_first">First</a>
            <a tabindex="0" class="previous fg-button ui-button ui-state-default" id="DataTables_Table_0_previous">Previous</a>
            <span>
                <a tabindex="0" class="fg-button ui-button ui-state-default ui-state-disabled">1</a>
                <a tabindex="0" class="fg-button ui-button ui-state-default">2</a>
                <a tabindex="0" class="fg-button ui-button ui-state-default">3</a>
                <a tabindex="0" class="fg-button ui-button ui-state-default">4</a>
                <a tabindex="0" class="fg-button ui-button ui-state-default">5</a>
            </span>
            <a tabindex="0" class="next fg-button ui-button ui-state-default ui-state-disabled" id="DataTables_Table_0_next">Next</a>
            <a tabindex="0" class="last ui-corner-tr ui-corner-br fg-button ui-button ui-state-default ui-state-disabled" id="DataTables_Table_0_last">Last</a>
        </div>
    </div>
</div>

<!--end-main-container-part-->
<script type="text/javascript" src="/vote/Public/Admin/script/competitor.js"></script>

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