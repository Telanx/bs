<?php
// 本类由系统自动生成，仅供测试用途
namespace Admin\Controller;
use Think\Controller;
class UserController extends Controller {
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
	//新建账号
	public function account(){
		$this->login_check(1);
		$user = public_user_id();
		$model_sel = M('bs_kt_sel');
		$rs_sel_class=$model_sel->field('v')->where("k='class'")->select();
		$rs_sel_dep = $model_sel->field('v')->where("k='dep'")->select();
		$this->assign('class',$rs_sel_class[0]);
		$this->assign('dep',$rs_sel_dep[0]);
		$this->assign('user',$user);
		$this->display();
	}
	//账号导入处理
	public function account_handler(){
		$this->login_check(2);
	//为了好反馈方便不采用批量插入数据，而是采用逐条插入
		$user_type = I('post.usertype');
		switch($user_type){
			case '1':$dep='class';$table = 'user_student';$tb2='user_student_pwd';$reg_str='/^U\d{9}$/';break;
			case '2':$dep='dep';$table = 'user_teacher';$tb2='user_teacher_pwd';$reg_str='/^\d{7}$/';break;
			case '3':$dep='';$table = 'user_admin';$tb2=$table;$reg_str='/^[a-z]{4,6}$/';break;
		}
		$account=array(
			'user'=>I('post.user'),
			'name'=>I('post.name'),
			''.$dep=>I('post.dep'),//单位
			//'pwd'=>'123456',密码移到其它表
			'status'=>1
		);
		
		//进行规则验证
		//var_dump(preg_match($reg_str,$account['user']));
		if(preg_match($reg_str,$account['user'])){
			$model_user = M($table);
			
			if($model_user->add($account)){
				$model_pwd = M($tb2);
				$account_pwd=array(
					'id'=>null,
					'user'=>I('post.user'),
					'pwd'=>md5('123456')
				);
				$model_pwd->add($account_pwd);
				$msg = array(
					'status'=>1,
					'msg'=>'添加成功！'
				);
			}else{
				$msg=array(
				'status'=>0,
				'msg'=>'添加失败！'
				);
				
			}
		}else{
			$msg=array(
				'status'=>0,
				'msg'=>'账号格式不正确'
			);
			
		}
		$this->ajaxReturn($msg);
	}
	
