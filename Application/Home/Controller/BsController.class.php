<?php
// 本类由系统自动生成，仅供测试用途
namespace Home\Controller;
use Think\Controller;
class BsController extends Controller {
	//查看报审表以及任务书
	public function viewkt(){
		//$bid = I('get.bid');
		$bid = I('get.bid','','string');
		preg_match_all ("/\d+/", $bid, $m);
		//dump($m);
		$model_kt = new \Think\Model();
		//$sentence =
		$rs_kt = array();
		for($i=0;$i<count($m[0]);$i++)
		{
            //echo($m[0][$i]);
			$push_data = $model_kt->query("select bs_kt.*,user_teacher.name as
		tname,user_teacher.officephone,user_teacher.email
		from bs_kt left join user_teacher on bs_kt.teacher=user_teacher.user where bs_kt.id=".$m[0][$i]);
			//dump($push_data);
			array_push($rs_kt,$push_data[0]);
			//dump($push_data);
			//print_r($m);
			//dump($m[$i]);

		}
		/*
		$rs_kt = $model_kt->query("select bs_kt.*,user_teacher.name as
		tname,user_teacher.officephone,user_teacher.email
		from bs_kt left join user_teacher on bs_kt.teacher=user_teacher.user where id=".$m[0][0]);*/
		//dump($rs_kt);
		$this->assign('kt',$rs_kt);
		$this->display();
	}
	
	//查看任务书
	public function viewrw(){
		$bid = I('get.bid');
		$sid = I('get.sid');
		//加入权限判定则通过登录用户
		$model_user = M('user_student');
		$rs_user = $model_user->where("user='$sid'")->select();
		$this->assign('user',$rs_user[0]);
		$model_kt = new \Think\Model();
		$sql = "select bs_kt.*,user_teacher.name as tname from bs_kt left join user_teacher on bs_kt.teacher=user_teacher.user where bs_kt.id=$bid";
		$rs_kt = $model_kt->query($sql);
		$this->assign('kt',$rs_kt[0]);
		$this->display();
	}
	
	//获取列表
	public function getSel(){
		$k=I('get.k');
		$model_sel = M('bs_kt_sel');
		$rs_sel = $model_sel->field('v')->where("k='$k'")->select();
		$this->ajaxReturn($rs_sel[0]);
	}
}
