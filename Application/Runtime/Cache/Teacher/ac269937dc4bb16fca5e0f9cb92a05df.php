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
	var mask=$('.mask'),
	container=$('.container-popup'),
	title=$('.container-popup').find('.popup-title-text'),
	body=$('.container-popup>.popup-body');
	var popup=new pop(mask,container,title,body);
		
		/***相关链接处理***/
		$('.container-popup').find('.popup-title-close').bind('click',function(e){
			popup.hide();
		})
		//添加链接
		$('#link-add').click(function(){
			console.log('点击了');
			var link_add_html='<div class=line><form class="form-x">'+
			'<div class="form-group"><div class="label"><label for="link-title">标题</label></div><div class="field"><input type="text" class="input" name="link-title" size="30" placeholder="网站标题"></div></div>'+
			'<div class="form-group"><div class="label"><label for="link-url">网址</label></div><div class="field"><input type="text" class="input" name="link-url" size="30" placeholder="网址"></div></div></form>'+
			'<div style="text-align:center"><button class="button border-black link-add-yes">确定</button><button class="button border-black btn-cancel">取消</button></div>'+
'</div>';
			popup.setTitle('添加新连接').setCss({width:'400px',height:'200px'});
			popup.setBody(link_add_html);
			
			popup.show();
		})
		//删除链接
		$('.link-del').click(function(e){
			e.preventDefault();
			popup.setTitle('删除链接').setCss({width:'250px',height:'100px'});
			popup.setBody('<p>确定要删除"'+$(this).parent().attr('data-title')+'"吗？</p><div style="text-align:center"><button class="button border-black link-del-yes" data-id='+$(this).parent().attr('data-id')+'>确定</button><button class="button border-black btn-cancel">取消</button></div>');
			popup.show();
		})
		//编辑链接
		$('.link-edit').click(function(e){
			e.preventDefault();
			var data = $(this).parent();
			var link_title = data.attr('data-title');
			var link_url = data.attr('data-link');
			var link_edit_html = '<div class=line><form class="form-x">'+
			'<div class="form-group"><div class="label"><label for="link-title">标题</label></div><div class="field"><input type="text" class="input" name="link-title" size="30" value='+link_title+'></div></div>'+
			'<div class="form-group"><div class="label"><label for="link-url">网址</label></div><div class="field"><input type="text" class="input" name="link-url" size="30" value='+link_url+'></div></div></form>'+
			'<div style="text-align:center"><button class="button border-black link-edit-yes" data-id="'+data.attr('data-id')+'">确定</button><button class="button border-black btn-cancel">取消</button></div>'+
'</div>';
			popup.setTitle('修改链接').setCss({width:'400px',height:'200px'});
			popup.setBody(link_edit_html);
			popup.show();
		})
		//确认添加
		$('.container-popup').on('click','.link-add-yes',function(e){
			var btn_add=$(e.target);
			var title = btn_add.parent().prev().find('input[name=link-title]').val();
			var url = btn_add.parent().prev().find('input[name=link-url]').val();
			if(title&&url){
				popup.setBody('请稍后...');
				$.post("<?php echo U('Admin/Index/link');?>",{type:'add',title:title,linkurl:url},function(r){
					popup.append('<p class=text-center>'+r.msg+'</p>');
					if(r.status==1){
						setTimeout(function(){popup.hide()},2000);
					}
				});
			}
			else alert('标题和网址不能为空！');
		});
		//确认删除
		$('.container-popup').on('click','.link-del-yes',function(e){
			var btn_edit = $(e.target);
			var id=btn_edit.attr('data-id');
			$.post("<?php echo U('Admin/Index/link');?>",{type:'del',id:id},function(r){
				popup.append('<p class=text-center>'+r.msg+'</p>');
					if(r.status==1){
						setTimeout(function(){popup.hide()},2000);
					}
			});
		})
		//确认修改
		$('.container-popup').on('click','.link-edit-yes',function(e){
			var btn_edit = $(e.target);
			var title = btn_edit.parent().prev().find('input[name=link-title]').val();
			var url = btn_edit.parent().prev().find('input[name=link-url]').val();
			var id=btn_edit.attr('data-id');
			console.log(title);
			if(!(title.trim()==''||url.trim()=='')){
				$.post("<?php echo U('Admin/Index/link');?>",{type:'edit',id:id,title:title,linkurl:url},function(r){
					popup.append('<p class=text-center>'+r.msg+'</p>');
					if(r.status==1){
						setTimeout(function(){popup.hide()},1000);
					}
				});
			}else{
				alert('标题和网址不能为空！');
			}
			
		})
		//取消操作
		$('.container-popup').on('click','.btn-cancel',function(){popup.hide();})
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
					<div class='user-name'><p class='text-center'><?php echo ($user["name"]); ?></p>
					<p class='text-center user-type'>
							<?php switch($ttype): case "1": ?>教师<?php break;?>
							<?php case "2": ?>系主任<?php break;?>
							<?php case "3": ?>院长<?php break;?>
							<?php default: ?>教师<?php endswitch;?>
						</p></div>
				</div>
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
				
				
			</div>
			<!---右侧具体内容-->
			<div class='x10 right'>
				<div class='line'>
				<!---选题情况--->
					<div style='height:20px'></div>
					<p><?php echo ($user["name"]); ?>您好！</p>
					<p>帮助说明页面</p>
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