<?php
namespace Admin\Model;
use Think\Model;
class UserModel extends Model{
	//从文件中导入
	public function account_file($type,$s_a){
		
		if($type=='s'){
			$model = M('user_student');
			$field = "class";
			$reg_str='/^U\d{9}$/';
		}
		else if($type=='t'){
			$model = M('user_teacher');
			$field = "dep";
			$reg_str='/^\d{7}$/';
		}
		//去除开头的BOM
		if($s_a&&$s_a[0]){
			$s_a[0] = trim($s_a[0],"\xEF\xBB\xBF");
		}
		$acc_length = count($s_a);
		$acc_list = array();
		$user = array();
		$acc_list = array();
		foreach($s_a as $acc_s_str){
			list($a,$b,$c) = split(';',$acc_s_str);
			$acc = array(
					"user"=>trim($a),
					$field=>trim($b),
					"name"=>trim($c),
					"status"=>1
				);
			if(preg_match($reg_str,trim($a))){
				array_push($acc_list,$acc);
			}else array_push($user,"if(preg_match($reg_str,".trim($a)."))");
		}
		$op_f = $model->addAll($acc_list);
		$acc_valid_length = count($acc_list);
		if($op_f)$ss = "成功导入".$acc_valid_length."个账号！";
		else $ss = "部分账号未导入成功，可能原因：已经存在该账号！";
		return  array(
			"code"=>1,
			"msg"=>"共".$acc_length."个账号，其中合法账号".$acc_valid_length."个。".$ss
		);
		
	}
}
?>