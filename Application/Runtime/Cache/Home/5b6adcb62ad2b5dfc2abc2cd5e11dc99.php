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
	.wrap{
		max-width:730px;
		height:350px;
		margin:0 auto;
		padding-top:5%;
		//box-shadow: 0 0 1px 1px rgba(0,0,0,0.25);
	}
	.img,.login{
		float:left;
	}
	.login{
		max-width:380px;
		overflow:hidden;
	}
	.slidepage{
		width:760px;
	}
	.login-form{
	 width:380px;
	 float:left;
	 
	}
	.login-form form{
		padding:20px 20px 0 20px;
	}
	.getpwd{
		width:380px;
		float:left;
	}
	.form-title{
		padding-top:5px;
		margin-bottom:10px;
		height:30px;
	}
	.form-group .x3{
		margin-top:8px;
	}
	.backlogin{
		margin-top:215px;
	}
	</style>
    <script src="/bs/Public/lib/pintuer/jquery.js"></script>
    <script src="/bs/Public/lib/pintuer/pintuer.js"></script>
	<script src="/bs/Public/js/menu.js"></script>
    <!--[if lt IE 8]>
	<script src="/bs/Public/lib/pintuer/respond.js"></script>
	<![endif]-->

		<script type='text/javascript'>
	$(function(){
			var msgNode = $('.error');
			if(msgNode.length){
				for(i=0;i<3;i++){
				msgNode.animate({'marginLeft':'-10px'},30).animate({'marginLeft':'0px'},30).animate({'marginLeft':'10px'},30).animate({'maeginLeft':'0px'},30);
					}
				setTimeout(function(){msgNode.animate({opacity:0},1000).remove()},2000);
			}
	$('.gopwd').click(function(){
		$('.slidepage').animate({"marginLeft":"-380px"},500);
	})
	$('.backlogin').click(function(){
		$('.slidepage').animate({"marginLeft":"0px"},500);
	})
	//更换验证码
	$('.verify').click(function(){
		$(this).find('img').attr('src','/bs/index.php/Home/Login/verifycode.html/');
	})
	
	});
		</script>
		<script>
			$(function(){
				var cookie=function(s){
					this.cookie = s;
					this.get=function(p){
						var c =decodeURIComponent(document.cookie).split('; ');
						for(var i=0;i<c.length;i++){
							var t = p+'=';
							if(c[i].indexOf(t)==0)return c[i].replace(t,'');
						}
					}
				}
				var c = new cookie(decodeURIComponent(document.cookie));
				var type=Number(c.get('type'));
				var user = c.get('user');
				$('input[name=user]').val(user);
				$.each($('input[name=type]'),function(i,e){
					e.checked=false;
					$(e).parent().removeClass('active');
					if(i==type-1){
						e.checked=true;
						$(e).parent().addClass('active');
						}
				});
				
				
			});
		</script>
	</head>
	<body>
<body>
  <!---导航栏-->
  <div id='nav-top'>
	<div class='nav-center'>
		<div class='nav-logo hidden-l'><img src='/bs/Public/img/logo.jpg' width=100px height=70px /></div>
		<div class='nav-title'>毕业设计(论文)管理系统</div>
		<!---<div class='nav-user'>
			<a href=<?php echo U('Home/Login/index');?> class='button border-main'><span class='icon-user text-big'></span>登录</a>
		</div>--->
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
				<li class='active'>登录</li>
				</ul>
			</div>
			<div class='line'>
				<!------中间登录部分--->
				<div class='wrap'>
				
					<div class='hidden-l img xl0'><img style="width:330px;height:320px;" src="http://pic.baike.soso.com/p/20101020/20101020171427-853952265.jpg"/></div>
					<div class='login xl12'>
						<div class='slidepage'>
						<div class='login-form'>
						<!---登录框开始-->
						<div class='text-center bg-main bg-inverse form-title'><span class='icon-users'></span>用户登录</div>
						<form  action="<?php echo U('Home/Login/login');?>" method='POST' class='form form-x'>
									
									<div class='form-group border-main'>
											<div class='x3'>类型</div>
											<div class='x9'>
												<div class="button-group radio">
												<label class="button active"><input name="type" value="1" checked="checked" type="radio">学生</label>
												<label class="button"><input name="type" value="2" type="radio">教师</label>
												<label class="button"><input name="type" value="3" type="radio">管理员</label>
												</div>
											</div>
									</div>
									
									<div class='form-group'>
											<div class='x3'>用户名</div>
											<div class='x9'>
												<input type='text' name='user' class='input' data-validate="required:必填">
											</div>
									</div>
									
									<div class='form-group'>
										<div class='x3'>密码</div>
										<div class='x9'>
											<input type='password' name='pwd' class='input' data-validate="required:必填">
										</div>
									</div>
									
									<div class='form-group'>
										<div class='x3'>验证码</div>
										<div class='x5'>
											<input type='text' name='verifycode' class='input' data-validate="required:必填">
										</div>
										<div class='x4'>
											<a href=# class='verify'>
												<img height=33px src=<?php echo U('Home/Login/verifycode');?>/>
											</a>
										</div>
									</div>
								
									<br/>
									<div class='form-group'>
										<div class='x3'></div>
										<div class='x9'>
											<button type='submit' class='button button-block bg-main'>登录</button>
										</div>
									</div>
									<p class='text-right gopwd'><a href="#">忘记密码？→</a></p>
								</form>
								<div class='alert alert-red text-center error' <?php echo ($error?'':'hidden'); ?>><?php echo ($error); ?></div>
						<!--登录框结束--->
						</div>
						
						<!--忘记密码---->
						<div class='getpwd login-form'>
							<div class='text-center bg-main bg-inverse form-title'><span class='icon-key'></span>找回密码</div>
							<form>
							<p>Tips:暂不支持自助找回密码，请联系管理员！</p>
							<p class='text-left backlogin'><a href="#">←返回登录</a></p>
							</form>
						</div>
						<!--忘记密码结束-->
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