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
	#dep{
		height:35px;
	}
	</style>
    <script src="/bs/Public/lib/pintuer/jquery.js"></script>
    <script src="/bs/Public/lib/pintuer/pintuer.js"></script>
	<script src="/bs/Public/js/jquery.form.js"></script>
	<!----IE9以下增加media query-->
    <!--[if lt IE 9]>
	<script src="/bs/Public/lib/pintuer/respond.js"></script>
	<![endif]-->
	<script type='text/javascript' src="/bs/Public/js/menu.js"></script>
    <script type='text/javascript'>
	$(function(){
	function List(){
		this.config=function(o){
			this.d = o.d;
			this.l = o.l;
		}
		this.init=function(){
			var l = this.l;
			var d = this.d;
			d.children().remove();
			for(var i=0;i<l.length;i++){
				d.append('<option value='+l[i]+'>'+l[i]+'</option>');
			}
		}
	}
	var mask=$('.mask'),
	container=$('.container-popup'),
	title=$('.container-popup').find('.popup-title-text'),
	body=$('.container-popup>.popup-body');
	var popup=pop(mask,container,title,body);
	
	//加载账号单位
	var cList =<?php echo ($class["v"]); ?>;
	var dList = <?php echo ($dep["v"]); ?>;
	var list = new List();
	list.config({d:$('#dep'),l:cList});
	list.init();
	
	
	//不同类型
	$('#user-type').on('change',function(e){
		var t = $('input[name=user-type]:checked').val();
		if(t==1)list.config({d:$('#dep'),l:cList});
		else if(t==2)list.config({d:$('#dep'),l:dList});
		else list.config({d:$('#dep'),l:['无']});
		list.init();
	})
	
	//循环发送的
	function add_record(url,data){
		var tmp = data[0];
		$.post(url,tmp,function(r){
				data.splice(0,1);
				if(data.length)add_record(url,data);
				popup.append('<p>'+tmp.user+'处理结果：'+r.msg+'</p>');
			});
	}
		/***相关链接处理***/
		$('.container-popup').find('.popup-title-close').bind('click',function(e){
			popup.hide();
		})
		//取消操作
		$('.container-popup').on('click','.btn-cancel',function(){popup.hide();})
        
        //手动添加用户
		$('.btn-user-add').click(function(e){
			e.preventDefault();
			var user_type=$('input[name=user-type]:checked').val();//类型
			var dep = $('#dep').val();//单位
			var user_list = $('textarea').val().split('\n');
			//启用匹配规则
			var reg_str='';
			switch(user_type){
				case '1':reg_str='^U\\d{9}$';break;//学号U2011xxxxx
				case '2':reg_str='^\\d{7}$';break;//7位教工号
				case '3':reg_str='^\[a-z]{4,6}$';break;//全部小写字母4~6位
				default:alert('非法类型');
			}
			var regexp=new RegExp(reg_str);
			var error_list=[];
			var check_list=[];
			for(var l=user_list.length-1;l>=0;l--){
				var user_a = user_list[l].split(/\s+/);

				var user_id = user_a[0];
				var user_name = user_a[1]||'';
				if(regexp.test(user_id))check_list.push({usertype:user_type,user:user_id,name:user_name,dep:dep});
				else error_list.push(user_id);
			}
			//console.log('等待添加的账号:');
			//console.log(check_list);
			//console.log('不符合要求的账号:');
			//console.log(error_list);
			
			popup.setTitle('提示').setBody('<p>格式不正确的账号:<br>'+error_list.join(';')+'</p><p>等待添加的账号有'+check_list.length+'个</p>').setCss({width:'300px',wordBreak:'break-word',maxHeight:'300px',overflowY:'scroll'}).show();
			if(check_list.length)
			add_record("<?php echo U('Admin/User/account_handler');?>",check_list);
		});
        
		$("#account-file").submit(function(){
			var file =$("input[name=file]").val();
			if(!file.match(/.txt$/)){
				alert("请先选择账号txt文件！");
				return false;
			}
			$(this).ajaxSubmit(function(r){
					popup.append(r.msg).show();
			});
			return false;
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
					<strong>新建用户</strong>
					
					<ul class="tab-nav">
					<li class="active"><a href="#tab-manual">手动添加</a></li>
					<li><a href="#tab-auto">文件导入</a></li>
					
					</ul>
					</div>
					<div class="tab-body">
					<div class="tab-panel active" id="tab-manual">
						<div class='line' style='margin:0px 0 20px 0'>
						<blockquote class="quote border-main doc-quotered">
							<strong>账号说明</strong>
							<li>学生账号为Uxxxxxxxxx</li>
							<li>教师账号为7位数字</li>
							<li>管理员账号为4~6位字母</li>
							格式按照：账号 姓名<br>
							<font class='text-dot'>账号必填，姓名选填,中间用空格隔开  每行一组数据！</font>
					</blockquote>
					</div>
					
						<form class='form-x'>
						
							<div class='form-group'>
								<div class='label'>选择账号类型：</div>
								<div class='field'>
									<div class="button-group radio" id='user-type'>
									<label class="button active"><input name="user-type" value="1" checked="checked" type="radio"><span class="icon icon-check"></span> 学生</label>
									<label class="button"><input name="user-type" value="2" type="radio"><span class="icon icon-check"></span> 教师</label>
									<label class="button"><input name="user-type" value="3" type="radio"><span class="icon icon-check"></span> 管理员</label>
									</div>
								</div>
							</div>
							<div class='form-group'>
								<div class='label'>班级(单位)：</div>
								<div class='field'>
									<select id='dep'>
									</select>
									</div>
								</div>
							
							<div class='form-group'>
								<div class='label'>输入账号：</div>
								<div class='field'>
									<textarea class="input" rows="5" cols="50" placeholder="账号   姓名(选填)"></textarea>
								</div>
							</div>
							
							<div class='form-group'>
								<div class='form-button'><button class='button bg-main btn-user-add'>确认</button>      <button type='reset' class='button bg-sub'>重置</button></div>
							</div>
						</form>
					
					</div>
					<div class="tab-panel" id="tab-auto">
						<div class='line' style='margin:0px 0 20px 0'>
							<blockquote class="quote border-main doc-quotered">
								<strong>文件导入说明</strong>
								<p>仅支持txt文件，txt文本内账号规则:账号;所属单位(班级);姓名</p>
								<p>用;分隔开,其中姓名和所属单位可选导入学生账号文本内示例:</p>
								<p>U201114175;计科2班;叶明灵</p>
								<p>U201114172;计科2班;</p>
								
								<p>所属单位必须包含在以下内，姓名选填</p>
								<font class='text-dot'>账号必填，姓名选填,中间用空格隔开  每行一组数据！</font>
							</blockquote>
						</div>
						<div class='line account-from-file-form'>
							<form id="account-file" class='form-x' action="<?php echo U('Admin/User/account_file');?>" method="POST" enctype="multipart/form-data">
								<div class='form-group'>
									<div class='label'>请选择账号类型</div>
									<div class='field'><select name='type'><option value=s>学生</option><option value=t> 教师</option></select></div>
								</div>
								<div class='form-group'>
									<div class='label'>请选择文件</div>
									<div class='field'><input type='file' name='file'></div>
								</div>
								<div class='form-group'>
									<div class="label"><button class='button bg-main' type="submit">确认</button></div>
								</div>
							</form>
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