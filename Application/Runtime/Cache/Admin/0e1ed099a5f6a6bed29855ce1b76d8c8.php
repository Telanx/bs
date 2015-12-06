<?php if (!defined('THINK_PATH')) exit();?><html>
	<head>
		<style type='text/css'>
		.user-info{
			font-family:'微软雅黑';
			width:500px;
			height:320px;
		}
		.info-left{
			width:200px;
			float:left;
		}
		.info-right{
			width:300px;
			float:left;
		}
		
		.button{
			border:solid 1px rgb(0,153,255);
			cursor:pointer;
			width:100%;
			height:34px;
			line-height:34px;
			text-align:center;
			float:left;
			margin-top:20px;
			border-radius:4px;
		}
		.button:hover{
			background:rgb(0,153,255);
			border:solid 1px #fff;
			color:#fff;
		}
		.msg{
			
			text-align:center;
			color:#f00;
		}
		</style>
		<script src="/bs/Public/lib/pintuer/jquery.js"></script>
		<script type='text/javascript'>
		$(function(){
			var dep_list =<?php echo ($class["v"]); ?>;
			var dep ="<?php echo ($user['class']==null?'计科一班':$user['class']); ?>";
			(function(l,d,dom){$.each(l,function(i,e){dom.append('<option value='+e+' '+(e==d?'selected':'')+'>'+e+'</option>');})})(dep_list,dep,$('#dep-list'));
			
			var s = <?php echo ($user["status"]); ?>;
			$('input[name=status]:eq('+(1-s)+')').attr('checked',true);
		
			$('.btn-confirm').click(function(e){
				//检验参数是否正确
				var pwd =$('input[name=pwd]').val();
				var pwd2=$('input[name=pwd2]').val();
				if(pwd!=pwd2){
					var msg_node =$('.msg');
					msg_node.html('2次密码输入不一致，请重试！');
					for(i=0;i<3;i++){
					msg_node.animate({'marginLeft':'-20px'},30).animate({'marginLeft':'0px'},30).animate({'marginLeft':'20px'},30).animate({'maeginLeft':'0px'},30);
					}
			
					return false;
					}
				$('form').submit();
			})
		})
		
	</script>
	</head>
	
	<body>
	
	<div class='user-info'>
		<div class='info-left'>
			<div class='pic'><img src="<?php echo ($user[pic]?$user[pic]:'https://ss1&#46;baidu&#46;com/6ONXsjip0QIZ8tyhnq/it/u=801265354,741403095&fm=58'); ?>" width="180px" height="270px"/></div>
			
		</div>
		
		<div class='info-right'>
			<form method="post" action="<?php echo U('Admin/User/student_edit');?>?user=<?php echo ($user["user"]); ?>">
				<table>
					<tr><td>学号：</td><td><?php echo ($user["user"]); ?></td></tr>
					<tr><td>姓名：</td><td><input type='text' name="name" value="<?php echo ($user["name"]); ?>"></td></tr>
					<tr><td>班级：</td><td><select id='dep-list' name="class"></select></td></tr>
					<tr><td>状态：</td><td><label><input type='radio' name='status' value=1>启用</label><label><input type='radio' name='status' value=0>禁用</label></td></tr>
					
					<tr><td>QQ：</td><td><input type='text' name='qq' value="<?php echo ($user["qq"]); ?>"></td></tr>
					<tr><td>邮箱：</td><td><input type='text' name='email' value="<?php echo ($user["email"]); ?>"></td></tr>
					<tr><td>手机号：</td><td><input type='text' name='cellphone' value="<?php echo ($user["cellphone"]); ?>"></td></tr>
					<tr><td>修改密码：</td><td><input type='password' name='pwd' placeholder="若不修改则无需填写"></td></tr>
					<tr><td>确认密码：</td><td><input type='password' name='pwd2' placeholder="若不修改则无需填写"></td></tr>
				</table>
			</form>
		</div>
		<div class='op'>
			<div class='button btn-confirm'>确认更新</div>
		</div>
		
		<div class='msg'><?php echo ($user["msg"]); ?></div>
	</div>
	
	
		
	</body>
</html>