<?php
namespace Teacher\Model;
use Think\Model;
class BsModel extends Model{
		/****ѧ��������־����***/
		/**��ȡ��ʦ��ѡѧ������**/
		public function getStudentList($tid){
			$model = new \Think\Model();
			$sql = "select bs_xt.bid,bs_xt.sid,user_student.name as sname,bs_kt.name as bsname from bs_xt left join user_student on bs_xt.sid=user_student.user  left join bs_kt on bs_kt.id=bs_xt.bid where bid in(select id from bs_kt  where teacher='$tid')";
			$rs_list = $model->query($sql);
			return $rs_list;
		}
		
		/**��ȡĳ��ѧ������־��Ϣ***/
		public function getLog($sid,$tid){
		//������֤sid��tid�Ƿ������ڱ�ѡ��ϵ���粻�Ƿ��ؿ�
			$logList = array();
			if(!$this->checkST($sid,$tid))return $logList;
			/****�˴���δ��ɣ����Ժ�***/
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
		/***���ѧ�����������Ϣ**/
		public function getInfo($sid){
			$model = new \Think\Model();
			$sql ="select bs_kt.name as bsname,user_student.name as sname from bs_xt left join bs_kt on bs_kt.id = bs_xt.bid left join user_student on user_student.user=bs_xt.sid where sid='$sid'";
			$rs_info = $model->query($sql);
			return $rs_info[0];
			
		}
		/**���sid,tid֮�䱻ѡ��ϵ**/
		public function checkST($sid,$tid){
			$model = new \Think\Model();
			$sql = "select * from bs_xt where sid='$sid' and bid in(select id from bs_kt where teacher='$tid')";
			$rs = $model->query($sql);
			if(!count($rs))return 0;
			else return 1;
			
		}
}

?>