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
		
		//取消操作
		$('.container-popup').on('click','.btn-cancel',function(){popup.hide();})
        
        
        //添加时间规划
        $('.time-add').click(function(){
            var tr_time_html = "<tr><td>ID</td><td><input type='text' class='input' placeholder='格式01-01'></td>"+
            "<td><input type='text' class='input' placeholder='输入内容'></td>"+
            "<td><button class='button button-small bg-main time-add-save'>保存</button><button class='button button-small bg-dot time-add-del'>删除</button></td>"+
        "</tr>";
            $(this).parent().parent().before(tr_time_html);
        });
        //添加删除
        $('.time').on('click','.time-add-del',function(e){
            $(e.target).parent().parent().remove();
        });
        //添加保存
        $('.time').on('click','.time-add-save',function(e){
            var btn_save = $(e.target);
            var tt = btn_save.parent().prev().prev().children().val();
            var ct = btn_save.parent().prev().children().val();
            if(!(tt.trim()==''||ct.trim()=='')){
                $.post("<?php echo U('Admin/Index/plan_handler');?>",{type:'add',content:ct.trim(),ttime:tt.trim()},function(r){
                    popup.setBody('<p class=text-center>'+r.msg+'</p>').show();
                    if(r.status==1){
                        //成功则自动消失
                        setTimeout(function(){popup.hide();location.reload();},1000);
                    }
                });
            }else{
                alert('时间以及内容不能为空！');
            }
        });
		//更新
		$('.time-update').click(function(e){
			var btn_update = $(e.target);
			var tt = btn_update.parent().prev().prev().children().val();
			var ct = btn_update.parent().prev().children().val();
			var id=btn_update.attr('data-id');
			if(!(tt.trim()==''||ct.trim()=='')){
                $.post("<?php echo U('Admin/Index/plan_handler');?>",{type:'update',id:id,content:ct.trim(),ttime:tt.trim()},function(r){
                    popup.setBody('<p class=text-center>'+r.msg+'</p>').show();
                    if(r.status==1){
                        //成功则自动消失
                        setTimeout(function(){popup.hide();location.reload();},1000);
                    }
                });
            }else{
                alert('时间以及内容不能为空！');
            }
		})
		//删除
		$('.time-del').click(function(e){
			var id=$(e.target).attr('data-id');
			if(confirm('确认删除第'+id+'条规划？')){
				$.post("<?php echo U('Admin/Index/plan_handler');?>",{type:'del',id:id},function(r){
					popup.setBody('<p class=text-center>'+r.msg+'</p>').show();
					if(r.status==1){
						setTimeout(function(){popup.hide();location.reload();},1000);
					}
				})
			}
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
				<!---图片轮播、时间安排、最新动态、资料下载、链接管理--->
					<div style='height:20px'></div>
					<div class="tab border-main">
					<div class="tab-head">
					<strong>前台设置</strong>
					
					<ul class="tab-nav">
					
					<li class='active'><a href="#">时间规划</a></li>
					<li><a href="<?php echo U('Admin/Index/news');?>">动态新闻</a></li>
					<li><a href="<?php echo U('Admin/Index/doc');?>">相关资料</a></li>
					<li><a href="<?php echo U('Admin/Index/link');?>">相关链接</a></li>
					</ul>
					</div>
					<div class="tab-body">
					<div class="tab-panel" id="tab-link" style="display:block">
					<!--相关链接-->
						<div class='line time'>
							<div class='x7'>
							<table class="table table-striped">
								<tr><th>ID</th><th>时间</th><th>计划</th><th>操作</th></tr>
								<?php if(is_array($plan)): $i = 0; $__LIST__ = $plan;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$time): $mod = ($i % 2 );++$i;?><tr>
									<td><?php echo ++$i/2;?></td>
                                    <td><input type='text' class='input input-auto' size=15 value='<?php echo ($time["ttime"]); ?>'></td>
                                    <td><input type='text' class='input' value='<?php echo ($time["content"]); ?>'></td>
                                    <td><button class='button button-small border-main time-update' data-id="<?php echo ($time["id"]); ?>">更新</button><button class='button button-small border-sub time-del' data-id="<?php echo ($time["id"]); ?>">删除</button></td>                                   </tr><?php endforeach; endif; else: echo "" ;endif; ?>
								<!---新添加--->
								<tr class='tr-time-add'><td colspan="2"><button class='button border-main button-block time-add'>新增</button></td><td></td></tr>
							</table>
							</div>
							<div class='x1'></div>
							<!---在线预览-->
							<div class='x3'>
									<div class="panel">
									<div class="panel-head bg-main">预览</div>
										<div class="panel-body">
										<marquee id="affiche" align="left" behavior="scroll" direction="up" height="170" width="100%" hspace="50" vspace="20" loop="-1" scrollamount="10" scrolldelay="200" onmouseout="this.start()" onmouseover="this.stop()">
											<?php if(is_array($plan)): $i = 0; $__LIST__ = $plan;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$time): $mod = ($i % 2 );++$i;?><p><?php echo ($time["ttime"]); ?>&nbsp;&nbsp;&nbsp;&nbsp;<font color=#3af><?php echo ($time["content"]); ?></font></p><?php endforeach; endif; else: echo "" ;endif; ?>
										</marquee>
										</div>
									</div>
								
							</div>
							
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