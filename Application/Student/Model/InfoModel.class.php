<?php
namespace Student\Model;
use Think\Model;
class InfoModel extends Model{
	protected $trueTableName = 'user_student_pwd';
	
	//更新用户资料以及密码
	//检查账号密码
	public function checkpwd($user,$pwd){
		$pwd=md5($pwd);
		$rs_user = $this->where("user='$user' and pwd='$pwd'")->select();
		if($rs_user)return 1;
		else return 0;
	}
	//修改密码
	public function updatepwd($user,$pwd){
		$data = array(
			'pwd'=>md5($pwd)
		);
		$rs_user = $this->where("user='$user'")->save($data);
		 if($rs_user)return 1;
		else return 0;
		
	}
}

?>