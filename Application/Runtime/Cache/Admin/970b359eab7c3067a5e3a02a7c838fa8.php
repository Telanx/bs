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
		line-height:60px;
		border-bottom:1px solid #ccc;
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
		$('.btn-status button').click(function(e){
			e.preventDefault();
			alert(e.target.text());
		})
		/***相关链接处理***/
		$('.container-popup').find('.popup-title-close').bind('click',function(e){
			popup.hide();
		})
		$('form').submit(function(e){
		e.preventDefault();
		})
		$('.btn-status-forbid').click(function(e){
			e.preventDefault();
			alert(e.target);
		})
		//取消操作
		$('.container-popup').on('click','.btn-cancel',function(e){e.preventDefault();popup.hide();})
        
		//从后台获取管理员结果
		function search_admin(key,callback){
			$.post("<?php echo U('Admin/User/admin_handler');?>",{type:'search',key:key},callback);
		}
		$('form').submit(function(e){
			e.preventDefault();
			//清空
			$('.search-result-table tbody>:not(.th)').remove();
			search_admin($(e.target).find('input').val(),function(r){
				var rl = r?r.length:0;
				for(var i=0;i<rl;i++){
					$('.search-result-table').append("<tr><td><button class='button border-dot btn-user-del'>删除</button><button class='button border-sub btn-user-edit'>修改</button></td><td>"+r[i].user+'</td><td>'+(r[i].status||'-')+'</td><td>'+(r[i].createtime||'-')+'</td><td>'+(r[i].lastlogin||'-')+'</td><td>'+(r[i].ip||'-')+'</td></tr>');
				}
				if(rl==0)$('.search-result-table').append('<tr><td colspan=5>无任何相关结果。<td></tr>');
			});
		});
		
		//删除用户
		$('.search-result-table').on('click','.btn-user-del',function(e){
			e.preventDefault();
			var user = $(e.target).parent().next().html();
			popup.setTitle('删除链接').setCss({width:'250px',height:'100px'});
			popup.setBody('<p>确定要删除"'+user+'"吗？</p><div style="text-align:center"><button class="button border-black link-del-yes" data-id='+user+'>确定</button><button class="button border-black btn-cancel">取消</button></div>');
			popup.show();
		})
		
		//修改用户
		$('.search-result-table').on('click','.btn-user-edit',function(e){
			var user=$(this).parent().next().html();
			var status =parseInt($(this).parent().next().next().html());
			var link_edit_html = '<div class=line><form class="form-x">'+
			'<div class="form-group"><div class="label"><label for="user">账号</label></div><div class="field" style="line-height:34px"><input class="input" name="user" value="'+user+'" disabled></div></div>'+
			'<div class="form-group"><div class="label"><label for="pwd">修改密码</label></div><div class="field"><input type="password" class="input" name="pwd" size="30" placeholder="不修改则无需填写"></div></div>'+
			'<div class="form-group"><div class="label"><label for="confirmpwd">确认密码</label></div><div class="field"><input type="password" class="input" name="pwd2" size="30" placeholder="不修改则无需填写"></div></div>'+
			'<div class="form-group"><div class="label"><label for="status">状态</label></div><div class="field" style="line-height:34px">'+
			'<label><input type="radio" value=1 name="s" '+(status?'checked':'')+'>启用</label><label><input type="radio" value=0 name="s" '+(status?'':'checked')+'>禁用</label></div>'
			+'</div>'+
			'<div class="form-group" style="text-align:center"><button class="button border-black link-edit-yes" data-id=>确定</button><button class="button border-black btn-cancel">取消</button></div></form>'+
'</div>';
			popup.setTitle('修改资料').setCss({width:'500px',height:'200px'}).setBody(link_edit_html).show();
		});
		
		//确认删除
		$('.container-popup').on('click','.link-del-yes',function(e){
			var btn_del = $(e.target);
			var user=btn_del.attr('data-id');
			$.post("<?php echo U('Admin/User/admin_handler');?>",{type:'del',user:user},function(r){
				popup.append('<p class=text-center>'+r.msg+'</p>');
					if(r.status==1){
						setTimeout(function(){popup.hide();location.reload();},2000);
					}
			});
		})
		//确认修改
		$('.container-popup').on('click','.link-edit-yes',function(e){
			e.preventDefault();
			//先检查密码问题
            var form_node = $(e.target).parent().parent();
            var pwd = form_node.find('input[name=pwd]').val();
            var pwd2= form_node.find('input[name=pwd2]').val();
            var user = form_node.find('input[name=user]').val();
			var status = parseInt(form_node.find('input[name=s]:checked').val());
            console.log(form_node);
            console.log(pwd+'--'+pwd2);
            if(pwd.trim()!=pwd2.trim()){
                alert('2次密码不一致！');
                return false;
            }
            $.post("<?php echo U('Admin/User/admin_handler');?>",{type:'update',user:user,pwd:pwd.trim(),status:status},function(r){
                popup.append('<p class=text-center>'+r.msg+'</p>');
					if(r.status==1){
						setTimeout(function(){popup.hide();location.reload();},2000);
					}
            });
		})
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
					<div class='right-head'>
						<h2>管理员账号管理</h2>
					</div>
					<div class='right-body'>
						<!---搜索区域--->
						<div class='right-search'>
						<form style='max-width:500px;margin:30px auto;'>
							<input type='text' class='input' placeholder='请输入搜索管理员关键字' style='width:80%;float:left'>
							<button type='submit' class='button' class='float:left'>搜索</button>
							</div>
						</form>
						</div>
						<!--结果区域--->
						<div class='right-result'>
							<div class='right-result-head'><h4>全部结果:</h4></div>
							<div class='right-result-body'>
								<table class="table table-hover search-result-table"><tr class='th'><th>操作</th><th>账号</th><th>状态</th><th>创建时间</th><th>最近登录时间</th><th>登录IP</th></tr>
								</table>
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