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
	.sel-box li{
		list-style:none;
		width:152px;
		height:45px;
		border:1px solid #000;
		padding-left:10px;
		float:left;
	}
	.text-edit-box{
		width:110px;
		height:45px;
		line-height:45px;
		float:left;
	}
	
	.text-del{
		width:20px;
		height:45px;
		line-height:45px;
		float:left;
	}
	.text-del:hover{
		cursor:pointer;
		color:#f00;
	}
	</style>
    <script src="/bs/Public/lib/pintuer/jquery.js"></script>
    <script src="/bs/Public/lib/pintuer/pintuer.js"></script>
	<script src="/bs/Public/js/menu.js"></script>
	<!----IE9以下增加media query-->
    <!--[if lt IE 9]>
	<script src="/bs/Public/lib/pintuer/respond.js"></script>
	<![endif]-->
    <script type='text/javascript'>
	$(function(){
	
	var mask=$('.mask'),
	container=$('.container-popup'),
	title=$('.container-popup').find('.popup-title-text'),
	body=$('.container-popup>.popup-body');
	var popup=new pop(mask,container,title,body);
	
	/***相关链接处理***/
	$('.container-popup').find('.popup-title-close').bind('click',function(e){
		popup.hide();
	})
	//取消操作
	$('.container-popup').on('click','.btn-cancel',function(){popup.hide();});
	
	//加载类目
	(function(){
		var sel = {
			'class':<?php echo ($sel['class']['v']==null?'[]':$sel['class']['v']); ?>,
			'dep':<?php echo ($sel['dep']['v']==null?'[]':$sel['dep']['v']); ?>,
			'bstype':<?php echo ($sel['bstype']['v']==null?'[]':$sel['bstype']['v']); ?>,
			'bsway':<?php echo ($sel['bsway']['v']==null?'[]':$sel['bsway']['v']); ?>
		};
		$.each(sel,function(i,e){
			var d = $('#sel-'+i);
			console.log(d);
			console.log(e);
			for(var j=0;j<e.length;j++){
			console.log(e[j]);
			(function(d,e){
			d.append('<li>\
											<div class="text-edit-box" contentEditable=true>'+e[j]+'</div>\
											<div class="text-del"><span class="icon-times"></span></div>\
										</li>');
										})(d,e);
										}
		});
	})();
	
	
	//添加类目
	$('.btn-add').click(function(e){
		$(this).parent().parent().parent().find('.sel-box').append('<li>\
										<div class="text-edit-box" contentEditable=true></div>\
										<div class="text-del"><span class="icon-times"></span></div>\
									</li>');
	});
	//发送保存
	function Sel_Save(url,data,callback){
		$.post(url,data,callback);
	}
	//保存类目
	$('.btn-save').click(function(e){
		//获取当前对应的类目
		var ulbox = $(this).parent().parent().prev().find('.sel-box');
		//获取列表
		var sel=ulbox.attr('id');
		var sel_a = [];
		var ulbox_c = ulbox.children();
		for(var i=0;i<ulbox_c.length;i++){
			var li_s = ulbox_c[i].innerText.trim();
			if(li_s)sel_a.push(li_s);
		}
		var url = "<?php echo U('Admin/Sys/sel_handler');?>";
		Sel_Save(url,{type:'save',sel_a:sel_a,sel:sel},function(r){
			popup.setTitle('处理结果').setBody('<p class=text-center>'+r.msg+'</p>').show();
					if(r.status==1){
						setTimeout(function(){popup.hide();location.reload();},2000);
					}
		});
	});
	//删除分类
	$('.sel-box').on('click','.text-del',function(e){
		console.log($(this));
		$(this).parent().remove();
	});
	
	})
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
				<!---班级，单位，毕设类型，方式--->
					<div style='height:20px'></div>
					<h3 class='doc-h3'>基本配置</h3>
					<div class="alert alert-yellow"><span class="close rotate-hover"></span><strong>提示：</strong>单击文字区域即可编辑。</div>

					<blockquote class="quote border-yellow doc-quoteyellow">
						<strong>班级类目(学生)</strong>
						<div class='line'>
							<div class='x8'>
								<ul class='sel-box' id='sel-class'>
								
									
								
								</ul>
								
							</div>
							<div class='x4'>
								<div class='op'>
									<button class='button btn-add'>添加新类目</button>
									<button class='button bg-main btn-save'>保存</button>
								</div>
							</div>
						</div>
						
					</blockquote>
					
					<blockquote class="quote border-yellow doc-quoteyellow">
						<strong>单位类目(教师)</strong>
						<div class='line'>
							<div class='x8'>
								<ul class='sel-box' id='sel-dep'>
								
									
								
								</ul>
								
							</div>
							<div class='x4'>
								<div class='op'>
									<button class='button btn-add'>添加新类目</button>
									<button class='button bg-main btn-save'>保存</button>
								</div>
							</div>
						</div>
						
					</blockquote>
					
					<blockquote class="quote border-yellow doc-quoteyellow">
						<strong>毕设类型(课题)</strong>
						<div class='line bstype'>
							<div class='x8'>
								<ul class='sel-box' id='sel-bstype'>
								
									
								
								</ul>
								
							</div>
							<div class='x4'>
								<div class='op'>
									<button class='button btn-add'>添加新类目</button>
									<button class='button bg-main btn-save'>保存</button>
								</div>
							</div>
						</div>
						
					</blockquote>
					
					<blockquote class="quote border-yellow doc-quoteyellow">
						<strong>毕设进行方式(学生)</strong>
						<div class='line'>
							<div class='x8'>
								<ul class='sel-box' id='sel-bsway'>
								
									
								
								</ul>
								
							</div>
							<div class='x4'>
								<div class='op'>
									<button class='button btn-add'>添加新类目</button>
									<button class='button bg-main btn-save btn-save-bsway'>保存</button>
								</div>
							</div>
						</div>
						
					</blockquote>
					
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