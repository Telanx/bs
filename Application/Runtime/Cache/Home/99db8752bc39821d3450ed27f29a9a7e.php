<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html lang="zh-cn">
  <head>
    <title>毕业设计(论文管理系统)</title>
    <meta name="keywords" content="毕业设计" />
    <meta name="description" content="论文管理系统" />
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="viewport" content="width=device-width,initial-scale=1.0, maximum-scale=1.0,user-scalable=no">
    <link rel="stylesheet" href="/bs/Public/lib/pintuer/pintuer.css">
	<link rel="stylesheet" href="/bs/Public/css/index.css">
	<style type='text/css'>
		#nav-menu li{
			padding-top:12px;
			padding-left:10px;
			font-size:1.2em;
			height:50px;
			
		}
		#nav-menu .active{
			border-left:3px solid rgb(0,170,136);
		}
		.file-list-container{
			
			position:relative;
		}
		.grid{
				background:#eee;
				list-style:none;
				width:180px;
				position: absolute;
				border: solid 1px #ccc;
				padding: 10px; 
				left: 0px; top: 0; 
				box-shadow:0 2px 1px rgba(0,0,0,0.2);
				 -webkit-transition: all .7s ease-out .1s;
				 -moz-transition: all .7s ease-out;
				 -o-transition: all .7s ease-out .1s; 
				 transition: all .7s ease-out .1s ;
		}
		
	</style>
    <script src="/bs/Public/lib/pintuer/jquery.js"></script>
    <script src="/bs/Public/lib/pintuer/pintuer.js"></script>
    <!--[if lt IE 9]>
	<script src="/bs/Public/lib/pintuer/respond.js"></script>
	<![endif]-->
	
    <script type='text/javascript'>
	<!---瀑布流布局--->
	$(function(){
	function autoPlay(){
	var margin = 20;
	var li = $('.grid');
	var li_W = li[0].offsetWidth+margin;
	var h=[];//记录区块高度的数组
	var n = $('.file-list-container')[0].offsetWidth/li_W|0;//窗口的宽度除以区块宽度就是一行能放几个区块
	
	var x=0;
	var h_a=[];
	var k = n;
	while(k--){
		h_a.push(0);
		
	}
	console.log(h_a);
	for(var i = 0;i < li.length;i++){
		
		li_H = li[i].offsetHeight;//获取每个li的高度
		var pp = i%n;	//在第L列
		console.log(pp);
		h_a[pp] = h_a[pp]+li_H+20;
		console.log(h_a);
		if(i < n) {
			h[i]=li_H;//把每个li放到数组里面
			li.eq(i).css("top",0);//第一行的Li的top值为0
			li.eq(i).css("left",i * li_W);//第i个li的左坐标就是i*li的宽度
			}else{
			min_H =Math.min.apply(null,h) ;//取得数组中的最小值，区块中高度值最小的那个
			minKey = getarraykey(h, min_H);//最小的值对应的指针
			h[minKey] += li_H+margin ;//加上新高度后更新高度值
			li.eq(i).css("top",min_H+margin);//先得到高度最小的Li，然后把接下来的li放到它的下面
			li.eq(i).css("left",minKey * li_W);	//第i个li的左坐标就是i*li的宽度
		}
	}
	//最大高度Math.max.apply(null,h_a);
	$('.file-list-container').css("height",Math.max.apply(null,h_a));
}
/* 使用for in运算返回数组中某一值的对应项数(比如算出最小的高度值是数组里面的第几个) */
function getarraykey(s, v) {for(k in s) {if(s[k] == v) {return k;}}}
/*这里一定要用onload，因为图片不加载完就不知道高度值*/
autoPlay();
window.onresize=function(){autoPlay();}
	})
	
	
		
		
	</script>
  </head>
  <body>
  <!---导航栏-->
  <div id='nav-top'>
	<div class='nav-center'>
		<div class='nav-logo'><img src='/bs/Public/img/logo.jpg' width=100px height=70px /></div>
		<div class='nav-title'>毕业设计(论文)管理系统</div>
		<div class='nav-user'>
			<div class="user-info" <?php echo ($user['login']?'':'hidden'); ?>>
                    <a class="user-home" href="<?php echo ($user["home"]); ?>">
                        <img width='40' height='40' class="img-border" src="<?php echo ($user["pic"]); ?>" alt="您的头像">
                        <span class="user-name textoverflow"><?php echo ($user["name"]); ?></span>
                    </a>
					<a  href="<?php echo U('Home/Login/logout');?>" title="退出" class='icon-logout'><span class="icon-power-off text-large"></span></a>                    
         
              
			</div>
			<!----没登录--->
			<div class="button border-main login-btn <?php echo ($user[login]?'hidden':''); ?>">
				<a href=<?php echo U('Home/Login/index');?>><span class='icon-user text-big'></span>登录</a> 
			</div>
		</div>
	</div>
  </div>
  <!---中部内容区--->
  <div id='content'>
	<div class='content-center'>
		<!--图片轮播+右侧新闻-->
		<div class='layout'>
			<!----面包屑导航测试-->
			<div class='line'>
				<ul class="bread bg-main bg-inverse">
				<li><a href="<?php echo U('Home/Index/index');?>" class="icon-home"> 首页</a></li>
				<li class='active'>资料下载</li>
				</ul>
			</div>
			
			<div class='line'>
			<!---左边导航栏--->
				<div class='xm2 xs2 hidden-l'>
					<button class="button icon-navicon" data-target="#nav-link1"></button>
						<ul class="nav nav-navicon" id="nav-menu">
						<li class="nav-head">首页</li>
						<li><a href="<?php echo U('Home/Index/news');?>">最新动态</a></li>
						<li class='active'>资料下载</li>
						<li><a href="<?php echo U('Home/Index/link');?>">相关链接</a></li>
						
						</ul>
				</div>
				<div class='xm9 xs9 xl12'>
				<!---右边正文-->
					
					<div class='base-info'>
						<p>共<?php echo ($total); ?>个文件:</p>
					</div>
					<div class='file-list-container'>
						<!---瀑布流资料下载--->
							<?php if(is_array($file)): $i = 0; $__LIST__ = $file;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$file): $mod = ($i % 2 );++$i;?><li class="grid">
                                    <strong><a href="/bs/<?php echo ($file["fileurl"]); ?>"><?php echo (urldecode($file["title"])); ?></a></strong>                                   
                                    <div class="meta"><a href="<?php echo ($file["fileurl"]); ?>"></a>类型：<?php echo ($file["type"]); ?><span class='icon-file-<?php echo ($file["type"]); ?>-o'></span><br><?php echo ($file["publishtime"]); ?></div>
                                </li><?php endforeach; endif; else: echo "" ;endif; ?>
								
 
                                                           
						<!----文件列表结束--->
					</div>
				</div>
			</div>
		</div>
		<!--新闻、下载、链接-->
		
	</div>
  </div>
  <!---footer--->
  <div id='footer'>
	<p class='text-center'>CopyRight2015毕业设计(论文)管理系统</p>
  </div>
  </body>
</html>