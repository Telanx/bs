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
	<link rel="stylesheet" href="/bs/Public/css/jquery.datetimepicker.css">
	<style type='text/css'>
	.box li{
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
	
	.info .bd{
		color:rgb(68,181,73);
	}
	</style>
    <script src="/bs/Public/lib/pintuer/jquery.js"></script>
    <script src="/bs/Public/lib/pintuer/pintuer.js"></script>
	<script src="/bs/Public/js/jquery.datetimepicker.js"></script>
	<script src="/bs/Public/js/menu.js"></script>
	<!----IE9以下增加media query-->
    <!--[if lt IE 9]>
	<script src="/bs/Public/lib/pintuer/respond.js"></script>
	<![endif]-->
    <script>
$(function(){
		Array.prototype.remove=function(e){
			var arr = this;
			for(var i=0;i<arr.length;i++){
				if(arr[i]==e)arr.splice(i,1);
			}
			return arr;
		}
		;(function(){
			var year = 2015;//备份年份
			var bL = ['bs_kt','bs_student_log','bs_xt','user_student','user_teacher']; //备份列表
			var bdL =<?php echo ($backup["bdL"]); ?>;//从备份记录中读取的已经备份数据的列表，未备份的也要从历史数据中删除以确保中断备份也可以
			var wL = ['bs_kt','bs_student_log','bs_xt','user_student'];	//数据清空列表，即便清空了也要再清空一边
			$('.total').html(bL.length);
			var bfb = (100*bdL.length/bL.length).toFixed(2)+'%';
			$('.backed').html(bdL.length);
			$('.progress-bar').css('width',bfb).html('进度'+bfb);
			for(var i=0;i<bdL.length;i++){
				bL.remove(bdL[i]);
				$('.backup').append('<p class=bd>已经备份'+bdL[i]+'表</p>');
			}
			
			
			
			$('#btn-init').click(function(e){
				//进行初始化操作
				$('.progress').addClass('active');
				var tb_index=0;
				var server  = "<?php echo U('Admin/Sys/init_handler');?>";
				var queue = {"backup":bL,"wipe":wL}
				SR(queue,['backup','wipe'],0,0);
			});
		})();
		function SR(s,k,i,j){
			if(k[i]=='backup'&&s[k[i]][j]){
				$('.backup').append('<br>正在备份表'+s[k[i]][j]+'.........');
				data = {type:'backup',tb:s[k[i]][j]};
			}else if(k[i]=='wipe'&&s[k[i]][j]){
				$('.wipe').append('<br>正在初始化表'+s[k[i]][j]+'.........');
				data = {type:'wipe',tb:s[k[i]][j]};
			}else{
				i++;
				SR(s,k,i,j);
				return false;
			}
		$.post("<?php echo U('Admin/Sys/init_handler');?>",data,function(r){
			if(k[i]=='backup'){
				//if(r.status)
				$('.backup').append(r.msg);
				var total = parseInt($('.total').html());
				
				var bfb = (100*(j+1)/s[k[i]].length).toFixed(2)+'%';
				$('.progress-bar').css('width',bfb).html('进度'+bfb);
			}else if(k[i]=='wipe'){
				//if(r.status)
				$('.wipe').append(r.msg)
			}
			
			if(s[k[i]][j+1]){
				j++;
			}else if(s[k[i+1]]){
				j=0;
				i++;
			}else{
				j++;
			}
		console.log(i,j);
		if(s[k[i]][j])setTimeout(function(){SR(s,k,i,j)},1000);
		else $('.info').append('所有操作完成！');
		});
		
		}
		//console.log('正在执行'+k[i]+'---'+s[k[i]][j]);
		//console.log(i,j);
		
		
	
});
	
	function sR(server,data,bL){
		$.post(server,data,function(r){
			$('.info').append('<p class=bd>备份成功！</p>');
			if(bL.length){
				var bTable = bL[0];
				$('.info').append('<p>正在备份'+bTable+'表</p>');
				sR(server,data,bL);
				}
			//执行完毕
		});
	}
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
					<h3 class='doc-h3'>系统初始化设置</h3>
					<!---选题时间--->
					<div class='panel'>
						<div class='panel-head'>初始化</div>
						<div class='panel-body'>
							<p><?php echo ($backup["info"]["msg"]); ?><button id='btn-init' class='button bg-main'>开始</button></p>
							<!---检测是否备份过-->
							
							<!---如果是第一次使用，则无需初始化。点击初始化开始<button class='button bg-main'>初始化</button>--->
							
						<p><strong>第一步：备份数据，一共需备份<span class='total'></span>张表，已备份<span class='backed'></span>/<span class='total'></span>张</strong></p>
						<div class="progress progress-striped">
							<div class="progress-bar bg-sub">进度：22%</div>
						</div>
							<div class='backup'>

							</div>
						<p><strong>第二步：数据初始化</strong></p>
							<div class='wipe'></div>
						
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


<!----
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
	});
	//取消操作
	$('.container-popup').on('click','.btn-cancel',function(){popup.hide();});
	//时间插件
	(function($){
		$('#time_xt_end').datetimepicker({
			lang:'ch',
			startDate:'+1971/05/01'//or 1986/12/08
		});
		$('#time_xt_start').datetimepicker({
			lang:'ch',
			startDate:'+1971/05/01'//or 1986/12/08
		});
	})(jQuery);
	//保存
	(function(){
		$('.btn-save-xt').click(function(){
			var error=[];
			var data=[];
			var dT=[];
			//验证合法性
			$.each(['xt_start','xt_end'],function(i,e){
				var xt_v = $('#time_'+e).val();
				var xt_u = (new Date(xt_v)).getTime();
				dT.push(xt_u);
				var s='';
				if(i==0)s='开始';
				else if(i==1)s='截止';
				if(isNaN(xt_u))error.push(s+'日期不合法');
				data.push({k:e,v:xt_v});
			});
			console.log(dT);
			if(dT[0]>dT[1])error.push('截止日期必须大于开始日期！');
				
			if(error.length){
				popup.setTitle('提示').setBody('<p>'+error.join('')+'</p>').show();
				return false;
			}
			var f=$('input[name=tonews]:checked').length?1:0;
			$.post("<?php echo U('Admin/Sys/time_handler');?>",{type:'save',f:f,data:data},function(r){
				popup.setTitle('操作结果').setBody('<p class=text-center>'+r.msg+'</p>').show();
				if(r.status==1){setTimeout(function(){
					popup.hide();
					location.reload();
				},2000);}
			});
		})
	})();
	})
	</script>
	--->