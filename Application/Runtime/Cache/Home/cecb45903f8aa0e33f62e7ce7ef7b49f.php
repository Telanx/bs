<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html lang="zh-cn">
  <head>
    <title>毕业设计(论文管理系统)</title>
    <meta name="keywords" content="毕业设计" />
    <meta name="description" content="论文管理系统" />
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="viewport" content="width=device-width,initial-scale=1.0, maximum-scale=1.0,user-scalable=no">
    <link rel="stylesheet" href="/bs/Public/lib/pintuer/pintuer.css">
	<link rel="stylesheet" href="/bs/Public/css/index.css">
	<style type='text/css'>
		#nav-menu li{
			padding-top:12px;
			padding-left:10px;
			font-size:1.2em;
			height:50px;
			
		}
		#nav-menu .active{
			border-left:3px solid rgb(0,170,136);
		}
		
		.news-head-title{
			background:#eee;
		}
		.news-head-time{
			background:#aaa;
		}
		
		.news-table-content .line{
			font-size:15px;
			border-bottom:solid 1px #aaa;
			line-height:40px;
		}
		.news-table-content .x2{
			text-align:center;
		}
		.pagebar{
			margin-top:20px;
		}
	</style>
    <script src="/bs/Public/lib/pintuer/jquery.js"></script>
    <script src="/bs/Public/lib/pintuer/pintuer.js"></script>
    <!--[if lt IE 9]>
	<script src="/bs/Public/lib/pintuer/respond.js"></script>
	<![endif]-->
	
    <script type='text/javascript'>
	$(function(){
		var current = <?php echo ($page["current"]); ?>;
		var total = <?php echo ($page["total"]); ?>;
		if(current==total){
			$('.pageNext').hide();
		}else $('.pageNext').show();
		if(current==1){
			$('.pagePrev').hide();
		}else $('.pagePrev').show();
		$('.go').click(function(e){
			var goPage = $(e.target).prev().val();
			if(goPage<=total&&goPage>=1)location.href="<?php echo U('Home/Index/news');?>?p="+goPage;
		});
	})
	</script>
  </head>
  <body>
  <!---导航栏-->
  <div id='nav-top'>
	<div class='nav-center'>
		<div class='nav-logo'><img src='/bs/Public/img/logo.jpg' width=100px height=70px /></div>
		<div class='nav-title'>毕业设计(论文)管理系统</div>
		<div class='nav-user'>
			<div class="user-info" <?php echo ($user['login']?'':'hidden'); ?>>
                    <a class="user-home" href="<?php echo ($user["home"]); ?>">
                        <img width='40' height='40' class="img-border" src="<?php echo ($user["pic"]); ?>" alt="您的头像">
                        <span class="user-name textoverflow"><?php echo ($user["name"]); ?></span>
                    </a>
					<a  href="<?php echo U('Home/Login/logout');?>" title="退出" class='icon-logout'><span class="icon-power-off text-large"></span></a>                    
         
              
			</div>
			<!----没登录--->
			<div class="button border-main login-btn <?php echo ($user[login]?'hidden':''); ?>">
				<a href=<?php echo U('Home/Login/index');?>><span class='icon-user text-big'></span>登录</a> 
			</div>
		</div>
	</div>
  </div>
  <!---中部内容区--->
  <div id='content'>
	<div class='content-center'>
		<!--图片轮播+右侧新闻-->
		<div class='layout'>
			<!----面包屑导航测试-->
			<div class='line'>
				<ul class="bread bg-main bg-inverse">
				<li><a href="<?php echo U('Home/Index/index');?>" class="icon-home"> 首页</a></li>
				<li class='active'>最新动态</li>
				</ul>
			</div>
			
			<div class='line'>
			<!---左边导航栏手机上则隐藏掉hidden-l--->
				<div class='xm2 xs2 hidden-l'>
					<button class="button icon-navicon" data-target="#nav-link1"></button>
						<ul class="nav nav-navicon" id="nav-menu">
						<li class="nav-head">首页</li>
						<li class='active'>最新动态</a></li>
						<li><a href="<?php echo U('Home/Index/file');?>">资料下载</a></li>
						<li><a href="<?php echo U('Home/Index/link');?>">相关链接</a></li>
						
						</ul>
				</div>
				<div class='xm9 xs9 xl12'>
				<!---右边正文-->
					
					<div class='news-list' style='padding-top:12px;'>
						<div class='news-table-head'>
							<div class='x9 news-head-title text-center'>标题</div>
							<div class='x3 news-head-time text-center'>发布日期</div>
						</div>
						<div class='news-table-content'>
						<?php echo ($news?'':'无更多数据'); ?>
						<!---动态新闻模板-->
						<?php if(is_array($news)): $i = 0; $__LIST__ = $news;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$news): $mod = ($i % 2 );++$i;?><div class='line'><div class='x9'><a href="<?php echo U('Home/Index/newsdetail');?>?id=<?php echo ($news["id"]); ?>"><?php echo ($news["title"]); ?></a></div><div class='x3 text-center'><?php echo (substr($news["publishtime"],0,10)); ?></div></div><?php endforeach; endif; else: echo "" ;endif; ?>
						<!---模板结束-->
						</div>
							
					</div>
					<!---翻页工具-->
					<div class='pagebar'>
						<p class='text-right'>
							<a href="<?php echo U('Home/Index/news');?>">首页</a> <a href="<?php echo U('Home/Index/news');?>?p=<?php echo ($page['current']-1); ?>" class='pagePrev'>上一页</a>  <a href="<?php echo U('Home/Index/news');?>?p=<?php echo ($page['current']+1); ?>" class='pageNext'>下一页</a>  <a href="<?php echo U('Home/Index/news');?>?p=<?php echo ($page["total"]); ?>">末页</a> <input type='text' style='width:30px' value=<?php echo ($page["current"]); ?>>/<?php echo ($page["total"]); ?><a href=# class='go'>跳转</a>
						</p>
					</div>
					
				</div>
			</div>
		</div>
		<!--新闻、下载、链接-->
		
	</div>
  </div>
  <!---footer--->
  <div id='footer'>
	<p class='text-center'>CopyRight2015毕业设计(论文)管理系统</p>
  </div>
  </body>
</html>