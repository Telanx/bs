<?php
namespace Admin\Model;
use Think\Model;
class IndexModel extends Model{
	public function initCheck(){
		//检查选项以及选题时间是否设置
		//4个选项，2个事件
		$tb_sel = 'bs_kt_sel';
		$tb_time = 'sys_time';
		$sel_a = array("class","dep","bstype","bsway");
		$time_a = array('xt_start','xt_end');
		$s=4;
		$t=2;
		foreach($sel_a as $e){
			if($this->check($e,$tb_sel))$s--;
		}
		
		foreach($time_a as $e){
			if($this->check($e,$tb_time))$t--;
		}
		return array(
			's'=>$s,
			't'=>$t
		);
	}
	
	//检查是否存在
	public function check($k,$tb){
		$model = M($tb);
		$rs = $model->where("k='$k'")->select();
		return count($rs);
	}
}

?>