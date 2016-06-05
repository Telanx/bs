<?php
namespace Student\Model;
use Think\Model;
class LogModel extends Model{
	//学生提交日志报告
	protected $trueTableName = 'bs_student_log';
	
	/**获取日志历史记录
	*传入参数 $user  用户名
	*返回 Array Log  日志列表
	***/
	public function getLog($user){
		$contentArr = $this->field('content')->where("user='$user'")->select();
		$logArr = Array();
		if($contentArr){		//存在该表
				$contentStr = $contentArr[0]['content'];
				$ctArr = json_decode($contentStr,true);
				if($ctArr){
					$logArr = $ctArr;
				}
			
		}
		return $logArr;
	}
	/**获取单条日志信息***/
	public function getSingleLog($user,$id){
		$logArr = $this->getLog($user);
		for($k=0;$k<count($logArr);$k++){
			if($logArr[$k]['id']=='$id')return $logArr[$k];
		}
		return null;
	}
	/**添加日志记录
	*传入参数用户名 $user,数据
	*返回 0,1
	***/
	public function addLog($user,$str){
			//首先获取日志
			$logArr = $this->getLog($user);
			$log = Array(
				'id'=>0,
				'time'=>date('Y-m-d'),
				'ct'=>$str
			);
			if(count($logArr)){
				//获取列表中最大值
				$log['id']=$this->getMaxId($logArr)+1;
				$newLogArr = $logArr;
				array_push($newLogArr,$log);
			}else{
				$newLogArr = Array(
					'0'=>$log
				);
			}
			return $this->updateLog($user,$newLogArr);
	}
	
	//获取id最大值
	public function getMaxId($arr){
		$id = 0;
		for($i=0;$i<count($arr);$i++){
			$e_id = $arr[$i]['id'];
			if($e_id>=$id)$id=$e_id;
		}
		return $id;
	}
	/***说明***
	修改以及删除加入时间判断
	***/
	public function checkTime($ts){
		$now = date('Y-m-d');	
		if(strtotime($now)>strtotime($ts))return 0;
		else return 1;
	}
	/**删除日志
	*传入$user,$id
	*/
	public function delLog($user,$id){
		$logArr = $this->getLog($user);
		//先遍历找出index
		$index = -1;
		$newLogArr = Array();
		$f=0;
		$ts='1970-01-01';
		/**foreach($i as $logArr){
			if($logArr[$i]['id']==$id){
				$index=$i;
				$ts = $logArr[$i]['time'];
				$f = $this->checkTime($ts);
				#unset($logArr[$i]);
				#break;
			}else array_push($newLogArr,$logArr[$i]);
		}***/
		for($k=0;$k<count($logArr);$k++){
			if($logArr[$k]['id']==$id){
				$index++;
				$ts = $logArr[$k]['time'];
				$f = $this->checkTime($ts);
			}else{
				array_push($newLogArr,$logArr[$k]);
			}
			
		}
		
		if($index>-1 && $f){
			
			return $this->updateLog($user,$newLogArr);
		}
		return 0;
	}
	
	/**修改日志
	*传入$user,$str,$id
	*/
	public function modifyLog($user,$id,$str){
		$logArr = $this->getLog($user);
		//先遍历找出index
		$index = -1;
		$f=0;
		/****这里还需要改一下***/
		/**
		foreach($i as $logArr){
			if($logArr[$i]['id']==$id){
				$index++;
				$logArr[$i]['ct'] = $str;
				$ts = $logArr[$i]['time'];
				$f = $this->checkTime($ts);
				break;
			}
		}**/
		for($i=0;$i<count($logArr);$i++){
			$ts = $logArr[$i]['time'];
			$f = $this->checkTime($ts);
			if($logArr[$i]['id']==$id && $f){
				$index++;
				$logArr[$i]['ct'] = $str;
				break;
			}
		}
		if($index>-1){
			return $this->updateLog($user,$logArr);
		}else return 0;
	}
	/***更新操***/
	public function updateLog($user,$logArr){
		$logStr = json_encode($logArr);
		//是否存在，存在就直接更新，不存在则插入
		if(count($this->getLog($user))){
			$rs_update = $this->where("user='$user'")->setField('content',$logStr);
			if($rs_update!=false)return 1;
			else return 0;
		}
		else{	//不存在则插入
			$data = array(
				'id'=>null,
				'user'=>$user,
				'content'=>$logStr
			);
			$rs_create = $this->add($data);
			if($rs_create==false)return 0;
			else return 1;
		}
		
	}
}

?>