<?php
	/****��������****/
	//��¼����
	function public_user_type(){
		return session('telanx.type');
	}
	//��¼�û���
	function public_user_id(){
		return session('telanx.user');
	}
	//��ʦ���
	function public_user_ttype(){
		return session('telanx.ttype');
	}
	//����ʱ��
	function public_user_ctime(){
		return session('telanx.ctime');
	}

?>