<?php
// 本类由系统自动生成，仅供测试用途
namespace Admin\Controller;
use Think\Controller;
class IndexController extends Controller {
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
	//首页
    public function index(){
		$this->login_check(1);
		$user = public_user_id();
		$this->assign('user',$user);
		//检测一些必填数据的完整性
		$model = D('Index');
		$rs = $model->initCheck();
		$s=0;
		if($rs['s']!=0){		//选项数据不完整
			$s=1;
		}else if($rs['t']!=0){		//选题时间不完整
			$s=2;
		}
		$this->assign('s',$s);
		$this->display('index');
    }
	//动态新闻
	public function news(){
		$this->login_check(1);
		$user = public_user_id();
		$this->assign('user',$user);
		$this->display();
		
	}
	//相关链接
	public function link(){
		$this->login_check(1);
		$user = public_user_id();
		$this->assign('user',$user);
		
		$model_link = M('home_link');
		$rs_link = $model_link->select();
		$this->assign('list',$rs_link);		
		$this->display('link');
	}
	//相关链接处理
	public function link_handler(){
		$this->login_check(2);
		$user = public_user_id();
		//分为３类
		$title = I('post.title');
		$linkurl = I('post.linkurl');
		$type = I('post.type');
		//添加或者编辑
		if($type=='add' || $type=='edit'){
			if(!(trim($title)==''||trim($linkurl)=='')){
				$model_link = M('home_link');
				$data = I('post.');
				if($type=='add')$rs_link = $model_link->add($data);
				else $rs_link = $model_link->where('id='.I('post.id'))->save($data);
				if($rs_link){
					$msg = array(
						'status'=>'1',
						'msg'=>'修改成功！'
					);
				}else{
					$msg = array(
						'status'=>'0',
						'msg'=>'修改失败！请重试！'
					);	
				}
			}else{
				$msg = array(
					'status'=>'０',
					'msg'=>'修改失败！请检查标题或者地址是否为空！'
				);
			}
		}
		//删除操作
		else if($type=='del'){
			$model_link = M('home_link');
			$rs_link = $model_link->where('id='.I('post.id'))->delete();
			if($rs_link){
					$msg = array(
						'status'=>'1',
						'msg'=>'删除成功！'
					);
			}else{
					$msg = array(
						'status'=>'0',
						'msg'=>'删除失败！请重试！'
					);	
			}
		}
		//非法操作
		else{
			$msg = array(
					'status'=>'０',
					'msg'=>'添加失败！请重试！'
				);	
		}
		$this->ajaxReturn($msg);
	}
	
	//时间规划
	public function plan(){
		$this->login_check(1);
		$user = public_user_id();
		$this->assign('user',$user);
		
		$model_plan = M('home_plan');
		$rs_plan = $model_plan->order('id')->select();
		$this->assign('plan',$rs_plan);
		$this->display();
	}
	
	//时间规划处理
	public function plan_handler(){
		$this->login_check(2);
		$user = public_user_id();
		$this->assign('user',$user);
		
		//仍旧是分为3类
		$tt = I('post.ttime');
		$ct = I('post.content');
		$type = I('post.type');
		//添加或者编辑
		if($type=='add' || $type=='update'){
			if(!(trim($tt)==''||trim($ct)=='')){
				$model_plan = M('home_plan');
				$data = I('post.');
				if($type=='add')$rs_plan = $model_plan->add($data);
				else $rs_plan = $model_plan->where('id='.I('post.id'))->save($data);
				if($rs_plan){
					$msg = array(
						'status'=>'1',
						'msg'=>'操作成功！'
					);
				}else{
					$msg = array(
						'status'=>'0',
						'msg'=>'操作失败！请重试！'
					);	
				}
			}else{
				$msg = array(
					'status'=>'０',
					'msg'=>'修改失败！请检查标题或者地址是否为空！'
				);
			}
		}
		//删除操作
		else if($type=='del'){
			$model_plan = M('home_plan');
			$rs_plan = $model_plan->where('id='.I('post.id'))->delete();
			if($rs_plan){
					$msg = array(
						'status'=>'1',
						'msg'=>'删除成功！'
					);
			}else{
					$msg = array(
						'status'=>'0',
						'msg'=>'删除失败！请重试！'
					);	
			}
		}
		//非法操作
		else{
			$msg = array(
					'status'=>'０',
					'msg'=>'添加失败！请重试！'
				);	
		}
		$this->ajaxReturn($msg);
		
	}
	//资料文件
	public function doc(){
		$this->login_check(1);
		$user = public_user_id();
		$this->assign('user',$user);
		$model_file = M('home_doc');
		$rs_file = $model_file->order('publishtime desc')->select();
		$this->assign('file',$rs_file);
		$this->display();
	}
	//资料文件的处理
	public function doc_handler(){
		$this->login_check(2);
		$user = public_user_id();
		$this->assign('user',$user);
		
		//仍旧是分为3类
		$type = I('post.type');
		//添加或者编辑
		if($type=='upload'){
				if(count($_FILES)>0){
					$f = $_FILES['upload'];
					$uploadDir = 'bs/upload/doc/';
					$filename = I('post.filename');
					$ext = pathinfo($f['name'])['extension'];
					$saveFileName = $uploadDir . date('Ymd').'_'.md5(uniqid(rand())).'.'.$ext;
					
					if(move_uploaded_file($f['tmp_name'], $saveFileName)){
						//存储到数据库记录中去
						
						$data = array(
							'id'=>null,
							'title'=>$filename,
							'type'=>$ext,
							'fileurl'=>$saveFileName,
							'publishtime'=>date('Y-m-d')
						);
						$model = M('home_doc');
						$model->add($data);
						$msg=array(
							'status'=>1,
							'msg'=>'上传成功！'
						);
					}
					else {
						$msg=array(
							'status'=>0,
							'msg'=>'上传失败！'
						);
					}
					
				}
        	
				
		}
		//删除操作
		else if($type=='del'){
			$id = I('post.id');
			//文件以及数据库删除
			$success = array(
				'status'=>1,
				'msg'=>'删除成功！'
			);
			$error = array(
				'status'=>0,
				'msg'=>'删除失败！'
			);
			$model = M('home_doc');
			$rs_file = $model->where("id=$id")->select();
			$fileurl = $rs_file[0]['fileurl'];
			$rs_file_del = $model->where("id=$id")->delete();
			if (file_exists($fileurl)) { 
				@unlink($fileurl);
			}
			if($rs_file_del)$msg = $success;
			else $msg=$error;
			
		}
		//非法操作
		else{
			$msg = array(
					'status'=>0,
					'msg'=>'上传失败！请重试！'
				);	
		}
		echo json_encode($msg);
		
	}
	
	
	//富文本编辑
	public function richContent(){
		$this->display();
		
	}
}
