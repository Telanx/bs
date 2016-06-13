<?php
//登录控制器
namespace Teacher\Controller;
use Think\Controller;
class BsController extends Controller {
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
	//日志管理
	public function manage(){
		$this->login_check(1);
		$user = public_user_id();
		$model_user = M('user_teacher');
		$rs_user  = $model_user->field('pic,name')->where("user='$user'")->select();
		$this->assign('user',$rs_user[0]);
		
		//处理见Model->Bs
		$model = D('Bs');
		$rs = $model->getStudentList($user);
		$this->assign('slist',$rs);
		$ttype = public_user_ttype();
		$this->assign("ttype",$ttype);
		$this->display();
		
	}
	//查看学生日志
	public function viewslog(){
		$this->login_check(1);
		$user = public_user_id();
		if(I('get.sid')){
			$model_log = D('Bs');
			$sid = I('get.sid');
			$rs_log = $model_log->getLog($sid,$user);	//日志列表
			$rs_kt = $model_log->getInfo($sid);	//获取课题信息
			$lasttime = $this->getLastTime($rs_log);
			$rs = array(
				'info'=>array(
					'sname'=>$rs_kt['sname'],
					'bsname'=>$rs_kt['bsname'],
					'count'=>count($rs_log),
					'lasttime'=>$lasttime
				),
				'list'=>$rs_log
			);
			$this->assign('log',$rs['info']);
			$this->assign('loglist',$rs['list']);
		}
		$this->display();
	}
	//获取学生日志中最近一次日期
	public function getLastTime($logList){
		$maxId = 0;
		$maxIndex=-1;
		for($i=0;$i<count($logList);$i++){
			$cId = (int)$logList[$i]['id'];
			if($cId>$maxId){
				$maxIndex++;
				$maxId = $cId;
			}
		}
		return $logList[$maxIndex]['time'];
	}
    public function index(){
		$this->login_check(1);
		$user = public_user_id();
		$model_user = M('user_teacher');
		$rs_user = $model_user->field('pic,name')->where("user='$user'")->select();
		$this->assign('user',$rs_user[0]);
		$model_kt = M('bs_kt');
		$rs_kt = $model_kt->where("teacher='$user'")->select();
		//获取课题上报时间段
		$model_kt_time = M('sys_time');
		$ktsb_start = $model_kt_time->field('v')->where("k='kt_start'")->select();
		$ktsb_end = $model_kt_time->field('v')->where("k='kt_end'")->select();
		$kt_time = array(
			'kt_start'=>$ktsb_start[0]['v'],
			'kt_end'=>$ktsb_end[0]['v']
		);
		$this->assign('ktsb',$kt_time);
		$ktTimeCheck = $this->ktTimeCheck($kt_time['kt_start'],$kt_time['kt_end']);
		$this->assign('ktTimeCheck',$ktTimeCheck);
		$this->assign('kt',$rs_kt);
		$ttype = public_user_ttype();
		$this->assign("ttype",$ttype);
		$this->display('index');
    }
		//检查是否处于选题阶段
		//检查是否处于课题填报阶段
	public function ktTimeCheck($ktStart,$ktEnd){
		
		if(time()>=strtotime($keStart)&&time()<=strtotime($ktEnd))$xtTimeCheck=1;
		 else $xtTimeCheck=0;
		 return $xtTimeCheck;
	}
	
	public function add(){
		$this->login_check(1);
		$user = public_user_id();
		//检查是否完善信息了
		$userinfo = M('UserTeacher')->where(array('user'=>session('telanx.user')))->find();
		if (empty($userinfo['qq']) && empty($userinfo['cellphone']) && empty($userinfo['officephone'])) {
			$this->error('请先完善个人信息', U('Teacher/User/edit'));
		}
		$model_user = M('user_teacher');
		$rs_user = $model_user->field('pic,name')->where("user='$user'")->select();
		$this->assign('user',$rs_user[0]);
		$model_kt = D('kt');
		$post = I('post.');
		if(count($post)){
			// 检查数量
			$count = $model_kt->where(array('teacher'=>$user))->count();
			if ($count >= 5) {
				$this->assign('msg','最多只能添加5个课题');
			}else{
				$post['teacher']=$user;
				$verify = $model_kt->kt_add($post);
				if(!$verify['msg']){
					$msg = $verify['msg'];
				}else{
				$post['status']=0;
				if($model_kt ->add($post))$msg = '课题录入成功！';
				else $msg = '课题录入失败！请重试！';	
				}
				$this->assign('msg',$msg);
			}
		}
		$ttype = public_user_ttype();
		$this->assign("ttype",$ttype);
		$this->display();
	}
	//课题上报，删除等
	public function index_handler(){
		$this->login_check(2);
		$user = public_user_id();
		$type = I('post.type');
		$model_kt = D('Kt');
		if($type=='del'){
			//删除课题
				$model_kt->del($user,I('post.list'));
				$msg=array(
						'status'=>1,
						'msg'=>'删除课题成功！'
					);
				
		}else if($type=='report'){
			//上报课题
			$model_kt->report($user,I('post.list'));
			$msg = array(
					'status'=>1,
					'msg'=>'课题上报成功'
				);
		}else if($type=='cancel'){
			//取消上报
			$model_kt->cancel($user,I('post.list'));
			$msg=array(
					'status'=>1,
					'msg'=>'取消成功！'
				);
			
		}
		$this->ajaxReturn($msg);
	}
	public function xt(){
		$this->login_check(1);
		$user = public_user_id();
		$model_user = M('user_teacher');
		$rs_user  = $model_user->field('pic,name')->where("user='$user'")->select();
		$this->assign('user',$rs_user[0]);
		$Model = new \Think\Model();
		$sql ="select bs_xt.time,bs_kt.id as bid,bs_kt.name,user_student.name as sname,user_student.user,bs_kt.status from bs_xt right join bs_kt on bs_kt.id=bs_xt.bid left join user_student on user_student.user=bs_xt.sid where bs_kt.teacher='$user'";
		$rs_xt = $Model->query($sql);
		$this->assign('xt',$rs_xt);
		$ttype = public_user_ttype();
		$this->assign("ttype",$ttype);
		$this->display('xt');
	}
	//查看用户的信息
	public function student_handler(){
		$this->login_check(2);
		$user = I('post.user');
		$model_user = M('user_student');
		$rs_user = $model_user->where("user='$user'")->select();
		$this->ajaxReturn($rs_user);
	}
	
	
	//编辑课题
	public function kt_edit(){
		$this->login_check(1);
		if(count(I('post.'))){
				$model_kt = M('bs_kt');
				if($model_kt->data(I('post.'))->save()){
					$msg = "保存成功!";;
				}else{
					$msg = "保存失败！";
				}
				$this->assign("msg",$msg);
		}
		
		if(I('get.id')){
			$id = I('get.id');
			$model = M('bs_kt');
			$ktInfo = $model->where("id='".$id."'")->select();
			$this->assign('kt',$ktInfo[0]);
			$this->display();
		}else{
			$this->show("无权限操作！");
		}
	}
}