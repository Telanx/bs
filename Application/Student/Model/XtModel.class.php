<?php
namespace Student\Model;
use Think\Model;
class XtModel extends Model{
	protected $trueTableName = 'bs_kt';
	//查看是否已选课题
	//传入参数用户名
	public function is_selected($user){
		$model_xt = M('bs_xt');
		if($model_xt->where("sid='$user'")->count())return 1;
		else return 0;
	}
	//获取自己选的课题
	public function mykt($user)
	{
		$Model = new \Think\Model();
		$sql = "select bs_xt.bid,bs_xt.time,bs_kt.name as bname,bs_kt.type,user_teacher.user as tid,user_teacher.name as tname,user_teacher.cellphone from bs_kt left join user_teacher on bs_kt.teacher=user_teacher.user right join bs_xt on bs_xt.bid=bs_kt.id where bs_xt.sid='$user'";
		$rs_xt = $Model->query($sql);
		return $rs_xt[0];
	}
	//删除已选课题
	public function del($user){
		$model_xt = M('bs_xt');
		$rs_xt = $model_xt->where("sid='$user'")->delete();
		if($rs_xt)$msg=array(
			'status'=>1,
			'msg'=>'删除成功！'
		);
		else $msg = array(
			'status'=>0,
			'msg'=>'删除失败！'
		);
		return $msg;
		
	}
	//课题搜索
	//选题功能
		/**传入参数
		*type	--类型
		--------查询------
		*d		--实验室
		*k		--课题关键字
		*p		--翻页
		-------选题--------
		*id	--课设ID列表
		*/
	public function search($para){
		
		$k = "(bs_kt.name like '%".$para['k']."%' or user_teacher.name like '%".$para['k']."%')";
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
		$sql2 = "select bs_kt.id,bs_kt.name as bname,bs_kt.snum,bs_kt.teacher as user,user_teacher.name as tname,user_teacher.dep,count(bs_xt.bid) as num from bs_kt left join user_teacher on bs_kt.teacher=user_teacher.user left join bs_xt on bs_kt.id=bs_xt.bid  where ".$d." and ".$k." and bs_kt.status=3 group by bs_kt.id limit ".($np*($cp-1)).','.$np.'';
		//自定义执行sql语句
		$Model =  new \Think\Model();
		$tp = $Model->query($sql1)[0]['count(*)'];
		$rs_kt = $Model->query($sql2);

		shuffle($rs_kt);
		
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
	
	//选题,传入参数bid课题id
	public function edit($para){
	/***
	*查询是否有选过课题
	*判断该课题是否可选
	*选择该课题
	***/
		$bid = (int)$para['bid'];//课题号
		$sid=isset($para['sid'])?$para['sid']:'U201114175';//学号
		$model_xt = M('bs_xt');
		//选择该课题的人数
		$n1= $model_xt->where("bid=$bid")->count();
		//自己是否已经选过
		$n3 = $model_xt->where("sid='$sid'")->count();
		//该课题需要人数
		$model_kt = M('bs_kt');
		$n2 = $model_kt->field("snum")->where("id=$bid")->select();
		$n2=$n2[0]['snum'];
		
		
		if($n1<$n2&&($n3==0)){
			
			$data=array(
				'id'=>'',
				'bid'=>$bid,
				'sid'=>$sid,
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
		}else if($n3>0){
			$msg=array(
				'status'=>0,
				'msg'=>'您已经选过了，无法继续选择！'
			);
		}else{
			$msg=array(
				'status'=>0,
				'msg'=>'该课题人数已满！'
			);
		}
		return $msg;
	}
	
	//查看课题信息
	//传入参数id
	//返回参数
	/**
	*课题名
	*require
	*goal
	*type
	*way
	*指导老师名
	*指导老师所在单位
	*指导老师联系方
	*/
	public function view($para)
	{
		$id = (int)$para;
		$Model = new \Think\Model();
		$sql = "select bs_kt.name as bname,bs_kt.require,bs_kt.type,bs_kt.way,bs_kt.content,bs_kt.goal,user_teacher.name as tname,user_teacher.dep,user_teacher.email from bs_kt left join user_teacher on bs_kt.teacher=user_teacher.user where bs_kt.id=$id";
		$rs_kt = $Model->query($sql);
		return $rs_kt[0];	
	}
}

?>