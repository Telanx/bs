<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html lang="zh-cn">
  <head>
    <title>毕业设计(论文管理系统)</title>
    <meta name="keywords" content="毕业设计" />
    <meta name="description" content="论文管理系统" />
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="viewport" content="width=device-width,initial-scale=1.0, maximum-scale=1.0,user-scalable=no">
    <link rel="stylesheet" href="/bs/Public/lib/pintuer/pintuer.css">
	<link rel="stylesheet" href="/bs/Public/css/menu.css">
	<style type='text/css'>
	.tab-body a,.popup-body a{
	 text-decoration:underline;
	 color:#f00;
	}
	</style>
    <script type='text/javascript' src='/bs/Public/lib/pintuer/jquery.js'></script>
	<script type='text/javascript' src='/bs/Public/js/menu.js'>
	</script>
	<script type='text/javascript'>
	$(function(){
		var f = <?php echo ($s); ?>;
		if(f!=0){
			var mask=$('.mask'),
			container=$('.container-popup'),
			title=$('.container-popup').find('.popup-title-text'),
			body=$('.container-popup>.popup-body');
			var popup=new pop(mask,container,title,body);
			var tip1 = "<p>检测到您还未对系统选项进行配置，请先进入系统设置><a href=<?php echo U('Admin/Sys/sel');?> target=_blank>选项配置</a>进行配置</p>" ;
			var tip2 = "<p>系统检测到您还未对选题时间进行配置，请先进入系统设置><a href=<?php echo U('Admin/Sys/time');?>>毕设时间设置</a>进行配置</p>";
			var tip = "";
			if(f==1)tip+=tip1;
			if(f==2)tip+=tip2;
			popup.setTitle("温馨提示：").setCss({width:"400px"}).setBody(tip).show();
		}
	});
	</script>
  </head>
<body>
	<!---全屏--->
	<div id='content'>
		<div class='layout admin'>
			<!--左侧菜单栏-->
			<div class='x2 left'>
				<div class='line user-info'>
					<div class='user-img'><img src='https://ss1&#46;baidu&#46;com/6ONXsjip0QIZ8tyhnq/it/u=801265354,741403095&fm=58' class='img-border radius-circle' width=100 height=100></div>
					<div class='user-name'><p class='text-center'><?php echo ($user); ?></p></div>
				</div>
				
				<!---菜单开始-->
				<div class='line menu'>
						<dl class='mainmenu start link'>
							<a href="<?php echo U('Admin/Index/index');?>"><span class='icon-logo icon-home text-big'></span>开始</a>
						</dl>
						
						
						
						<dl class='mainmenu user'>
							<dt><span class='icon-logo icon-user text-big'></span>用户管理</dt>
								<dd class='link'><a href="<?php echo U('Admin/User/account');?>">新建用户</a></dd>
								<dd class='link'><a href="<?php echo U('Admin/User/student');?>">学生</a></dd>
								<dd class='link'><a href="<?php echo U('Admin/User/teacher');?>">教师</a></dd>
								<dd class='link'><a href="<?php echo U('Admin/User/admin');?>">管理员</a></dd>
							
						</dl>
						
						<dl class='mainmenu bs'>
							<dt><span class='icon-logo icon-mortar-board text-big'></span>毕业设计</dt>
							
								<dd class='link'><a href="<?php echo U('Admin/Bs/preview');?>">课题总览</a></dd>
								<dd class='link'><a href="<?php echo U('Admin/Bs/view');?>">查看课题</a></dd>
								<dd class='link'><a href="<?php echo U('Admin/Bs/history');?>">历史数据查询</a></dd>
							
						</dl>
						<dl class='mainmenu sys'>
							<dt><span class='icon-logo icon-cog text-big'></span>系统设置</dt>
								<dd class='link'><a href="<?php echo U('Admin/Sys/init');?>">初始化</a></dd>
								<dd class='link'><a href="<?php echo U('Admin/Sys/sel');?>">选项配置</a></dd>
								<dd class='link'><a href="<?php echo U('Admin/Sys/time');?>">毕设时间设置</a></dd>
						</dl>
						<dl class='mainmenu start link'>
							<a href="<?php echo U('Home/Login/logout');?>"><span class='icon-logo icon-power-off text-big'></span>退出</a>
						</dl>
					
						<dl class='mainmenu text-center'>
							<p>请使用IE8+或chrome浏览</p>毕业管理系统管理后台
						</dl>
					
				</div>
				
				<!--菜单结束-->
				
			</div>
			<!---右侧具体内容-->
			<div class='x10 right'>
				<div class='line'>
				<!---图片轮播、时间安排、最新动态、资料下载、链接管理--->
					<div style='height:20px'></div>
					<div class="tab border-main">
					<div class="tab-head">
					<strong>前台设置</strong>
					
					<ul class="tab-nav">
					
					<li><a href="<?php echo U('Admin/Index/plan');?>">时间规划</a></li>
					<li><a href="<?php echo U('Admin/Index/news');?>">动态新闻</a></li>
					<li><a href="<?php echo U('Admin/Index/doc');?>">相关资料</a></li>
					<li><a href="<?php echo U('Admin/Index/link');?>">相关链接</a></li>
					</ul>
					</div>
					<div class="tab-body">
					<p><?php echo ($user); ?>您好！</p>
					<p>每年在选题前需要对此系统进行一次<a href="<?php echo U('Admin/Sys/init');?>">初始化</a>及<a href="<?php echo U('Admin/sys/time');?>">选题时间配置</a>，初始化完成后，请勿再重复操作。</p>
					
					</div>
				</div>
			</div>
		</div>
	</div>
  <!---footer--->
  <div id='footer'>
	<p class='text-center'>CopyRight2015毕业设计(论文)管理系统</p>
  </div>
  <!---全局遮罩层-->
  <div class='mask' style='position:fixed;top:0;width:100%;height:100%;background:rgba(0,0,0,0.6);display:none;'>
		  <!---弹出层--->
		<div class='container-popup' style='position:relative;width:300px;margin:auto;margin-top:200px;display:none'>
		<div class='popup-title' style='width:100%;height: 38px;color:#fff;padding:0 10px;line-height: 38px;position: relative;background:rgb(51,51,51);background: -webkit-gradient(linear,left top,right top,from(#000),to(#767676));border-bottom: 1px solid #d1d6dd;'>
		<span class='popup-title-text'>标题</span>
		<span class='popup-title-close icon-times' style='float:right;cursor:pointer;'></span>
		</div>
		<div class='popup-body' style='background:#fff;color:#000;min-height:100px;padding:10px'>
		</div>
		</div>
  </div>

  
  
</body>
</html>