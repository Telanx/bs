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
	}
	th{
		border:solid 1px #aaa;
		background:#ccc;
		text-align:center;
	}
	td{
		text-align:center;
		border:solid 1px #aaa;
		vertical-align:middle;
		height:40px;
	}
	.unread{
		color:#aaa;
	}
	.read{
		color:#f00;
	}
	table{
		width:100%;
	}
	.history a{
		text-decoration:underline;
	}
	.loghistory>span{
		cursor:pointer;
	}
	.loglist{
		display:none;
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
		//包含历史记录的展开，收缩
		//提交新纪录
		//修改,删除当天的记录
		//上传文件
		//提交
		/***学生提交进度报告***/
		function F(){
			var server = "<?php echo U('Student/Bs/manage_handler');?>";
			this.report=function(data,callback){
				$.post(server,data,function(r){
					callback(r);
				});
			}
		}
		var telanx = new F();
		var mask=$('.mask'),
			container=$('.container-popup'),
			title=$('.container-popup').find('.popup-title-text'),
			body=$('.container-popup>.popup-body');
		var popup=new pop(mask,container,title,body);
		//关闭弹出层
		$('.container-popup').find('.popup-title-close').bind('click',function(e){popup.hide();})
		$('.container-popup').on('click','.btn-cancel',function(e){e.preventDefault();popup.hide();});
		
		$('#report-submit').click(function(e){
				var report_s = $('#report').val();
				if(report_s.trim().length<=5){
					alert('请不要输入无效的字符！');
					return false;
				}
				
				var data = {type:'log',action:'add',ct:report_s};
				telanx.report(data,function(r){
					if(!r.status){
						alert('提交失败！'+r.msg);
					}
					else alert('提交成功!');
				});
		});
		
		/****删除报告*********/
		$('.history').on('click','.report-del',function(e){
			var del_node = e.target;
			var id = $(del_node).parent().parent().children(':eq(0)').text();
			var data = {type:'log',action:'del',id:id};
			telanx.report(data,function(r){
				alert(r.msg);
			});
		});
		
		/***修改报告**/
		$('.history').on('click','.report-modify',function(e){
			//弹出层处理
			var id = $(e.target).parent().parent().children(':eq(0)').text();
			popup.setCss({'width':'600px','height':'400px'}).setBodyCss({'width':'600px','height':'380px'}).setTitle('修改日志').setBody("<iframe width=100% height=100% src=<?php echo U('Student/Bs/modify_log');?>?id="+id+"></iframe>").show();
		});
		/**显示或隐藏日志***/
		$('.loghistory>span').click(function(e){
			var icon_n = $(e.target);
			if(icon_n.hasClass('icon-plus-square-o')){
				//收缩->展开
				console.log('有');
				icon_n.removeClass('icon-plus-square-o').addClass('icon-minus-square-o');
				$('.loglist').slideDown();
			}else if(icon_n.hasClass('icon-minus-square-o')){
				//展开->收缩
				icon_n.removeClass('icon-minus-square-o').addClass('icon-plus-square-o');
				$('.loglist').slideUp();
			}
		});
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
					<div class='user-img'><img src='<?php echo ($user[pic]?$user[pic]:"https://ss1&#46;baidu&#46;com/6ONXsjip0QIZ8tyhnq/it/u=801265354,741403095&fm=58"); ?>' class='img-border radius-circle' width=100 height=100></div>
					<div class='user-name'><p class='text-center'><?php echo ($user["name"]); ?></p></div>
				</div>
				<div class='line menu'>
						<dl class='mainmenu start link'>
							<a href="<?php echo U('Student/Index/index');?>"><span class='icon-logo icon-home text-big'></span>开始</a>
						</dl>
						<dl class='mainmenu user'>
							<dt><span class='icon-logo icon-user text-big'></span>个人中心</dt>
								<dd class='link'><a href="<?php echo U('Student/User/view');?>">查看资料</a></dd>
								<dd class='link'><a href="<?php echo U('Student/User/edit');?>">修改资料</a></dd>
								
							
						</dl>
						
						<dl class='mainmenu bs'>
							<dt><span class='icon-logo icon-mortar-board text-big'></span>毕业设计</dt>
							
								<dd class='link'><a href="<?php echo U('Student/Bs/xt');?>">选题</a></dd>
								<dd class='link selected'><a href="#">毕设管理</a>	</dd>				
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
					<div class='right-head'>
						<h2>毕设设计</h2>
					</div>
					<div class='right-body'>
					
					<div class="panel">
							<div class="panel-head"><h4>毕设进度报告</h4></div>
							
							<div class="panel-body">
									
									<div class='add'>
										<div class='line'>
											<div class='x8'>
											<textarea id='report' class='input' rows="5" placeholder='简要介绍当前进度'></textarea>
											</div>
											<div class='x4'>
												<p>说明：报告时间无法更改。报告内容当天可以修改，逾期无法修改！</p>
												<button id='report-submit' class='button bg-main addLog'>保存发布</button>
											</div>
										</div>
										
										
									</div>
									
									<div class='history'>
										<div class='head loghistory'><span class='icon-plus-square-o'>历史报告记录</span></div>
										<div class='body loglist'>
											<table>
												<th>序号</th><th>时间</th><th>内容</th><th>操作</th>
												<?php if(is_array($logList)): $i = 0; $__LIST__ = $logList;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$log): $mod = ($i % 2 );++$i;?><tr><td width=10%><?php echo ($log["id"]); ?></td><td class='time' width=20%><?php echo ($log["time"]); ?></td><td width=50%><?php echo ($log["ct"]); ?></td><td class='op' width=20%></td></tr><?php endforeach; endif; else: echo "" ;endif; ?>
											</table>
											
										</div>
										
											
									</div>
									
									
								
							</div>
						</div>
						
						<!---<div class="panel">
							
							<div class="panel-head"><h4>中期检查</h4></div>
							<div class="panel-body">
							<p>说明:包含外文翻译，文献综述以及开题报告压缩后上传，仅支持.zip以及.rar格式</p>
								<table>
									<th>文件</th><th>教师指导意见</th><th>备注</th>
									<tr>
										<td width='30%'>还未提交<button class='button border-sub'>立即上传</button></td><td  class='unread' width='50%'>指导老师还未评阅~</td><td  width='20%'>无</td>
									</tr>
								</table>
								
							</div>
						</div>
						
						
						<div class="panel">
							<div class="panel-head"><h4>毕设论文</h4></div>
							<div class="panel-body">
								<table>
									<th>文件</th><th>教师指导意见</th><th>备注</th>
									<tr>
										<td width='30%'>还未提交<button class='button border-sub'>立即上传</button></td><td class='unread'  width='50%'>指导老师还未评阅~</td><td  width='20%'>无</td>
									</tr>
								</table>
							</div>
						</div>
						---->
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

 <script> 
$(function(){
	var d= $('.history tr');
	for(var i=1;i<d.length;i++){
		(function(d,i){
			var dt = $(d[i]).children(':eq(1)').text();
			console.log('---'+dt);
			console.log(((new Date()).getTime()-(new Date(dt)).getTime())/3600000);
			if(((new Date()).getTime()-(new Date(dt)).getTime())/3600000<24){
				$(d[i]).children(':eq(3)').html('<a href=# class="report-modify">修改</a>|<a href=# class="report-del">删除</a>');
			}else{
				$(d[i]).children(':eq(3)').html('无');
			}
			}
		)(d,i);
	}
});
 </script>
  
</body>
</html>