<?php
// 自动测试模块
namespace Home\Controller;
use Think\Controller;
class TestController extends Controller {
	public function getTeacher(){
		//获取全部教师信息
		$model  = M('user_teacher');
		$rs = $model->field(array('user','name','dep'))->select();
		//课题信息
		for($j=0;$j<count($rs);$j++){
			$user = $rs[$j]['user'];	//教师名
			$name = $rs[$j]['name'];//姓名
			$dep = $rs[$j]['dep']; //单位
			//var_dump($rs[$j]);
			echo '<p>'.$user.$name.$dep.'</p>';
			for($i=1;$i<=4;$i++){
				
				$data = array(
					'id'=>null,
					'name'=>$user.'课题'.$i,
					'type'=>'工程设计',
					'way'=>'结合科研',
					'origin'=>'自选课题',
					'require'=>'要求',
					'content'=>'内容',
					'goal'=>'目标',
					'snum'=>1,
					'bsnum'=>1,
					'fee'=>1,
					'env'=>'个人电脑，服务器',
					'reference'=>'参考资料',
					'status'=>2,
					'teacher'=>$user
				);	
				$model_kt = M('bs_kt');
				if($model_kt->add($data)){
					echo '第'.$i.'条记录插入成功';
				}
			}
			
		}
		
	}
	//选题测试
	public function xt(){
	//传入用户名user，课题tid	
	//$user = I('post.user');	//用户
	//$bid = I('post.bid');			//课题ID
	$user ='U201114'.rand(100,599);
	$bid = rand(15,706);
		if(!($this->is_selected($user))){
			//选择课题
			var_dump($this->xt2($user,$bid));
		}else{
			echo '已选';
		}	
	}
	//真正选题
	public function xt2($user,$bid){
		$model_xt = M('bs_xt');
		//选择该课题的人数
		$n1= $model_xt->where("bid=$bid")->count();
		//该课题需要人数
		$model_kt = M('bs_kt');
		$n2 = $model_kt->field("snum")->where("id=$bid")->select();
		$n2=$n2[0]['snum'];
		if($n1<$n2){
			$data=array(
				'id'=>'',
				'bid'=>$bid,
				'sid'=>$user,
				'time'=>date('Y-m-d H:i:s')
			);
			if($model_xt->data($data)->add())
			$msg=array(
				'status'=>1,
				'msg'=>'选课成功！'
			);
			else $msg=array(
				'status'=>1,
				'msg'=>'选课失败！'
			);
		}else{
			$msg=array(
				'status'=>0,
				'msg'=>'该课题人数已满！'
			);
		}
		return $msg;
	}
	//查看某一用户是否选择了课题
	public function is_selected($user){
		$model_xt = M('bs_xt');
		if($model_xt->where("sid='$user'")->count())return 1;
		else return 0;
	}
		
	//插入学生用户
	public function user(){
		$model = M('user_student');
		for($i=100;$i<600;$i++){
			$u = 'U201114'.$i;
			$data = array(
				'user'=>$u,
				'name'=>'某'.$u,
				'pwd'=>'123456',
				'class'=>'计科1班',
				'status'=>1,
				'qq'=>null,
				'email'=>null,
				'cellphone'=>null,
				'pic'=>null
			);
			if($model->add($data)){
				echo '新增用户'.$u;
			}
		}
		
	}
	
	//sql语句测试
	public function sql(){
		$model =new  \Think\Model();
		$sql = 'insert into home_pic values(1,2,3,4,5,6,6)';
		var_dump($model->query($sql));
		
	}
}