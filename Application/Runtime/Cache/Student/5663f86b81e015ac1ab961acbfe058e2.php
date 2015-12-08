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
	.right-head{
		line-height:35px;
	}
    
	table tr th{
		width:80px;
	}
	table tr{
		line-height:50px;
		font-size:18px;
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
	
	//弹出层管理
	var mask=$('.mask'),
	container=$('.container-popup'),
	title=$('.container-popup').find('.popup-title-text'),
	body=$('.container-popup>.popup-body');
	var popup=new pop(mask,container,title,body);
	//关闭弹出层
	$('.container-popup').find('.popup-title-close').bind('click',function(e){popup.hide();})
	$('.container-popup').on('click','.btn-cancel',function(e){e.preventDefault();popup.hide();});
    //全部、未审核切换
	$('.tab_navs').bind('click',function(e){
			var d = $(e.target);
			var dep = $('#dep-list').val();
			var s=0,p=1;//全部
			d.parent().children().removeClass('tab_selected');
			if(!d.hasClass('selected'))d.addClass('tab_selected');
			if(!d.hasClass('all'))s=1;
			R_H(dep,s,p,0);	//默认获取第一页
		})
	//获取数据，默认获取所有>第一页数据
	//参数:k,d,p,t
	function R_H(k,d,p,t){
		var url ="<?php echo U('Student/Bs/xt_handler');?>";
		$.post(url,{t:t,k:k,d:d,p:p},function(res){
			$('.search-result-table tbody>:not(.th)').remove();//清空数据
			var rl = res.r.length;
			var p_c = res.page.c_p,
			p_t = res.page.t_p,
			r = res.r;
			for(var i=0;i<rl;i++){
					var f=r[i].num<r[i].snum?1:0;
					var h='';
					if(f)h="<button class='button border-main select' data-id="+r[i].id+">选择</buttom>";
					else h="<p class='button text-red text-center'>已满</p>";
					$('.search-result-table').append("<tr><td>"+h+"</td><td><a href=# class='view'>"+r[i].bname+'</a></td><td>'+r[i].tname+'</td><td>'+(r[i].dep||'-')+'</td><td>'+r[i].num+'/'+r[i].snum+'</td></tr>');
			}
			//显示或者隐藏分页
			page({current:p_c,total:p_t},{page_prev:$('.btn-page-prev'),page_next:$('.btn-page-next'),page_num:$('.page-num')});
			if(rl==0){
				$('.search-result-table').append('<tr><td colspan=5>无任何相关结果。<td></tr>');
				$('.page').hide();
			}else $('.page').show();
		});
	}
	//搜索选题
	$('form').submit(function(e){
			e.preventDefault();
			R_H($(e.target).find('input').val(),$('#dep-list').val(),1,'search');
		});
	//选择题目
	$('.right-result-body').on('click','.select',function(e){
		var bid = $(e.target).attr('data-id');
		$.post("<?php echo U('Student/Bs/xt_handler');?>",{t:'edit',bid:bid},function(r){
			popup.setTitle('选择结果').setBody('<p class=text-center>'+r.msg+'<p>').show();
			if(r.status==1){
						setTimeout(function(){popup.hide()},1000);
					}
		});
	});	
	//初始化加载部门配置数据
		var dep_list = ['全部','安全所','存储所','计算所','数据所','媒体所','理论所','工程中心','教学中心'];
		(function(l,dom){$.each(l,function(i,e){dom.append('<option value='+i+'>'+e+'</option>');})})(dep_list,$('#dep-list'));
	//分页组件
		var page= function(o,d){
			var p_c = o.current,p_t = o.total;
			if(p_c==1)d.page_prev.hide();
			else d.page_prev.show();
			if(p_c==p_t)d.page_next.hide();
			else d.page_next.show();
			d.page_num.html(p_c+'/'+p_t);
		};
		//分页组件事件处理
		(function(){
			var l=$('.btn-page-prev'),
			r=$('.btn-page-next'),
			g=$('.btn-page-go');
			l.click(function(){
				var pageNum = $('.page-num').text().split('/');
				var c=parseInt(pageNum[0]),t=parseInt(pageNum[1]);
				var g = $('.input-page-go').val();
				var d =$('#dep-list').val(),
				k=$('input[name=search]').val(),
				p = c-1;
				if(c==1)return false;
				R_H(k,d,p,'search');
			})
			r.click(function(){
				var pageNum = $('.page-num').text().split('/');
				var c=parseInt(pageNum[0]),t=parseInt(pageNum[1]);
				var g = $('.input-page-go').val();
				if(c==t)return false;
				var d =$('#dep-list').val(),
				k=$('input[name=search]').val(),
				p = c+1;
				R_H(k,d,p,'search');
			})
			g.click(function(){
				var pageNum = $('.page-num').text().split('/');
				var c=parseInt(pageNum[0]),t=parseInt(pageNum[1]);
				
				var g = parseInt($('.input-page-num').val());
				
				var d =$('#dep-list').val(),
				k=$('input[name=search]').val(),
				p = g;
				if(!(g<=t&&g>=1&&g))alert('请输入合理的翻页！');
				else R_H(k,d,p,'search');
				
			})
		})();
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
					<div class='user-img'><img src='<?php echo ($user[pic]?$user[pic]:"https://ss1&#46;baidu&#46;com/6ONXsjip0QIZ8tyhnq/it/u=801265354,741403095&fm=58"); ?>' class='img-border radius-circle' width=100 height=100></div>
					<div class='user-name'><p class='text-center'><?php echo ($user["name"]); ?></p></div>
				</div>
				<div class='line menu'>
						<dl class='mainmenu start link'>
							<a href="<?php echo U('Student/Index/index');?>"><span class='icon-logo icon-home text-big'></span>开始</a>
						</dl>
						<dl class='mainmenu user'>
							<dt><span class='icon-logo icon-user text-big'></span>个人中心</dt>
								<dd class='link selected'><a href="<?php echo U('Student/User/view');?>">查看资料</a></dd>
								<dd class='link'><a href="<?php echo U('Student/User/edit');?>">修改资料</a></dd>
								
							
						</dl>
						
						<dl class='mainmenu bs'>
							<dt><span class='icon-logo icon-mortar-board text-big'></span>毕业设计</dt>
							
								<dd class='link'><a href="<?php echo U('Student/Bs/xt');?>">选题</a></dd>
								<dd class='link'><a href="<?php echo U('Student/Bs/manage');?>">毕设管理</a></dd>
							
						</dl>
						
						<dl class='mainmenu start link'>
							<a href="<?php echo U('Home/Login/logout');?>"><span class='icon-logo icon-power-off text-big'></span>退出</a>
						</dl>
						<dl class='mainmenu text-center'>
							<p>请使用IE8+或chrome浏览</p>毕业管理系统管理后台
						</dl>
					
				</div>
			</div>
			<!---右侧具体内容-->
			<div class='x10 right'>
				<div class='line'>
					<div style='height:20px'></div>
					<div class='right-head' style='border-bottom:solid 1px #aaa'>
						<h2>个人资料</h2>
					</div>
					<div class='right-body'>
						<div class='x2'></div>
						<div class='x8' style='box-shadow:0 0 4px #aaa;padding:40px;margin-top:50px;'>
								<div class='info-left' style='width:60%;float:left'>
									<table>
									<tr><th>账      号</th><td><?php echo ($user["user"]); ?></td></tr>
									<tr><th>姓      名</th><td><?php echo ($user["name"]); ?></td></tr>
									<tr><th>班       级</th><td><?php echo ($user["class"]); ?></td></tr>
									<tr><th>状      态</th><td><?php echo ($user['status']==1?"<p class=text-green>正常</p>":"<p class=text-red>禁用</p>"); ?></td></tr>
									<tr><td colspan=2 class='text-gray'>联系方式</td></tr>
									<tr><th>Q  Q</th><td><?php echo ($user["qq"]); ?></td></tr>
									<tr><th>邮   箱</th><td><?php echo ($user["email"]); ?></td></tr>
									<tr><th>手   机</th><td><?php echo ($user["cellphone"]); ?></td></tr>
									</table>
								</div>
								<div class='info-right' style='width:40%;height:200px;float:left'>
									<div class='info-img' style='width:176px;height:195px;border:1px solid #000'>
									<img width=174 height=192 src='https://ss1.baidu.com/6ONXsjip0QIZ8tyhnq/it/u=801265354,741403095&fm=58'/>
									</div>
								</div>
							
							</div>
						</div>
						</div class='x2'></div>
					
				
					
					
				</div>
			</div>
		</div>
	</div>
  <!---footer--->
  <div id='footer'>
	<p class='text-center'>CopyRight2015毕业设计(论文)管理系统</p>
  </div>
  <!---全局遮罩层-->
  <div class='mask' style='position:fixed;top:0;width:100%;height:200%;background:rgba(0,0,0,0.6);display:none;'>
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