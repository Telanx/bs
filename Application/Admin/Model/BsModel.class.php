<?php
namespace Admin\Model;
use Think\Model;
class BsModel extends Model{
/**
*查询学生人数已选和全部
*查询教师人数
*查询课题审核数目
*/
		public function queryStudentNum($t){
				$num = 0;
				if($t==1){	//查询已选课题的学生人数
					$sql = "select count(*) from bs_xt";
				}else{			//查询所有
					$sql = "select count(*) from user_student";
				}
				$model = new \Think\Model();
				$rs = $model->query($sql);
				return $rs[0]['count(*)'];
		}
		
		public function queryTeacherNum(){
			$model = M('user_teacher');
			$rs = $model->count();
			return $rs;
		}
		
		public function queryKtNum($t){
				if($t==1){
					$sql = "select count(*) from bs_kt where status=2";
				}else{
					$sql = "select count(*) from bs_kt where status=1";
				}
				$model = new \Think\Model();
				$rs = $model->query($sql);
				return $rs[0]['count(*)'];
		}
		
		
		//根据条件查询已通过院系审核状态为3的课题
		public function search($para){
		
		$k = "bs_kt.name like '%".$para['k']."%'";
		//根据实验室分类
		
		if($para['d']=='0'){
			$d = '1=1';
		}else{
			$dep = $para['d'];
			$d="user_teacher.dep='$dep'";
			
		}
		/**查询sql语句
		select bs_kt.id,bs_kt.name as bname,bs_kt.snum,user_teacher.name as tname,user_teacher.dep,count(bs_xt.bid) from bs_kt left join user_teacher on user_teacher.user=bs_kt.teacher left join bs_xt on bs_xt.bid=bs_kt.id group by bs_kt.id
		select bs_kt.id,bs_kt.name as bname,bs_kt.snum,user_teacher.name as tname,user_teacher.dep,count(bs_xt.bid) from bs_kt left join user_teacher on user_teacher.user=bs_kt.teacher left join bs_xt on bs_xt.bid=bs_kt.id where bs_kt.status=1 and bs_kt.name like '%安%' group by bs_kt.id 
		*/
		$np =10;	//每页数
		$cp = (int)$para['p'];//当前页
		$sql1="select count(*) from bs_kt inner join user_teacher on bs_kt.teacher=user_teacher.user where ".$d." and ".$k." and bs_kt.status=3";
		$sql2 = "select bs_kt.id,bs_kt.name as bname,bs_kt.teacher as tuser,user_teacher.name as tname,user_teacher.dep,user_student.user as suser,user_student.name as sname from bs_kt".
			" left join user_teacher on bs_kt.teacher=user_teacher.user".
			" left join user_student on user_student.user in (select sid from bs_xt where bs_xt.bid = bs_kt.id)".
			" where ".$d." and ".$k." and bs_kt.status=3 group by bs_kt.id limit ".($np*($cp-1)).','.$np.'';
		//自定义执行sql语句
		$Model =  new \Think\Model();
		$tp = $Model->query($sql1)[0]['count(*)'];
		$rs_kt = $Model->query($sql2);
		
		$rs = array(
			'page'=>array(
				'sql'=>$sql2,
				'tp'=>$tp,
				'c_p'=>$cp,
				't_p'=>ceil(1.0*$tp/$np)
			),
			'r'=>($rs_kt?$rs_kt:array())
		);
		return $rs;
	}
		
	
}
?>