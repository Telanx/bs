<?php
namespace Teacher\Model;
use Think\Model;
class KtManagerModel extends Model{
	protected $trueTableName = 'bs_kt';
	
	//课题搜索
	//查询和更新功能
		/**传入参数
		*type	--类型
		--------查询------
		*d		--实验室
		*s		--全部0或未审核1
		*p		--翻页
		-------更新--------
		*id[]		--课设ID列表
		*/
	public function search($para,$authType){
		//$authType可能为2系主任或者3院长
		$ktStatus = (int)$authType;
		if($para['s']==0){
		//搜索全部	
			$s = 'bs_kt.status='.($authType-1)." or bs_kt.status=".$authType;
		}else{
			$s = 'bs_kt.status='.($authType-1);
		}
		//根据实验室分类
	
		if($para['d']=='0'){
			$d = '1=1';
		}else{
			$dep = $para['d'];
			$d="user_teacher.dep='$dep'";
			
		}
			
		$np =10;	//每页数
		$cp = (int)$para['p'];//当前页
		$sql1="select count(*) from bs_kt inner join user_teacher on bs_kt.teacher=user_teacher.user where bs_kt.status>0 and ".$d." and ".$s;
		$sql2 = "select bs_kt.id,bs_kt.name as bname,bs_kt.teacher,bs_kt.status,user_teacher.name as tname,user_teacher.dep from bs_kt inner join user_teacher on bs_kt.teacher=user_teacher.user where bs_kt.status>0 and ".$d." and ".$s.' limit '.($np*($cp-1)).','.$np.'';
		//自定义执行sql语句
		$Model =  new \Think\Model();
		$tp = $Model->query($sql1)[0]['count(*)'];
		$rs_kt = $Model->query($sql2);
		
		$rs = array(
			'para'=>$para,
			'sql'=>$sql1,
			'page'=>array(
				'tp'=>$tp,
				'c_p'=>$cp,
				't_p'=>ceil(1.0*$tp/$np)
			),
			'r'=>($rs_kt?$rs_kt:array())
		);
		return $rs;
	}
	
	//课题审核,分为2种，一种是系主任审核2，一种是院长审核3
	public function edit($para,$authType){
		$list = $para['list'];
		$list_str = join(',',$list);
		$sql = 'update bs_kt set status='.$authType.' where status='.((int)$authType-1).' and id in ('.$list_str.')';
		$Model = new \Think\Model();
		try{
			$Model->query($sql);
			$msg=array(
			'status'=>1,
			'msg'=>'操作成功！'
		);
		}catch(Exception $e){
			$e->getMessage();
			$msg=array(
				'status'=>0,
				'msg'=>$e
			);
		}	
		return $msg;
	}
	//取消批分2种是系主任审核2>1，一种是院长审核3>2
	public function unedit($para,$authType){
		$list = $para['list'];
		$list_str = join(',',$list);
		$sql = 'update bs_kt set status='.((int)$authType-1).' where id in ('.$list_str.') and id not in(select bid from bs_xt)';
		$Model = new \Think\Model();
		try{
			$Model->query($sql);
			$msg=array(
			'status'=>1,
			'msg'=>'操作成功！'
		);
		}catch(Exception $e){
			$e->getMessage();
			$msg=array(
				'status'=>0,
				'msg'=>$e
			);
		}	
		return $msg;
	}
	
}

?>