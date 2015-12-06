<?php
namespace Teacher\Model;
use Think\Model;
class KtModel extends Model{
	protected $trueTableName = 'bs_kt';
	protected $_validate = array(
		array('name','require','课题名称不能为空！'),
		array('type','require','课题类型不能为空！'),
		array('way','require','课题方式不能为空！'),
		array('origin','require','课题名不能为空！'),
		array('require','require','目的要求不能为空！'),
		array('content','require','内容不能为空！'),
		array('goal','require','预期目标不能为空！'),
		
		array('snum','/\d/','学生人数为整数！'),
		array('env','require','实验条件不能为空！'),
		array('reference','','参考资料不能为空！'),
		array('teacher','/\d{7}/','教师ID为7位数！')
	);
	public function kt_add(){
			$info = array();
			if(!$this->create()){
				$info = array(
					'status'=>0,
					'msg'=>$this->getError()
				);
				
			}else{
				$info = array(
					'status'=>1,
					'msg'=>'验证成功！'
				);
				
			}
			return $info;
	}
	//删除课题,传入参数$user,$list
	//返回0,1
	public function del($user,$list){
		$model = new \Think\Model();
		$list_s = join(',',$list);
		$sql = "delete from bs_kt where status=0 and teacher='$user' and id in (".$list_s.")";
		if($model->query($sql))return 1;
		else return 0;
	}
	//上报课题，传入参数$user,$list
	//返回0,1
	public function report($user,$list){
		$model = new \Think\Model();
		$list_s = join(',',$list);
		$sql = "update bs_kt set status=1 where status=0 and teacher='$user' and id in (".$list_s.")";
		if($model->query($sql))return 1;
		else return 0;
		
	}
	
	//取消上报
	public function cancel($user,$list){
		$model = new \Think\Model();
		$list_s = join(',',$list);
		$sql = "update bs_kt set status=0 where status=1 and teacher='$user' and id in (".$list_s.")";
		if($model->query($sql))return 1;
		else return 0;
		
		
	}
	
}

?>