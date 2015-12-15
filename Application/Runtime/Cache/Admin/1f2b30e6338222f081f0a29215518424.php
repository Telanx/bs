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
    
	.tab_nav:not(.tab_selected):hover{
		border-bottom:4px solid #aaa;
	}
	.tab_selected{
		border-bottom:4px solid rgb(68,181,73);
	}
	.viewkt,.viewls{
		text-decoration:underline;
	}
	.table button{
		display:<?php echo ($xtTimeCheck>0?'':'none'); ?>
	}
	
	.contextmenu{
		position:fixed;
		display:none;
		z-index:0;
		width:250px;
		background:#fff;
		border:solid 1px #aaa;
		color:#000;
		box-shadow:1px 1px 1px #aaa;
	}
	.contextmenu ul{
		padding-left:0;
	}
	.contextmenu li{
		list-style:none;
		padding-left:15px;
		line-height:30px;
		
	}
	.contextmenu li:hover{
		cursor:pointer;
		color:#fff;
		background:rgb(66,129,244);
	}
	.contextmenu .disabled{
		color:#aaa;
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
		var url ="<?php echo U('Admin/Bs/kt_handler');?>";
		$.post(url,{t:t,k:k,d:d,p:p},function(res){
			$('.search-result-table tbody>:not(.th)').remove();//清空数据
			var rl = res.r.length;
			var p_c = res.page.c_p,
			p_t = res.page.t_p,
			r = res.r;
			for(var i=0;i<rl;i++){
					
					$('.search-result-table').append("<tr><td><a href=# class='viewkt' data-id="+r[i].id+">"+r[i].bname+'</a></td><td><a href=# class="viewls" data-id='+r[i].tuser+'>'+r[i].tname+'</a></td><td>'+(r[i].dep||'-')+'</td><td><a href=# data-id='+r[i].suser+'>'+(r[i].sname||'无')+'</a></td></tr>');
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


	//查看课题信息
	$('.right-result-body').on('click','.viewkt',function(e){
		var ktid = $(e.target).attr('data-id');
		window.open("<?php echo U('Student/Bs/kt_info');?>?id="+ktid);
	});
	//查看教师信息
	$('.right-result-body').on('click','.viewls',function(e){
		var lsid = $(e.target).attr('data-id');
		$.post("<?php echo U('Admin/User/teacher_handler');?>",{type:'view',user:lsid},function(r){
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

	});
	
	//初始化加载部门配置数据
	//加载下拉列表
		(function(l){
			for(var i=0;i<l.length;i++){
				var d=$('select[name='+l[i]+']');
				//闭包解决
				(function(d){
				$.getJSON("<?php echo U('Home/Bs/getSel');?>?k="+l[i],function(r){
					var ls = JSON.parse(r.v.replace(/'/g,'"'));
					$.each(ls,function(i,e){
							d.append("<option>"+e+"</option>");		
					})
				})
				})(d);
			}
		})(['dep']);
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
		
		window.f = {};
		var menuExt = {
			init:function(func){
				$("table").on("contextmenu","tr:not(.th)",function(e){
					var i = $(this).index();
					
					var trDom = $("table tr:eq("+i+")");
					var ktId = trDom.children(":eq(0)").children().attr("data-id"),		//课题Id
						ktName = trDom.children(":eq(0)").text(),												//课题名
						tId = trDom.children(":eq(1)").children().attr("data-id"),									//教师Id
						tName = trDom.children(":eq(1)").text(),												//教师名
						dep = trDom.children(":eq(2)").text().trim(),										//单位名
						sId = trDom.children(":eq(3)").children().attr("data-id"),									//课题学生Id
						sName = trDom.children(":eq(3)").text().trim();									//学生名
					if(ktId==undefined){
						return true;
					}
					e.preventDefault();
					$(".contextmenu").html("");
					var menuObj = func({ktId:ktId,ktName:ktName,tId:tId,tName:tName,dep:dep,sId:sId,sName:sName});
					var menuHtml = $("<ul></ul>");
					for(var i in menuObj.menus){
						
						var n = menuObj.menus[i];
						(function(m){
							
							if(m.sepline){
								menuHtml.append("<hr>");
							}else{
								menuHtml.append("<li class='"+m.id+" "+(m.disable?"disabled":"")+"'>"+m.text+"</li>");
								if(f[m.id]==undefined)f[m.id]=true;			//注册事件
								if(!m.disable && f[m.id]){
									f[m.id]=false;
									console.log("监听事件");
									$(".contextmenu").one("click","."+m.id,function(){m.fn();f[m.id] = null;console.log("移除事件");});
								}
							}
							if(i==menuObj.menus.length-1){
								console.log(menuHtml.html());
								$(".contextmenu").append("<ul>"+menuHtml.html()+"</ul>").css({top:e.clientY,left:e.clientX}).show();
								
							}
							
						})(n);
					}
					
				});
				
				document.onclick=function(e){
				
					if (!e) var e = window.event;
					if (e.srcElement) {
						var a = e.srcElement.getAttribute("class")
					} else {
						var a = e.target.getAttribute("class")
					}
					if(a==undefined)return true;
					if (a != "contextmenu" && a.indexOf("disabled")==-1) {
						
						$(".contextmenu").hide();
					}
				}
				
			}
		};
		//创建右键菜单
		menuExt.init(function(obj){
			/**obj说明是点击时传递过来的参数
			*{
				ktId:2,
				ktName:'课题内容',
				tId:'2015001',
				tName:'王多强',
				dep:'计算所',
				sId:'U201114175',		//没有的时候为null
				sName:'叶明灵'			//没有的时候为'无'
			}
			*/
			console.log(obj);
			var menuObj = {
				menus:[
					{
						id:'printAll',				//id要唯一
						text:'查看'+obj.ktName+'的任务书',		//菜单文字
						fn:function(){		
							window.open("<?php echo U('/Home/Bs/viewkt');?>?bid="+obj.ktId);
						}
					},{
					sepline:true				//分割线
					},{
						id:'viewAll',
						text:'查看选择的课题名',
						fn:function(){				//回调函数，即点击该菜单后执行事件，注意如果有设置disable属性为true则不执行
							alert("您选择的课题名是:"+obj.ktName);
						}
					},{
						id:'viewStudent',
						text:'批量打印'+obj.dep+'的报审表',	
						disable:(obj.sId=='null'?true:false),								//禁止点击，即点击无效果
						fn:function(){
							//某一项没有数据处理
							if(obj.sId!=undefined){
								//
							}else{
								alert("该课题没有学生选择，无法查看！");
							}
						}
					}
					
				]
			};
			return menuObj;
		});
		
		
		
		
		
		
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
					<div class='user-img'><img src='https://ss1&#46;baidu&#46;com/6ONXsjip0QIZ8tyhnq/it/u=801265354,741403095&fm=58' class='img-border radius-circle' width=100 height=100></div>
					<div class='user-name'><p class='text-center'><?php echo ($user); ?></p></div>
				</div>
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
			</div>
			<!---右侧具体内容-->
			<div class='x10 right'>
				<div class='line'>
					<div class='right-head'>
						<h2>课题查看</h2>
					</div>
					<div class='right-body'>
			
						<!---搜索区域--->
						
						<div class='right-search'>
						<form style='max-width:500px;margin:30px auto;'>
							
								<input class='input' style='float:left;width:60%;border-radius:0px' placeholder="请输入课题关键词搜索">
								<select id='dep-list' name='dep' style='width:80px;float:left;border-radius:0px' class='input border-main text-main'>
									<option value='0'>全部</option>
								</select>
								<button type='submit'  name='search' class='button bg-main' style='margin-left:10px' >搜索</button>
							
							
						</form>
						</div>
						<!--结果区域--->
						<div class='right-result'>
							<div class='right-result-head'></div>
							<div class='right-result-body'>
								<table class="table table-hover search-result-table"><tr class='th'><th>课题名</th><th>指导老师</th><th>所属研究所</th><th>选题学生</th></tr>
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

  <div class="contextmenu">
	</div>
  
</body>
</html>