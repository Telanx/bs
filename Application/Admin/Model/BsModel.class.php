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
					$sql = "select count(*) from bs_xt group by sid";
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
					$sql = "select count(*) from bs_kt where status=3";
				}else{
					$sql = "select count(*) from bs_kt";
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
		







//验证学号是否正确，并未选课题
        public function check_s($sid){
        $model_user = M('user_student');
        $model_xt = M('bs_xt');
        /**
        *1账号不存在或不可用
        *2已选课题
        */
        if($model_user->where("status=1 and user='$sid'")->count()==0)return 1;
        if($model_xt->where("sid='$sid'")->count())return 2;
        return 3;
        
        }
        
        //验证课题是否可选
        public function check_kt($ktId){
        $model_kt = M('bs_kt');
        $model_xt = M('bs_xt');
        /**
        *4课题未通过院系审核或不存在
        ＊５课题已被选
        */
        if($model_kt->where("id='$ktId' and status=3")->count()==0)return 4;
        if($model_xt->where("bid='$ktId'")->count()!=0)return 5;
        return 6;
        }
        public function xt($sid,$ktId){
        //先验证学号是否正确并且可选
        $rs = array(
        'status'=>1,
        'msg'=>'操作成功'
        );
        $cs = $this->check_s($sid);
        if($cs==3){
        $bs = $this->check_kt($ktId);
    if($bs==6){
        //绑定
        $this->bindkt($sid,$ktId);
        }else{
        //课题错误
        $rs['status'] = 0;
        if($bs==4)$rs['msg']="课题未通过审核或不存在！";
        else if($bs==5)$rs['msg']="课题已被选！";
        }
        }else{
        //学号错误
        $rs['status'] = 0;
        if($cs==1)$rs['msg']="学号不正确或者处于禁用状态";
        else if($cs==2)$rs['msg']="该生已选有其它课题，无法继续选择！";
        }
        return $rs;
        }
        
        ////绑定课题
        public function bindkt($sid,$bid){
        $model = M('bs_xt');
        $data = array(
        'bid'=>$bid,
        'sid'=>$sid,
        'time'=>date('Y-m-d H:i:s')
        );
        $model->data($data)->add();
        
        }
        
}
?>
