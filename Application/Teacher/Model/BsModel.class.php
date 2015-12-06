<?php
namespace Teacher\Model;
use Think\Model;
class BsModel extends Model{
		/****学生进度日志报告***/
		/**获取教师所选学生名单**/
		public function getStudentList($tid){
			$model = new \Think\Model();
			$sql = "select bs_xt.bid,bs_xt.sid,user_student.name as sname,bs_kt.name as bsname from bs_xt left join user_student on bs_xt.sid=user_student.user  left join bs_kt on bs_kt.id=bs_xt.bid where bid in(select id from bs_kt  where teacher='$tid')";
			$rs_list = $model->query($sql);
			return $rs_list;
		}
		
		/**获取某个学生的日志信息***/
		public function getLog($sid,$tid){
		//首先验证sid和tid是否是属于被选关系，如不是返回空
			$logList = array();
			if(!$this->checkST($sid,$tid))return $logList;
			/****此处还未完成，请稍后***/
			$model = new \Think\Model();
			$sql = "select content from bs_student_log where user='$sid'";
			$rs = $model->query($sql);
			$rs_s = $rs[0]['content'];
			$rs_a = json_decode($rs_s,1);
			
			$log_arr=array();
			if(count($rs_a)){
				for($i=count($rs_a)-1;$i>=0;$i--){
					$log_s = $rs_a[$i];
					$log_s['ct'] = preg_replace('/\n/i','<br>',$rs_a[$i]['ct']);
					
					array_push($log_arr,$log_s);
				}
			}
			return $log_arr;
			
		}
		/***获得学生课题基本信息**/
		public function getInfo($sid){
			$model = new \Think\Model();
			$sql ="select bs_kt.name as bsname,user_student.name as sname from bs_xt left join bs_kt on bs_kt.id = bs_xt.bid left join user_student on user_student.user=bs_xt.sid where sid='$sid'";
			$rs_info = $model->query($sql);
			return $rs_info[0];
			
		}
		/**检查sid,tid之间被选关系**/
		public function checkST($sid,$tid){
			$model = new \Think\Model();
			$sql = "select * from bs_xt where sid='$sid' and bid in(select id from bs_kt where teacher='$tid')";
			$rs = $model->query($sql);
			if(!count($rs))return 0;
			else return 1;
			
		}
}

?>