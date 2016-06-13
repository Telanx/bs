<?php
//登录控制器
namespace Home\Controller;
use Think\Controller;
class LoginController extends Controller {
    public function index(){
		$this->display('index');
    }
	//登录验证
	public function login(){
		$ModelLogin = D('Login');
		$rs_check = $ModelLogin->check(I('post.'));
		//保存登录信息
		cookie('type',I('post.type'),3600*24*15);
		cookie('user',I('post.user'),3600*24*15);
		if($rs_check==-1){
			$this->assign('error','验证码错误！');
			$this->display('index');
		}else if($rs_check==0){
			$this->assign('error','登录失败！');
			$this->display('index');
		}else if($rs_check==1){
			//通过
			//如果是老师，检查教师的类型(普通，系主任，院长)
			$ttype=1;
			if(I('post.type')=='2'){
				$model = M('user_teacher');
				$rsType = $model->field('type')->where("user='".I('post.user')."'")->select();
				$ttype = $rsType[0]['type'];
			}
			//保存用户身份到session
			$session=array(
				'type'=>I('post.type'),
				'user'=>I('post.user'),
				'ttype'=>$ttype,
				'ctime'=>NOW_TIME	//创建时间
			);
			session('telanx',$session);
			switch(I('post.type')){
				case '3':$m = 'Admin';break;
				case '2':$m = 'Teacher';break;
				case '1':$m = 'Student';
			}
			//管理员则记录登录时间
			if(I('post.type')=='3')$ModelLogin->admin_login_time(I('post.user'));
			//检查是否第一次登录
			if (I('post.type')=='2') {
				$userinfo = M('UserTeacher')->where(array('user'=>I('post.user')))->find();
				if (empty($userinfo['qq']) && empty($userinfo['cellphone']) && empty($userinfo['officephone'])) {
					$this->error('登录成功', U('Teacher/User/edit'));
				}
			}
			if (I('post.type')=='1') {
				$userinfo = M('UserStudent')->where(array('user'=>I('post.user')))->find();
				if (empty($userinfo['qq']) && empty($userinfo['eamil']) && empty($userinfo['cellphone'])) {
					$this->error('登录成功', U('Student/User/edit'));
				}
			}
			$this->success('登录成功', U($m.'/Index/index'));	
		}
	}
	public function verifycode(){
		$config =    array(
				'fontSize'    =>    50,    // 验证码字体大小
				'length'      =>    4,     // 验证码位数
				'useNoise'    =>    false, // 关闭验证码杂点
				'fontttf'	=>'4.ttf'
			);
		$Verify = new \Think\Verify($config);
		$Verify->entry();
	}
	
	//退出登录操作
	public function logout(){
		//销毁session
		session(null);
		$this->success('退出登录成功！',U('Home/Index/index'),3);
		
	}
	//加密
	private function encrypt($str){
		$skey = 'telanx';
		$key = substr(md5($skey), 5, 8);
        $str = substr(md5($str), 8, 10);
        return md5($key . $str);
	}
}