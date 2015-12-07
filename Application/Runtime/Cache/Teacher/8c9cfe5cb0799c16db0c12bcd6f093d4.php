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
	var popup=pop(mask,container,title,body);
	//关闭弹出层
	$('.container-popup').find('.popup-title-close').bind('click',function(e){popup.hide();})
	$('.container-popup').on('click','.btn-cancel',function(e){e.preventDefault();popup.hide();});
	//加载部门数据
	var dep_list = <?php echo ($dep==null?'[]':$dep["v"]); ?>;
	if(dep_list.length<2)$("#dep-list").html("");
	(function(l,dom){$.each(l,function(i,e){dom.append('<option value='+e+'>'+e+'</option>');})})(dep_list,$('#dep-list'));
	
    //全部、未审核切换
	var authType = <?php echo ($ttype); ?>;
	$('.tab_navs').bind('click',function(e){
			var d = $(e.target);
			var dep = $('#dep-list').val();
			var s=0,p=1;//全部
			d.parent().children().removeClass('tab_selected');
			if(!d.hasClass('selected'))d.addClass('tab_selected');
			if(!d.hasClass('all'))s=1;
			R_H(dep,s,p,0);	//默认获取第一页
		})
	//获取数据，默认获取所有>全部>第一页数据
	//参数:d,s,p
	function R_H(d,s,p){
		var url ="<?php echo U('Teacher/BsManager/ktsh_handler');?>";
		var type = 'search';
		$.post(url,{type:type,d:d,s:s,p:p},function(res){
			$('.search-result-table tbody>:not(.th)').remove();//清空数据
			var rl = res.r.length;
			var p_c = res.page.c_p,
			p_t = res.page.t_p,
			r = res.r;
			for(var i=0;i<rl;i++){
					$('.search-result-table').append("<tr><td><input type='checkbox' name='check' data-id='"+r[i].id+"'</td><td><a href=# class='view' data-id='"+r[i].id+"'>"+r[i].bname+'</a></td><td>'+(r[i].tname)+'</td><td>'+(r[i].status==authType?'<font color=#0f0>已审核</font>':'<font color=#f00>待审核</font>')+'</td><td>'+(r[i].dep||'-')+'</td></tr>');
			}
			//显示或者隐藏分页
			page({current:p_c,total:p_t},{page_prev:$('.btn-page-prev'),page_next:$('.btn-page-next'),page_num:$('.page-num')});
			if(rl==0){
				$('.search-result-table').append('<tr><td colspan=5>无任何相关结果。<td></tr>');
				$('.page').hide();
			}else $('.page').show();
		});
	}
	
	//提交审核处理
	function C_H(l,t){
		var url ="<?php echo U('Teacher/BsManager/ktsh_handler');?>";
		var type=(t?'unedit':'edit');
		$.post(url,{type:type,list:l},function(r){
			popup.setTitle('处理结果').setBody('<p class=text-center>'+r.msg+'</p>').show();
			if(r.status==1)setTimeout(function(){popup.hide();location.reload();},2000);
		});
	}
	//全选
	$('input[name=selectall]').click(function(e){
		if($(e.target).is(':checked'))$.each($('input[type=checkbox]'),function(i,e){e.checked=true;});
		else $.each($('input[type=checkbox]'),function(i,e){e.checked=false;});
	})
	//审批
	$('#checkall').click(function(e){
		//查找所有check的
		var check_list=[];
		$.each($('input[name=check]'),function(i,e){
			if(e.checked){
				var id_ks = $(e).attr('data-id');
				check_list.push(id_ks);
			}
		});
		if(check_list.length)C_H(check_list);
	});
	//取消审核
	$('#uncheckall').click(function(e){
	//查找所有check的
		var check_list=[];
		$.each($('input[name=check]'),function(i,e){
			if(e.checked){
				var id_ks = $(e).attr('data-id');
				check_list.push(id_ks);
			}
		});
		if(check_list.length)C_H(check_list,1);
	});
	//查看课题任务
	$('.search-result-table').on('click','.view',function(e){
		var bid= $(e.target).attr('data-id');
		window.open("<?php echo U('Home/Bs/viewkt');?>?bid="+bid);
	})
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
				s=$('.tab_selected').hasClass('all')?0:1,
				p = c-1;
				if(c==1)return false;
				R_H(d,s,p,0);
			})
			r.click(function(){
				var pageNum = $('.page-num').text().split('/');
				var c=parseInt(pageNum[0]),t=parseInt(pageNum[1]);
				var g = $('.input-page-go').val();
				if(c==t)return false;
				var d =$('#dep-list').val(),
				s=$('.tab_selected').hasClass('all')?0:1,
				p = c+1;
				R_H(d,s,p,0);
			})
			g.click(function(){
				var pageNum = $('.page-num').text().split('/');
				var c=parseInt(pageNum[0]),t=parseInt(pageNum[1]);
				
				var g = parseInt($('.input-page-num').val());
				
				var d =$('#dep-list').val(),
				s=$('.tab_selected').hasClass('all')?0:1,
				p = g;
				if(!(g<=t&&g>=1&&g))alert('请输入合理的翻页！');
				else R_H(d,s,p,0);
				
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
					<div class='user-img'><img src='https://ss1.baidu.com/6ONXsjip0QIZ8tyhnq/it/u=801265354,741403095&fm=58' class='img-border radius-circle' width=100 height=100></div>
					<div class='user-name'><p class='text-center'><?php echo ($user["name"]); ?></p>
					<p class='text-center user-type'>
							<?php switch($ttype): case "1": ?>教师<?php break;?>
							<?php case "2": ?>系主任<?php break;?>
							<?php case "3": ?>院长<?php break;?>
							<?php default: ?>教师<?php endswitch;?>
						</p></div>
				</div>
<!---菜单开始-->
			<?php if(($ttype > 1)): ?><div class='line menu'>
						<dl class='mainmenu start link'>
							<a href="<?php echo U('Teacher/Index/index');?>"><span class='icon-logo icon-home text-big'></span>开始</a>
						</dl>
						<dl class='mainmenu user'>
							<dt><span class='icon-logo icon-user text-big'></span>个人中心</dt>
								<dd class='link'><a href="<?php echo U('Teacher/User/view');?>">查看资料</a></dd>
								<dd class='link'><a href="<?php echo U('Teacher/User/edit');?>">修改资料</a></dd>
								
							
						</dl>
						
						<dl class='mainmenu bs'>
							<dt><span class='icon-logo icon-mortar-board text-big'></span>毕业设计</dt>
							
								<dd class='link'><a href="<?php echo U('Teacher/Bs/add');?>">课题填报</a></dd>
								<dd class='link'><a href="<?php echo U('Teacher/Bs/xt');?>">选题情况</a></dd>
								<dd class='link'><a href="<?php echo U('Teacher/Bs/manage');?>">毕设管理</a></dd>
							
						</dl>
						
						<dl class='mainmenu bs'>
							<dt><span class='icon-logo icon-mortar-board text-big'></span>课题管理</dt>
							
								<dd class='link'><a href="<?php echo U('Teacher/BsManager/preview');?>">课题总览</a></dd>
								<dd class='link'><a href="<?php echo U('Teacher/BsManager/ktsh');?>">课题审核</a></dd>
								<dd class='link'><a href="<?php echo U('Teacher/BsManager/history');?>">历史数据查询</a></dd>
							
						</dl>
						
						
						<dl class='mainmenu start link'>
							<a href="<?php echo U('Home/Login/logout');?>"><span class='icon-logo icon-power-off text-big'></span>退出</dl></a>
						<dl class='mainmenu text-center'>
							<p>请使用IE8+或chrome浏览</p>毕业管理系统管理后台
						</dl>
					
				</div>
				<?php else: ?> 
					<div class='line menu'>
						<dl class='mainmenu start link'>
							<a href="<?php echo U('Teacher/Index/index');?>"><span class='icon-logo icon-home text-big'></span>开始</a>
						</dl>
						<dl class='mainmenu user'>
							<dt><span class='icon-logo icon-user text-big'></span>个人中心</dt>
								<dd class='link'><a href="<?php echo U('Teacher/User/view');?>">查看资料</a></dd>
								<dd class='link'><a href="<?php echo U('Teacher/User/edit');?>">修改资料</a></dd>
								
							
						</dl>
						
						<dl class='mainmenu bs'>
							<dt><span class='icon-logo icon-mortar-board text-big'></span>毕业设计</dt>
							
								<dd class='link'><a href="<?php echo U('Teacher/Bs/add');?>">课题填报</a></dd>
								<dd class='link'><a href="<?php echo U('Teacher/Bs/xt');?>">选题情况</a></dd>
								<dd class='link'><a href="<?php echo U('Teacher/Bs/manage');?>">毕设管理</a></dd>
							
						</dl>
						<dl class='mainmenu start link'>
							<a href="<?php echo U('Home/Login/logout');?>"><span class='icon-logo icon-power-off text-big'></span>退出</dl></a>
						<dl class='mainmenu text-center'>
							<p>请使用IE8+或chrome浏览</p>毕业管理系统管理后台
						</dl>
					
				</div><?php endif; ?>
				
				<!--菜单结束-->
				
			</div>
			<!---右侧具体内容-->
			<div class='x10 right'>
				<div class='line'>
					<div class='right-head'>
						<h2>课题审核</h2>
					</div>
					<div class='right-body'>
						<div class='body-title' style='height:34px;line-height:30px;border-bottom:1px solid #ccc'>
							<div class='title-select'>
								<select id="dep-list" style="width:90px;height:34px;float:left;border-radius:0px">		
									<option value="0">全部单位</option>
									
								</select>
							</div>
							<div class="title-tab">
								<ul class="tab_navs" style='list-style-type: none'>
									<li class="tab_nav tab_selected all" style='width:100px;float:left;text-align:center;cursor:pointer'>全部</li>
									<li class="tab_nav" style='float:left;width:100px;text-align:center;cursor:pointer'>未审核</li>
								</ul>
							</div>
						</div>
						<div class='body-content'>
						
							<table class="table table-hover search-result-table">
								<tr class='th'><th>选择</th><th>课题名称</th><th>指导老师</th><th>审核状态</th><th>所属研究所</th></tr>
							</table>
                                <!---start-->
                
                                <!---end---->
                                <!---分页组件-->
								<div class='right-result-bottom toolbar page' style='margin:20px 0 20px 0;display:none'>
									<div class='right-result-toolbar' style='line-height:34px;float:left'>
										<input type='checkbox' name='selectall'>全选
										<button id='checkall' class='button bg-main'>批准选中项</button>
										<button id='uncheckall' class='button border-main'>取消批准选中项</button>
									</div>
									<div class='right-result-pagination' style='float:right;padding-right:100px;'>
										
											<button class='button border-main btn-page-prev'><i class='icon-caret-left text-big'></i></button>
											<span class='page-num text-big'>1/1</span>
											<button class='button border-main btn-page-next'><i class='icon-caret-right text-big'></i></button>
											<input type="text" class="input input-auto input-page-num" name="keywords" size="5" placeholder="页数">
											<button class='button bg-main btn-page-go'>转到</button>
										
									</div>
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