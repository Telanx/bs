<?php
	namespace Home\Model;
	use Think\Model;
	class LoginModel extends Model{
		public function check($para)
		{
			$user = $para['user'];
			$type = $para['type'];
			$pwd = md5($para['pwd']);
			$vcode = $para['verifycode'];
			//首先验证验证码
			if($this->check_verify($vcode)){
				//验证账号密码
				switch($type){
					case '3':$tb = 'user_admin';$tb2='user_admin';break;
					case '2':$tb = 'user_teacher_pwd';$tb2='user_teacher';break;
					case '1':$tb = 'user_student_pwd';$tb2 = 'user_student';
				}
				$Model = new \Think\Model();
				$sql = "select  * from $tb2 B left join $tb A on A.user=B.user where A.user='$user' and A.pwd='$pwd' and B.status=1";
				//var_dump($sql);
				if(count($Model->query($sql)))return 1;
				else return 0;
			}else return -1;
		}
		public function check_verify($code, $id = ''){
			$verify = new \Think\Verify();
			return $verify->check($code, $id);
		}
		//记录用户登录时间
		public function admin_login_time($user){
			$model_user = M('user_admin');
			$data=array(
				'lastlogin'=>date('Y-m-d H:i:s'),
				'ip'=>$this->getIP()
			);
			$model_user->where("user='$user'")->save($data);
		}
		
		public function getIP(){ 
		global $ip;
		if (getenv("HTTP_CLIENT_IP")) 
		$ip = getenv("HTTP_CLIENT_IP"); 
		else if(getenv("HTTP_X_FORWARDED_FOR")) 
		$ip = getenv("HTTP_X_FORWARDED_FOR"); 
		else if(getenv("REMOTE_ADDR")) 
		$ip = getenv("REMOTE_ADDR"); 
		else 
		$ip = "Unknow"; 
		return $ip; 
		} 
	}
?>