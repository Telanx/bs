<?php
// 本类由系统自动生成，仅供测试用途
namespace Teacher\Controller;
use Think\Controller;
class IndexController extends Controller {
	//身份验证
	public function login_check($t){
		if(public_user_type()!=2){
			if($t==1){
				//直接跳转
				$this->error('请先登录后操作！',U('Home/Login/index'),3);
			}
			else if($t==2){
				//ajax返回
				$msg=array(
					'status'=>0,
					'msg'=>'未登录，无法操作'
				);
				$this->ajaxReturn($msg);
			}
		}
	}
	//首页
    public function index(){
		$this->login_check(1);
		$user = public_user_id();
		
		$model_user = M('user_teacher');
		$rs_user = $model_user->field('pic,name')->where("user='$user'")->select();
		$this->assign('user',$rs_user[0]);
		
		$ttype = public_user_ttype();
		$this->assign("ttype",$ttype);
		$this->display();
    }	
	
}