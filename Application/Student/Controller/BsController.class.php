<?php
// 本类由系统自动生成，仅供测试用途
namespace Student\Controller;
use Think\Controller;
class BsController extends Controller {
	//身份验证
	public function login_check($t){
		if(public_user_type()!=1){
			if($t=='1'){
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
	//获取选题时间
	public function getXtTime(){
		$xtTimeModel = M('sys_time');
		$xtTime = $xtTimeModel->select();
		return $xtTime;
	}
	//检查是否处于选题阶段
	public function xtTimeCheck($xtTime){
		
		if(time()>=strtotime($xtTime[0]['v'])&&time()<=strtotime($xtTime[1]['v']))$xtTimeCheck=1;
		 else $xtTimeCheck=0;
		 return $xtTimeCheck;
	}
	//选题
	public function xt(){
		$this->login_check(1);
		$user = public_user_id();
		//检查是否完善信息了
		$userinfo = M('UserStudent')->where(array('user'=>session('telanx.user')))->find();
		if (empty($userinfo['qq']) && empty($userinfo['eamil']) && empty($userinfo['cellphone'])) {
			$this->error('请先完善个人信息', U('Student/User/edit'));
		}
		$model_user = M('user_student');
		$rs_user = $model_user->field('name,pic')->where("user='$user'")->select();
		$this->assign('user',$rs_user[0]);
		
		$xtTime = $this->getXtTime();
		$this->assign('xtTime',$xtTime);
		
		 $xtTimeCheck = $this->xtTimeCheck($xtTime);
		 $this->assign('xtTimeCheck',$xtTimeCheck);
		//查询是否选了课题
		
		$model_xt = D('Xt');
		if($model_xt->is_selected($user)){
			$rs_kt = $model_xt->mykt($user);
			$this->assign('kt',$rs_kt);
			$this->display('mykt');
		}
		else $this->display('xt');
	}
	//删除课题
	public function del(){
		$this->login_check(2);
		$user =public_user_id();
		$model_xt = D('Xt');
		if($this->xtTimeCheck($this->getXtTime())){
			$rs = $model_xt->del($user);
		}else{
			
			$rs=array(
				'status'=>0,
				'msg'=>'删除失败！不在选题阶段！'
			);
		}
		$this->ajaxReturn($rs);
	}
    public function xt_handler(){
		
		$this->login_check(2);
		$user = public_user_id();
		$type=I('post.t');//类型
		$model_xt = D('Xt');
		$post = I('post.');
        //dump($post);
        //echo($type);
		if($type=='search'){
		//查询
			$rs_kt = $model_xt->search(I('post.'));
		}else if($type=='edit'){
		//选择
		//先对选题时间进行过滤
			if($this->xtTimeCheck($this->getXtTime())){
					$para=array(
						'bid'=>I('post.bid'),
						'sid'=>$user
					);
					$rs_kt = $model_xt->edit($para);	
			}else {
				$rs_kt = array(
					'status'=>0,
					'msg'=>'当前不在选题时间内！'
				);
				
			}
			
		}
		$this->ajaxReturn($rs_kt);
    }	
	
	//查看课题
	public function kt_info()
	{
		$model_kt = D('Xt');
		$rs_kt = $model_kt->view(I('get.id'));
		$this->assign('kt',$rs_kt);
		if(!$rs_kt)$this->display('error');
		else
		$this->display();
	}
	
	
	//毕设管理
	public function manage(){
		$this->login_check(1);
		$user = public_user_id();
		$model_user = M('user_student');
		$rs_user = $model_user->field('name,pic')->where("user='$user'")->select();
		$this->assign('user',$rs_user[0]);
		//获取记录
		$model_log = D('Log');
		$logArr = $model_log->getLog($user);
		//var_dump($logArr);
		$this->assign('logList',$logArr);
		$this->display();
	}
	//毕设管理处理
	public function manage_handler(){
		//包括对日志的增删该查询以及文件上传
		if(I('post.type')=='log'){
			//对日志的请求
			$post = I('post.');	//请求操作
			$this->log($post);
		}else{
			//无法识别的请求
			$requestError = array(
				'status'=>0,
				'msg'=>'请求方式错误！'
			);
			$this->ajaxReturn($requestError);
		}
	}
	//查看历史记录日志
	public function view_log(){
		$model_log = D('Log');
		$user = public_user_id();
		$logArr = $model_log->getLog($user);
		$this->ajaxReturn($logArr);
	}
	
	//处理日志
	public function log($post){
		/**
		增加，删除，修改
		方式:POST
		字段type=>['add','del','modify']
		其他(id),(str)
		**/
		$this->login_check(1);
		$user = public_user_id();
		$model_log = D('Log');
		$error = 0;
		switch($post['action']){
			case 'add':if($post['ct'])$model_log->addLog($user,$post['ct']);else $error=1;break;
			case 'del':if((int)$post['id']>=0)$model_log->delLog($user,(int)$post['id']);else $error=1;break;
			case 'modify':if($post.['id']&&$post['str'])$model_log->modify($user,$id,$str);else $error=1;break;
			default:$error=1;
		}
		if(!$error)$msg = array(
			'status'=>1,
			'msg'=>'操作成功！'
		);
		else $msg = array(
			'status'=>0,
			'msg'=>'参数不正确'
		);
		$this->ajaxReturn($msg);
	}
	
	//单独页面修改日志
	public function modify_log(){
		$this->login_check(1);
		$user = public_user_id();
		$model_log = D('log');
		$id=-1;
		if(I('post.id')!=null){
			$id = I('post.id');
			if(strlen(trim(I('post.ct')))<5)$msg='修改失败！报告字数必须大于5！';
			else{
				$ct = I('post.ct');
				if($model_log->modifyLog($user,$id,$ct))$msg='修改成功！';
				else $msg='修改失败！';
			}
			//var_dump($msg);
			$this->assign('msg',$msg);
		}	
		if(I('get.id'))$id=I('get.id');
		$log = $model_log->getSingleLog($user,(int)$id);
		$this->assign('log',$log);	
		$this->display();
	}
	
}