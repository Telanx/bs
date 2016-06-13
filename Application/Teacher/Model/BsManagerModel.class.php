<?php
namespace Teacher\Model;
use Think\Model;
class BsManagerModel extends Model{
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
		
	
}
?>