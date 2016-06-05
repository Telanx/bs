<?php
// 本类由系统自动生成，仅供测试用途
namespace Teacher\Controller;
use Think\Controller;
class BsManagerController extends Controller {
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
	//毕设数据统计
	
	public function preview(){
		$this->login_check(1);
		$user = public_user_id();
		$model_user = M('user_teacher');
		$rs_user  = $model_user->field('pic,name')->where("user='$user'")->select();
		$this->assign('user',$rs_user[0]);
		//查询学生、教师、课题数
		$model = D("BsManager");
		$snum1 = $model->queryStudentNum(1);
		$snum2 = $model->queryStudentNum(2);
		
		$tnum = $model->queryTeacherNum();
		
		$knum1 = $model->queryKtNum(1);
		$knum2 = $model->queryKtNum(2);
		$rs = array(
			"snum1"=>$snum1,
			"snum2"=>$snum2,
			"tnum"=>$tnum,
			"knum1"=>$knum1,
			"knum2"=>$knum2
		);
		//var_dump($rs);
		
		$this->assign("rs",$rs);
		$ttype = public_user_ttype();
		$this->assign("ttype",$ttype);
		$this->display();
	}
	//课题审核
	public function ktsh(){
		$this->login_check(1);
		$user = public_user_id();
		$ttype = public_user_ttype();
		$model_user = M('user_teacher');
		$rs_user  = $model_user->field('pic,name')->where("user='$user'")->select();
		$this->assign('user',$rs_user[0]);
		$rs_sel = $this->getDepSel($user,$ttype);
		$this->assign('dep',$rs_sel[0]);
		
		
		
		$this->assign("ttype",$ttype);
		$this->display();
	}
	
	//根据教师类型获取部门选项
	public function getDepSel($user,$ttype){
		//院长显示所有系别，系主任只显示当前系别
		if($ttype=='3'){
			$model_sel = M('bs_kt_sel');
			$rs_sel  = $model_sel->field('v')->where("k='dep'")->select();
		}else if($ttype=='2'){
			//系主任获取所在院系
			$model_sel = M('user_teacher');
			$rs = $model_sel->field('dep')->where("user='".$user."'")->select();
			$rs_sel = Array(
				"0"=>Array(
					"v"=>"[\"".$rs[0]['dep']."\"]"
				)
			);
		}
		return $rs_sel;
	}
	//课题审核处理
	public function ktsh_handler(){
		$this->login_check(2);
		//查询和更新功能
		/**传入参数
		*type	--类型
		--------查询------
		*d		--实验室
		*s		--全部0或未审核1
		*p		--翻页
		-------更新--------
		*id[]		--课设ID列表
		*/
		$type=I('post.type');//类型
		$model_kt = D('KtManager');
		$ttype = public_user_ttype();
		if($type=='search'){
		//查询
			$rs_kt = $model_kt->search(I('post.'),$ttype);
			
		}else if($type=='edit'){
		//审核
			$rs_kt = $model_kt->edit(I('post.'),$ttype);
		}else if($type=='unedit'){
			$rs_kt = $model_kt->unedit(I('post.'),$ttype);
		}
		
		$this->ajaxReturn($rs_kt);
	}
	
	
	//历史数据查询
	public function history(){
		$this->login_check(1);
		$user = public_user_id();
		$model_user = M('user_teacher');
		$rs_user  = $model_user->field('pic,name')->where("user='$user'")->select();
		$this->assign('user',$rs_user[0]);
		
		$ttype = public_user_ttype();
		$this->assign("ttype",$ttype);
		$this->display();
	}
	
	
}