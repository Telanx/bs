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
    .view{
		text-decoration:underline;
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
	
	//请求管理
	var mask=$('.mask'),
	container=$('.container-popup'),
	title=$('.container-popup').find('.popup-title-text'),
	body=$('.container-popup>.popup-body');
	var popup=new pop(mask,container,title,body);
	//关闭弹出层
	$('.container-popup').find('.popup-title-close').bind('click',function(e){popup.hide();})
	$('.container-popup').on('click','.btn-cancel',function(e){e.preventDefault();popup.hide();});
  var ttypeMapping = {
				'1':'普通教师',
				'2':'系主任',
				'3':'院长'
			};  
	//从后台获取管理员结果
	function search_admin(key,dep,p,callback){
			$.post("<?php echo U('Admin/User/teacher_handler');?>",{type:'search',key:key,dep:dep,p:p},callback);
		}
	function R_H(k,c,p){
		//清空
		$('.search-result-table tbody>:not(.th)').remove();
		search_admin(k,c,p,function(res){
			var rl = res.r?res.r.length:0;
			var p_c = res.page.current,p_t=res.page.total;
			var r = res.r;
			
			for(var i=0;i<rl;i++){
					$('.search-result-table').append("<tr><td><button class='button border-dot btn-user-del'>删除</button><button class='button border-sub btn-user-edit'>修改</button></td><td><a href=# class='view'>"+r[i].user+'</a></td><td>'+(r[i].name||'-')+'</td><td>'+ttypeMapping[(r[i].type||'1')]+'</td><td>'+(r[i].status||'-')+'</td><td>'+(r[i].dep||'-')+'</td></tr>');
			}
			//显示或者隐藏分页
			page({current:p_c,total:p_t},{page_prev:$('.btn-page-prev'),page_next:$('.btn-page-next'),page_num:$('.page-num')});
			if(rl==0){
				$('.search-result-table').append('<tr><td colspan=5>无任何相关结果。<td></tr>');
				$('.page').hide();
			}else $('.page').show();
		});
	}
		
		$('form').submit(function(e){
			e.preventDefault();
			R_H($(e.target).find('input').val(),$('#dep-list').val(),1);
		});
		//查看用户资料
        $('.search-result-table').on('click','.view',function(e){
            var btn_node =$(e.target);
            var user = btn_node.text();
			
            $.post("<?php echo U('Admin/User/teacher_handler');?>",{type:'view',user:user},function(r){
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
                        <tr><td>工号：</td><td>'+r.user+'</td></tr>\
                        <tr><td>姓名：</td><td>'+(r.name||'-')+'</td></tr>\
                        <tr><td>所属部门：</td><td>'+(r.dep||'-')+'</td></tr>\
												<tr><td>账号类型:</td><td>'+ttypeMapping[(r.type||'1')]+'</td></tr>\
                        <tr><td>状态：</td><td>'+(r.status||'-')+'</td></tr>\
                        <tr><td>带毕设次数：</td><td>'+(r.bsnum||'-')+'</td></tr>\
                            </table>\
                    </div>\
        </div>\
                <div class="contact">\
                    <div class="qqmail">\
                        <p><span class="icon-qq text-big">QQ：</span>'+(r.qq||'-')+'\
                        <span class="icon-envelope text-big">邮箱：</span>'+(r.mail||'-')+'</p>\
                    </div>\
                    <div class="phone">\
                       <p> <span class="icon-mobile-phone text-big">手机号：</span>'+(r.cellphone||'-')+'\
                        <span class="icon-phone text-big">办公电话：</span>'+(r.officephone||'-')+'</p>\
                    </div>\
        </div>\
        </div>';
        popup.setBody(user_info_html).setTitle('个人详细信息').setCss({width:'520px',height:'420px'}).show();
            });
        })
		//删除用户
		$('.search-result-table').on('click','.btn-user-del',function(e){
			e.preventDefault();
			var user = $(e.target).parent().next().text();
			popup.setTitle('删除链接').setCss({width:'250px',height:'120px'});
			popup.setBody('<p>确定要删除"'+user+'"吗？</p><div style="text-align:center"><button class="button border-black link-del-yes" data-id='+user+'>确定</button><button class="button border-black btn-cancel">取消</button></div>');
			popup.show();
		})
		
		//修改用户
		$('.search-result-table').on('click','.btn-user-edit',function(e){
            e.preventDefault();
			var user = $(e.target).parent().next().text();
			
			var link_edit_html ="<iframe style='width:100%;height:100%' src=<?php echo U('Admin/User/teacher_edit');?>?user="+user+"></iframe>";
			popup.setTitle('修改资料').setCss({marginTop:'50px',width:'530px',height:'450px'}).setBodyCss({height:'100%'}).setBody(link_edit_html).show();
            
		});
		
		//确认删除
		$('.container-popup').on('click','.link-del-yes',function(e){
			var btn_del = $(e.target);
			var user=btn_del.attr('data-id');
			$.post("<?php echo U('Admin/User/teacher_handler');?>",{type:'del',user:user},function(r){
				popup.append('<p class=text-center>'+r.msg+'</p>');
					if(r.status==1){
						setTimeout(function(){popup.hide();location.reload();},2000);
					}
			});
		})
		
		//初始化加载部门配置数据
		var dep_list =<?php echo ($dep["v"]); ?>;
		(function(l,dom){$.each(l,function(i,e){dom.append('<option value='+e+'>'+e+'</option>');})})(dep_list,$('#dep-list'));
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
				if(c==1)return false;
				R_H($('.right-search').find('input').val(),$('#dep-list').val(),c-1);
			})
			r.click(function(){
				var pageNum = $('.page-num').text().split('/');
				var c=parseInt(pageNum[0]),t=parseInt(pageNum[1]);
				var g = $('.input-page-go').val();
				if(c==t)return false;
				R_H($('.right-search').find('input').val(),$('#dep-list').val(),c+1);
			})
			g.click(function(){
				var pageNum = $('.page-num').text().split('/');
				var c=parseInt(pageNum[0]),t=parseInt(pageNum[1]);
				
				var g = parseInt($('.input-page-num').val());
				console.log(c,t,g);
				if(!(g<=t&&g>=1&&g)){
					alert('请输入合理的翻页！');
					
					//return false;
				}else
				R_H($('.right-search').find('input').val(),$('#dep-list').val(),g);
				
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
						<h2>教师账号管理</h2>
					</div>
					<div class='right-body'>
						<!---搜索区域--->
						<div class='right-search'>
						<form style='max-width:500px;margin:30px auto;'>
							
								<input class='input' style='float:left;width:60%;border-radius:0px' placeholder="请输入姓名关键字或教工号">
								<select id='dep-list' style='width:80px;float:left;border-radius:0px' class='input border-main text-main'>
									<option value=0>全部</option>
								</select>
								<button type='submit' class='button bg-main' style='margin-left:10px' >搜索</button>
							
							
						</form>
						</div>
						<!--结果区域--->
						<div class='right-result'>
							<div class='right-result-head'><h4>全部结果:</h4>(Tips:点击账号即可查看用户基本)</div>
							<div class='right-result-body'>
								<table class="table table-hover search-result-table"><tr class='th'><th>操作</th><th>账号</th><th>姓名</th><th>类型</th><th>状态</th><th>所属研究所</th></tr>
								</table>
                                <!---start-->
                
                                <!---end---->
                                <!---分页组件-->
								<div class='right-result-pagination page' style='float:right;padding-right:100px;margin:15px 0 10px 0;display:none;'>
									<span>
										<button class='button border-main btn-page-prev'><i class='icon-caret-left text-big'></i></button>
										<span class='page-num text-big'>1/1</span>
										<button class='button border-main btn-page-next'><i class='icon-caret-right text-big'></i></button>
										<input type="text" class="input input-auto input-page-num" name="keywords" size="5" placeholder="页数">
										<button class='button bg-main btn-page-go'>转到</button>
									</span>
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