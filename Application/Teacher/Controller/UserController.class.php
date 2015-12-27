<?php
// 本类由系统自动生成，仅供测试用途
namespace Teacher\Controller;
use Think\Controller;
class UserController extends Controller {
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
	
	//查看个人信息
    public function view(){
		$this->login_check(1);
		$user=public_user_id();
		$model_user = M('user_teacher');
		$rs_user = $model_user->where("user='$user'")->select();
		$rs_user[0]['status'] = $rs_user[0]['status']['status'];//
        //dump($rs_user[0]);
		$this->assign('user',$rs_user[0]);
		$ttype = public_user_ttype();
		$this->assign("ttype",$ttype);
		$this->display();
    }
	//更新个人信息
	public function edit(){
		$this->login_check(1);
		$user=public_user_id();
		//查询部门数据
		$model_sel = M('bs_kt_sel');
		$rs_sel = $model_sel->field('v')->where("k='dep'")->select();
		$this->assign('dep',$rs_sel[0]);
		$model_user = M('user_teacher');
		$r=-1;
		if(count(I('post.'))){
		//更新数据
				if($model_user->where("user='$user'")->save(I('post.')))$r=1;
				else $r=0;
				
		}
		
		$this->assign('r',$r);
		$rs_user = $model_user->where("user='$user'")->select();
        $rs_user[0]['status'] = $rs_user[0]['status']['status'];//ord($rs_user[0]['status']);//转化mysql的bit(1)
		$this->assign('user',$rs_user[0]);
		$ttype = public_user_ttype();
		$this->assign("ttype",$ttype);
		$this->display();
	}
	//修改密码
	public function edit_pwd(){
		$this->login_check(2);
		$user=public_user_id();
		$pwd = md5(I('post.pwd'));
		$pwd2 = md5(I('post.pwd2'));
		if($pwd&&$pwd2){
			$model_user = D('Info');
			if($model_user->checkpwd($user,$pwd)){
				if($model_user->updatepwd($user,$pwd2))$msg=array(
					'status'=>0,
					'msg'=>'修改成功！'
				);
				else $msg= array(
					'status'=>1,
					'msg'=>'修改失败！'
				);
			}
			else $msg=array(
				'status'=>0,
				'msg'=>'密码不正确！'
			);
			//dump($user);
		}
		else {
			$msg = array(
				'status'=>0,
				'msg'=>''
				);
		}
		$this->ajaxReturn($msg);
		
	}
	
}