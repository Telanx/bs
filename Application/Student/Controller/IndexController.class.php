<?php
// 本类由系统自动生成，仅供测试用途
namespace Student\Controller;
use Think\Controller;
class IndexController extends Controller {
	//前置方法-->验证用户登录
	public function _before_index(){
		if(public_user_type()!='1')$this->error('未登录，请先登录后再操作！',U('Home/Login/index'),3);		
	}
	//首页
    public function index(){
		//获取学生信息
		$user = public_user_id();
		$model_user = M('user_student');
		$rs_user = $model_user->field('name,pic')->where("user='$user'")->select();
		$this->assign('user',$rs_user[0]);
		$this->display();
    }	
	
}