	//文件上传方式批量导入
	public function account_file(){
		if(count($_FILES)>0){
					$file = $_FILES['file'];
					$path = $file['tmp_name'];
					if(file_exists($path)){
						$type = $_POST['type'];
						$f = fopen($path,"r+");
						$str_a= file($path);
						$model = D('User');
						$str = $model->account_file($type,$str_a);
						//解析每一组数据
					}else $str=array(
						"status"=>0,
						"msg"=>"操作失败！"
					);
		}else{
			$str =array( 
				"statis"=>0,
				"msg"=>"操作失败！未上传文件！");
		}
		
		$this->ajaxReturn($str);
	}
	//学生
	public function student(){
		$this->login_check(1);
		$user = public_user_id();
		$model_sel = M('bs_kt_sel');
		$rs_sel = $model_sel->field('v')->where("k='class'")->select();
		$this->assign('class',$rs_sel[0]);
		$this->assign('user',$user);
		$this->display();
	}
	public function student_handler(){
		//条件查找，删改,查
	$this->login_check(2);
	$type = I('post.type');
	$model_user = M('user_student');
	if($type=='search'){
			$key = I('post.key');
			$class = I('post.class');
			$current_p = (I('post.p')?I('post.p'):1);
			$pagenum = 7;
			if(preg_match('/^U\d*$/',$key) or $key==''){
			//如果是学号号则按教工号查询
				$match_type = 'user';
			}else{
			//否则按姓名查询	
				$match_type = 'name';
			}
			
			if($class=='0'){
				$rs_user = $model_user->where("$match_type like '%$key%'")->limit($pagenum*($current_p-1),$pagenum)->select();	//搜索全部
				$page_total = ceil($model_user->where("$match_type like '%$key%'")->count()/$pagenum);
			}
			else {
				$rs_user = $model_user->where("class='$class' and $match_type like '%$key%'")->limit($pagenum*($current_p-1),$pagenum)->select();			//搜索指定班级
				$page_total = ceil($model_user->where("class='$class' and $match_type like '%$key%'")->count()/$pagenum);
			}
			
			$page = array(
				'total'=>$page_total,
				'current'=>$current_p
			);
			$r = array(
				'page'=>$page,
				'r'=>$rs_user
			);
			$this->ajaxReturn($r);
		
	}else if($type=='del'){
		$user = I('post.user');
		$rs_user = $model_user->where("user='$user'")->delete();
		if($rs_user)$msg = array(
					'status'=>1,
					'msg'=>'删除成功！'
				);
		else $msg=array(
					'status'=>0,
					'msg'=>'操作失败！'
				);
		$this->ajaxReturn($msg);	
	}else if($type=='update'){
		
		
	}else if($type=='view'){
		$user = I('post.user');
		$rs_user = $model_user->where("user='$user'")->select();
		$this->ajaxReturn($rs_user);
	}
		
	}
	public function student_edit(){
		$this->login_check(1);
		$model_sel = M('bs_kt_sel');
		$rs_sel = $model_sel->field('v')->where("k='class'")->select();
		$this->assign('class',$rs_sel[0]);
		if(I('get.user')!=null){
			$user = I('get.user');
			
			$model_user=M('user_student');
			if(count(I('post.'))){
			//更新数据
				$pwd= I('post.pwd');
				$pwd2 = I('post.pwd2');
				$data = I('post.');
				$data['status']=($data['status']=='1'?1:0);
				if(trim($pwd)!=trim($pwd2))$msg = '2次密码输入不一致，请重试！';
				else if(trim($pwd)=='')unset($data['pwd']);//为空则不需要更改密码
				else{
					//既不为空，2次密码也一致
					$d=array(
						'user'=>$user,
						'pwd'=>md5($pwd)
					);
					$model_pwd = M('user_student_pwd');
					$model_pwd->where("user='$user'")->save($d);
					
				}
				
				$rs_user = $model_user->where("user='$user'")->save($data);
				if($rs_user)$msg='更新成功！';
				else $msg = '更新失败！';
			}
			
			$rs_user = $model_user->where("user='$user'")->select();
			$rs_user[0]['msg']=isset($msg)?$msg:'';
			
			$this->assign('user',$rs_user[0]);
			$this->display('student_edit');
		}
		
	}
	//教师
	public function teacher(){
		$this->login_check(1);
		$user = public_user_id();
		$model_sel = M('bs_kt_sel');
		$rs_sel = $model_sel->field('v')->where("k='dep'")->select();
		$this->assign('dep',$rs_sel[0]);
		$this->assign('user',$user);
		$this->display();
	}
	//修改教师信息
	public function teacher_edit(){
		$this->login_check(1);
		$model_sel = M('bs_kt_sel');
		$rs_sel = $model_sel->field('v')->where("k='dep'")->select();
		$this->assign('dep',$rs_sel[0]);
		if(I('get.user')!=null){
			$user = I('get.user');
			$model_user=M('user_teacher');
			if(count(I('post.'))){
			//更新数据
				$pwd= I('post.pwd');
				$pwd2 = I('post.pwd2');
				$data = I('post.');
				$status = I('post.status');

				if(trim($pwd)!=trim($pwd2))$msg = '2次密码输入不一致，请重试！';
				else if(trim($pwd)=='')unset($data['pwd']);//为空则不需要更改密码
				else{
						$d=array(
						'user'=>$user,
						'pwd'=>md5($pwd),
								//'status'=> $status,//加入状态
					);
					$model_pwd = M('user_teacher_pwd');
					$model_pwd->where("user='$user'")->save($d);
					
				}
				//$tmp = $data['status'];
				$rs_user = $model_user->where("user='$user'")->save($data);
				if($rs_user)$msg='更新成功！';
					//echo $rs_user;
				else $msg = '更新失败！';
			}
			
			$rs_user = $model_user->where("user='$user'")->select();
			$rs_user[0]['msg']=isset($msg)?$msg:'';
			$this->assign('user',$rs_user[0]);

			
			$this->display('teacher_edit');
		}
		
	}
	public function teacher_handler(){
	//条件查找，删改,查
	$type = I('post.type');
	$model_user = M('user_teacher');
	if($type=='search'){
			$this->login_check(2);
			$key = I('post.key');
			$dep = I('post.dep');
			$current_p = (I('post.p')?I('post.p'):1);
			$pagenum = 7;
			if(preg_match('/^\d+$/',$key) or $key==''){
			//如果是教工号则按教工号查询
				$match_type = 'user';
			}else{
			//否则按姓名查询	
				$match_type = 'name';
			}
			
			if($dep=='0'){
				$rs_user = $model_user->where("$match_type like '%$key%'")->limit($pagenum*($current_p-1),$pagenum)->select();
				$page_total = ceil($model_user->where("$match_type like '%$key%'")->count()/$pagenum);
			}
			else{
				
					$rs_user = $model_user->where("dep='$dep' and $match_type like '%$key%'")->limit($pagenum*($current_p-1),$pagenum)->select();
					$page_total = ceil($model_user->where("dep='$dep' and $match_type like '%$key%'")->count()/$pagenum);
				
			}
			$page = array(
				'total'=>$page_total,
				'current'=>$current_p
			);
			$r = array(
				'page'=>$page,
				'r'=>$rs_user
			);
			$this->ajaxReturn($r);
		
	}else if($type=='del'){
		$this->login_check(2);
		$user = I('post.user');
		$rs_user = $model_user->where("user='$user'")->delete();
		if($rs_user)$msg = array(
					'status'=>1,
					'msg'=>'删除成功！'
				);
		else $msg=array(
					'status'=>0,
					'msg'=>'操作失败！'
				);
		$this->ajaxReturn($msg);	
	}else if($type=='update'){
		$this->login_check(2);
		
	}else if($type=='view'){
		//只要登录即可查看
		if(public_user_type()!=null){
			$user = I('post.user');
			$rs_user = $model_user->where("user='$user'")->select();
			$this->ajaxReturn($rs_user);
		}else $this->ajaxReturn(array('status'=>0,'msg'=>'必须登录！'));
	}
	
	}
	//管理员
	public function admin(){
		$this->login_check(1);
		$user = public_user_id();
		$this->assign('user',$user);
		$this->display();
	}
	public function admin_handler(){
			//查找，删除，修改
			$this->login_check(2);
			
			$type = I('post.type');
			$model_user = M('user_admin');
			if($type=='search'){
			$key = I('post.key');
			//$pages = $model_user->$model_user->where("user like '%$key%'")->count();
			$rs_user = $model_user->where("user like '%$key%'")->limit(0,10)->select();
			$this->ajaxReturn($rs_user);
			}else if($type=='del'){
				$user = I('post.user');
				$rs_user = $model_user->where("user='$user'")->delete();
				if($rs_user)$msg = array(
					'status'=>1,
					'msg'=>'删除成功！'
				);
				else $msg=array(
					'status'=>0,
					'msg'=>'操作失败！'
				);
				$this->ajaxReturn($msg);
			}else if($type=='update'){
				$user = I('post.user');
				if(I('post.pwd'))
				$data=array(
					'pwd'=>md5(I('post.pwd')),
					'status'=>(I('post.status')==1?1:0)
				);
				else $data=array(
					'status'=>(I('post.status')==1?1:0)
				);
				$rs_user= $model_user->where("user='$user'")->save($data);
				if($rs_user)$msg=array(
					'status'=>1,
					'msg'=>'更新成功！'
				);
				else $msg=array(
					'status'=>0,
					'msg'=>'操作失败！'
				);
				$this->ajaxReturn($msg);
			}
		
	}
}