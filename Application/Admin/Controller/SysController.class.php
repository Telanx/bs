<?php
	namespace Admin\Controller;
	use \Think\Controller;
	class SysController extends Controller{
		//身份验证
		public function login_check($t){
		if(public_user_type()!=3){
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
		//初始化设置
		public function init(){
			$this->login_check(1);
			$this->assign('user',public_user_id());
			//检测初始化状态
			$model = D('Sys');
			$info = $model->bkStatus();
			if($info['code'])  //已备份过
			$bdL = $model->log('backup','get','');
			else $bdL = array();//未备份初始化
			$backup = array(
				'info'=>$info,
				'bdL'=>json_encode($bdL)
			);
			$this->assign('backup',$backup);
			$this->display();
			
		}
		//初始化ajax
		 public function init_handler(){
			 $this->login_check(2);
			 $model = D('Sys');
			 $tb = I('post.tb');
			 switch(I('post.type')){
				 case 'backup':$rs = $model->backup($tb);break;
				 case 'wipe':$rs = $model->wipe($tb);break;
				 default:$rs=array(
					'status'=>0,
					'error'=>'未知请求'
				 );
			 }
			 $this->ajaxReturn($rs);
		 }
		
		//选项配置
		
		public function sel(){
			$this->login_check(1);
			$model_sel = M('bs_kt_sel');
			$sel_a = array("class","dep","bstype","bsway");
			foreach($sel_a as $s){
				$sel[$s] = $model_sel->field('v')->where("k='$s'")->select()[0];
				
				if($sel[$s]==null){
					$d=array(
						'id'=>null,
						'k'=>$s,
						'v'=>'[]'
					);	
				
					$model_sel->add($d);
				}
			}
			$this->assign('sel',$sel);
			$this->assign('user',public_user_id());
			//var_dump($sel);
			$this->display();
		}
		//保存选项
		public function sel_handler(){
			$this->login_check(2);
			$type = I('post.type');
			$error = array(
				'status'=>0,
				'msg'=>'操作失败！'
			);
			$done = array(
				'status'=>1,
				'msg'=>'操作成功！'
			);
			$msg = $error;
			if($type=='save'){
				$sel = I('post.sel');//类型
				$k = str_replace('sel-','',$sel);
				$model_sel  = D('Sys');
				if($model_sel->sel_save($k,I('post.sel_a')))$msg = $done;
			}
			$this->ajaxReturn($msg);
		}
		
		//时间配置
		public function time(){
			$this->login_check(1);
			$model_time = D('Sys');
			$time_xt_start = $model_time->getTime('xt_start');
			$time_kt_start = $model_time->getTime('kt_start');
			$time_xt_end = $model_time->getTime('xt_end');
			$time_kt_end = $model_time->getTime('kt_end');
			$time=array(
				'xt_start'=>$time_xt_start,
				'kt_start'=>$time_kt_start,
				'kt_end'=>$time_kt_end,
				'xt_end'=>$time_xt_end
			);
			$this->assign('user',public_user_id());
			$this->assign('time',$time);
			$this->display();
		}
		//处理时间,主要就是重新修改时间
		public function time_handler(){
			$this->login_check(2);
			$model_time = D('Sys');
			if(I('post.type')=='save'){
				//var_dump(I('post.data'));
				$rs_time = $model_time->saveTime(I('post.data'),I('post.f'),public_user_id());
				if($rs_time)$msg = array(
					'status'=>1,
					'msg'=>'操作成功！'
				);
				else $msg = array(
					'status'=>0,
					'msg'=>'操作失败！'
				);
			}
			$this->ajaxReturn($msg);
			
		}
		
	}
?>