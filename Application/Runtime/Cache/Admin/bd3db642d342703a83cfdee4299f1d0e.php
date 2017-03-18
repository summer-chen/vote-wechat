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
        <div id="breadcrumb"> <a href="#" class="tip-bottom"><i class="icon-home"></i> 添加轮播图</a></div>
    </div>
    <!--End-breadcrumbs-->

    <div class="container-fluid">
        <div class="row-fluid">
            <div class="span12">
                <div class="widget-box">
                    <div class="widget-content nopadding">
                        <table class="table table-bordered data-table">
                            <thead>
                            <tr>
                                <th width="15%">编号</th>
                                <th>图片</th>
                                <th width="20%">操作</th>
                            </tr>
                            </thead>
                            <tbody id="cour_content">
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal -->
    <div class="modal hide fade" id="myModal" tabindex="-1" role="dialog" style="width: 1000px; margin-left:-500px">
        <div class="modal-header"><button class="close" type="button" data-dismiss="modal">×</button>
            <h3 id="myModalLabel">Modal header</h3>
        </div>
        <div class="modal-body" >
            <div class="container-fluid">
                <div class="row-fluid">
                    <div class="span12">
                        <div class="widget-box">
                            <div class="widget-content nopadding">
                                <form id="carousel">
                                    <input type="hidden" name="cid" id="cid"/>
                                    <table class="table table-bordered data-table">
                                        <tr>
                                            <td>轮播图图片:</td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <input type="file" id="upload" name="picurl"/>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>轮播图内容:</td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <textarea id="carousel_content" name="content" type="text/plain"></textarea>
                                            </td>
                                        </tr>
                                    </table>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal-footer">
            <a href="javascript:update();" class="btn btn-success">修改</a>
            <a href="#" class="btn" data-dismiss="modal">关闭</a>
        </div>
    </div>

</div>

<!--end-main-container-part-->
<script type="text/javascript" charset="utf-8" src="/vote/Public/ueditor/ueditor.config.js"></script>
<script type="text/javascript" charset="utf-8" src="/vote/Public/ueditor/ueditor.all.min.js"> </script>
<script type="text/javascript" charset="utf-8" src="/vote/Public/ueditor/lang/zh-cn/zh-cn.js"></script>
<script type="text/javascript" src="/vote/Public/Admin/script/carousel.js"></script>
<script type="text/javascript">
    lst();
</script>

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