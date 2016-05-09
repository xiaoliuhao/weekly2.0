<?php
/**
 * Create by PhpStorm
 * Author: Liu  <470401911@qq.com>
 * Date: 2016/5/9
 * Time: 19:10
 * Version: weekly
 */
?>
<!DOCTYPE html>
<html>

<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">


    <title>Weekly后台管理系统 - 登录</title>
    <meta name="keywords" content="H+后台主题,后台bootstrap框架,会员中心主题,后台HTML,响应式后台">
    <meta name="description" content="H+是一个完全响应式，基于Bootstrap3最新版本开发的扁平化主题，她采用了主流的左右两栏式布局，使用了Html5+CSS3等现代技术">

    <link rel="shortcut icon" href="favicon.ico"> <link href="<?=base_url();?>css/bootstrap.min.css?v=3.3.5" rel="stylesheet">
    <link href="<?=base_url();?>css/font-awesome.min.css?v=4.4.0" rel="stylesheet">

    <link href="<?=base_url();?>css/animate.min.css" rel="stylesheet">
    <link href="<?=base_url();?>css/style.min.css?v=4.0.0" rel="stylesheet"><base target="_blank">
    <!--[if lt IE 8]>
    <meta http-equiv="refresh" content="0;ie.html" />
    <![endif]-->
    <script>if(window.top !== window.self){ window.top.location = window.location;}</script>
</head>

<body class="gray-bg">

<div class="middle-box text-center loginscreen  animated fadeInDown">
    <div>
        <div>

            <h1 class="logo-name">Weekly</h1>

        </div>
        <h3>Weekly后台管理系统</h3>

        <form class="m-t" role="form" method="post" action="<?=site_url('login/check_login');?>">
            <div class="form-group">
                <input type="text" name="name" class="form-control" placeholder="用户名" >
            </div>
            <div class="form-group">
                <input type="password" name="password" class="form-control" placeholder="密码" >
            </div>
            <button type="submit" class="btn btn-primary block full-width m-b">登 录</button>


            <p class="text-muted text-center"> <a href="login.html#"><small>忘记密码了？</small>
            </p>

        </form>
    </div>
</div>
<script src="<?=base_url();?>js/jquery.min.js?v=2.1.4"></script>
<script src="<?=base_url();?>js/bootstrap.min.js?v=3.3.5"></script>
<script type="text/javascript" charset="UTF-8"></script>
</body>

</html>
