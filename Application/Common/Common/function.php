<?php
	/****公共函数****/
	//登录类型
	function public_user_type(){
		return session('telanx.type');
	}
	//登录用户名
	function public_user_id(){
		return session('telanx.user');
	}
	//教师类别
	function public_user_ttype(){
		return session('telanx.ttype');
	}
	//创建时间
	function public_user_ctime(){
		return session('telanx.ctime');
	}

?>