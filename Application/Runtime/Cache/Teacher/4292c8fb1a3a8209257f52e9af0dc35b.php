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
	td a{
		text-decoration:underline;
	}
	.highlight{
		background:rgb(156,235,180);
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
	
	/***相关链接处理***/
		$('.container-popup').find('.popup-title-close').bind('click',function(e){
			popup.hide();
		})
		$('.container-popup').on('click','.btn-cancel',function(){popup.hide();})
		
	var mask=$('.mask'),
	container=$('.container-popup'),
	title=$('.container-popup').find('.popup-title-text'),
	body=$('.container-popup>.popup-body');
	var popup=new pop(mask,container,title,body);
	//查看学生基本信息
	$('.viewuser').click(function(e){
		var user=$(e.target).attr('data-id');
		$.post("<?php echo U('Teacher/Bs/student_handler');?>",{type:'view',user:user},function(r){
                if(!r.length){alert('查看用户详细信息失败！');return false;}
                //显示用户基本信息
                r=r[0];
                var user_info_html =
                '<div class="user_info" style="width:400px;margin:20px auto">\
                <div class="info-left">\
                    <div class="pic" style="float:left;width:195px;height:195px">\
                        <img width="160px" height="195px"\ src="'+(r.pic||'https://ss1.baidu.com/6ONXsjip0QIZ8tyhnq/it/u=801265354,741403095&fm=58')+'"></div>\
                    <div class="info_right">\
                        <table style="line-height:40px">\
                        <tr><td>学号号：</td><td>'+r.user+'</td></tr>\
                        <tr><td>姓名：</td><td>'+(r.name||'-')+'</td></tr>\
                        <tr><td>班级：</td><td>'+(r.class||'-')+'</td></tr>\
                        <tr><td>状态：</td><td>'+(r.status||'-')+'</td></tr>\
                        <tr><td>手机：</td><td>'+(r.cellphone||'-')+'</td></tr>\
                            </table>\
                    </div>\
        </div>\
                <div class="contact">\
                    <div class="qqmail">\
                        <p><span class="icon-qq text-big">QQ：</span>'+(r.qq||'-')+'\
                        <span class="icon-envelope text-big">邮箱：</span>'+(r.email||'-')+'</p>\
                    </div>\
        </div>\
        </div>';
        popup.setBody(user_info_html).setTitle('个人详细信息').setCss({marginTop:'150px',width:'520px',height:'420px'}).show();
            });
	})
	//查看任务书和报审表
	$('.view').on('click',function(e){
		var url='';
		var bid=$(this).attr('data-bid');
		var sid = $(this).attr('data-sid');
		if($(e.target).hasClass('viewrw'))url="<?php echo U('Home/Bs/viewrw');?>?bid="+bid+"&sid="+sid;
		else if($(e.target).hasClass('viewkt'))url="<?php echo U('Home/Bs/viewkt');?>?bid="+bid;
		if(url!='')window.open(url);
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
					<div class="tab border-main">
					<div class="tab-head">
					<strong>选题查询</strong>
					
					<ul class="tab-nav">
					<li class='active'><a href="#">选题情况</a></li>
					
					
					</ul>
					</div>
					<div class="tab-body">
					<div class="tab-panel active">
					<!---显示课题审核情况-->
					<div class="alert alert-yellow"><span class="close rotate-hover"></span><strong>提示：</strong>点击学生学号查看所选学生信息！</div>
					<table class='table table-hover'>
						<tr><th>课题名称</th><th>审核状态</th><th>选题学生</th><th>学号</th><th>选题时间</th><th>查看报表</th></tr>
						<?php if(is_array($xt)): $i = 0; $__LIST__ = $xt;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$xt): $mod = ($i % 2 );++$i;?><tr class=<?php echo ($xt['sname']?'highlight':''); ?>><td><?php echo ($xt["name"]); ?></td><td>
							
						<?php if(($xt['status'] > 1)): if(($xt['status'] > 2)): ?><font color=green>已通过院审核</font>
							<?php else: ?>
								<font color=blue>已通过系审核</font><?php endif; ?>
						<?php else: ?> <font color=red>待审核</font><?php endif; ?>
						
							</td><td><a href=# class='viewuser' data-id=<?php echo ($xt["user"]); ?>><?php echo ($xt["sname"]); ?></a></td><td><?php echo ($xt["user"]); ?></td><td><?php echo ($xt["time"]); ?></td><td class='view' data-bid="<?php echo ($xt["bid"]); ?>" data-sid="<?php echo ($xt["user"]); ?>"><a href=# class='viewrw'>任务书</a>|<a href=# class='viewkt'>报审表</a></td></tr><?php endforeach; endif; else: echo "" ;endif; ?>
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