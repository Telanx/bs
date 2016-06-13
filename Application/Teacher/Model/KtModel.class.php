<?php
namespace Teacher\Model;
use Think\Model;
class KtModel extends Model{
	protected $trueTableName = 'bs_kt';
	protected $_validate = array(
		array('name','require','�������Ʋ���Ϊ�գ�'),
		array('type','require','�������Ͳ���Ϊ�գ�'),
		array('way','require','���ⷽʽ����Ϊ�գ�'),
		array('origin','require','����������Ϊ�գ�'),
		array('require','require','Ŀ��Ҫ����Ϊ�գ�'),
		array('content','require','���ݲ���Ϊ�գ�'),
		array('goal','require','Ԥ��Ŀ�겻��Ϊ�գ�'),
		
		array('snum','/\d/','ѧ������Ϊ������'),
		array('env','require','ʵ����������Ϊ�գ�'),
		array('reference','','�ο����ϲ���Ϊ�գ�'),
		array('teacher','/\d{7}/','��ʦIDΪ7λ����')
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
					'msg'=>'��֤�ɹ���'
				);
				
			}
			return $info;
	}
	//ɾ������,�������$user,$list
	//����0,1
	public function del($user,$list){
		$model = new \Think\Model();
		$list_s = join(',',$list);
		$sql = "delete from bs_kt where status=0 and teacher='$user' and id in (".$list_s.")";
		if($model->query($sql))return 1;
		else return 0;
	}
	//�ϱ����⣬�������$user,$list
	//����0,1
	public function report($user,$list){
		$model = new \Think\Model();
		$list_s = join(',',$list);
		$sql = "update bs_kt set status=1 where status=0 and teacher='$user' and id in (".$list_s.")";
		if($model->query($sql))return 1;
		else return 0;
		
	}
	
	//ȡ���ϱ�
	public function cancel($user,$list){
		$model = new \Think\Model();
		$list_s = join(',',$list);
		$sql = "update bs_kt set status=0 where status=1 and teacher='$user' and id in (".$list_s.")";
		if($model->query($sql))return 1;
		else return 0;
		
		
	}
	
}

?>