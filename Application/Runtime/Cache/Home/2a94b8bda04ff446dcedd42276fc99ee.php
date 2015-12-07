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
	body{
		overflow-x:hidden;
	}
	.news>.p{
		white-space: nowrap;
		text-overflow: ellipsis;
		overflow: hidden;
	}
	</style>
    <script src="/bs/Public/lib/pintuer/jquery.js"></script>
    <script src="/bs/Public/lib/pintuer/pintuer.js"></script>
    <!--[if lt IE 9]>
	<script src="/bs/Public/lib/pintuer/respond.js"></script>
	<![endif]-->
	
    <script type='text/javascript'>
	</script>
</head>

<body>
  <!---导航栏-->
  <div id='nav-top'>
	<div class='nav-center'>
		<div class='hidden-l nav-logo'><img src='/bs/Public/img/logo.jpg'/></div>
		<div class='nav-title'>毕业设计(论文)管理系统</div>
		<div class='nav-user'>
			<!---已经登录--->
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
				<li><a href="#" class="icon-home"> 首页</a></li>
				<li class='active'>正文</li>
				</ul>
			</div>
			
			<div class='line'>
				<div class='xm9  xs9 hidden-l'>
						<div class="banner content-banner">
						<div class="carousel">
						<div class="item">
							<img src=http://cs.hust.edu.cn/public/upfile/4.jpg>
						</div>
						<div class="item">
							<img src=http://cs.hust.edu.cn/public/upfile/1.jpg>
						</div>
						<div class="item">
							<img src=http://cs.hust.edu.cn/public/upfile/2.jpg>
						</div>
						</div>
						</div>
				</div>
				<div class='xm3 xs3 xl12'>
					<div class="panel">
						<div class="panel-head bg-main">时间安排</div>
						<div class="panel-body">
							<marquee id="affiche" align="left" behavior="scroll" direction="up" height="170" width="100%" hspace="50" vspace="20" loop="-1" scrollamount="10" scrolldelay="200" onMouseOut="this.start()" onMouseOver="this.stop()">
								<?php if(is_array($plan)): $i = 0; $__LIST__ = $plan;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$plan): $mod = ($i % 2 );++$i;?><p><?php echo ($plan["ttime"]); ?>    <?php echo ($plan["content"]); ?></p><?php endforeach; endif; else: echo "" ;endif; ?>
							</marquee>
						</div>
					</div>

				</div>
			</div>
		</div>
		<!--新闻、下载、链接-->
		<div class='layout'>
			<div class='line'>
				<div class='xm5 xs5 xl12'>
					<div class="panel news">
						<div class="panel-head bg-main bg-inverse">
						<span class='icon-bullhorn'></span>
						通知公告
						<span style='float:right'><a href="<?php echo U('Home/Index/news');?>">更多>></a></span>
						</div>
						<div class="panel-body">
							<?php if(is_array($news)): $i = 0; $__LIST__ = $news;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$news): $mod = ($i % 2 );++$i;?><p>[<?php echo (substr($news['publishtime'],5,5)); ?>]<a href="<?php echo U('Home/Index/newsdetail');?>?id=<?php echo ($news["id"]); ?>" target='_blank'><?php echo ($news["title"]); ?></a></p><?php endforeach; endif; else: echo "" ;endif; ?>
						</div>
					</div>
				</div>
				<div class='xm4 xs4 xl12'>
					<div class="panel">
						<div class="panel-head bg-main bg-inverse">
						<span class='icon-download'></span>
						资料下载
						<span style='float:right'><a href="<?php echo U('Home/Index/file');?>">更多>></a></span>
						</div>
						<div class="panel-body">
						<?php if(is_array($file)): $i = 0; $__LIST__ = $file;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$file): $mod = ($i % 2 );++$i;?><p>[<?php echo (substr($file['publishtime'],5,5)); ?>]<span class='icon-file-<?php echo ($file["type"]); ?>-o'></span><a href='/<?php echo ($file["fileurl"]); ?>'><?php echo (urldecode($file["title"])); ?></a></p><?php endforeach; endif; else: echo "" ;endif; ?>
						
						</div>
					</div>
				</div>
				<div class='xm3 xs3 xl12'>
					<div class="panel">
						<div class="panel-head bg-main bg-inverse">
						<span class='icon-link'></span>
						相关链接
						<span style='float:right'><a href="<?php echo U('Home/Index/link');?>">更多>></a></span>
						</div>
						<div class="panel-body">
							<?php if(is_array($link)): $i = 0; $__LIST__ = $link;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$link): $mod = ($i % 2 );++$i;?><p class="text-link"><span class='icon-globe text-big' style='margin-right:10px'></span><a href="<?php echo ($link["linkurl"]); ?>" target="_blank"><?php echo ($link["title"]); ?></a></p><?php endforeach; endif; else: echo "" ;endif; ?>
						</div>
					</div>
				</div>
			</div>
			
		</div>
	</div>
  </div>
  <!---footer--->
  <div id='footer'>
	<p class='text-center'>CopyRight2015毕业设计(论文)管理系统</p>
  </div>
  </body>
</html>