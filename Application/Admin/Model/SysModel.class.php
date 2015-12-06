<?php
namespace Admin\Model;
use Think\Model;
class SysModel extends Model{
	//选项保存
	private $logfile = "./log.txt";
	public function sel_save($k,$d){
		$model_sel = M('bs_kt_sel');
		$data_s = json_encode($d);
		$data = array(
			'v'=>$data_s
		);
		if($model_sel->where("k='$k'")->save($data))return 1;
		else return 0;
	}
	
	//获取时间
	public function getTime($k){
		$model_time  = M('sys_time');
		$rs_time = $model_time->field('v')->where("k='$k'")->select();
		return $rs_time[0]['v'];
		
	}
	
	//保存时间
	public function saveTime($data,$f,$user){
		
		//先检测是否存在，不存在则插入
		foreach($data as $e){
			$this->updateTime($e['k'],$e['v']);
		}
		if($f==1){//同步发送到动态里
				$model_news = M('home_news');
				$news = array(
					'id'=>null,
					'title'=>'选题时间更改通知',
					'author'=>$user,
					'publishtime'=>date('Y-m-d H:i:s'),
					'content'=>'毕业设计选题时间更新了！课题填报时间为'.$data[2]['v'].'~'.$data[3]['v'].'。选题开始时间为'.$data[0]['v'].'，截止时间为'.$data[1]['v'].'。选题日期截止后将无法进行选题或退选！'
				);
				$model_news->data($news)->add();
				
			}
		return 1;
	}
	
	//修改单条
	public function updateTime($k,$v){
		$model_time = M('sys_time');
		//先检查是否存在，不存在则插入
		$data = array(
			'k'=>$k,
			'v'=>$v
		);
		$f = $model_time->where("k='$k'")->select();
		if(count($f)){
			$model_time->where("k='$k'")->save($data);	
		}else{
			
			$data = array(
						'id'=>null,
						'k'=>$k,
						'v'=>$v
					);
				$model_time->add($data);
		}
		
	}
	
	/***进行初始化操作阶段***/
	//检测备份状态
	public function bkStatus(){
		$this->checkBF();
		$bkyear = $this->log('year','get','');
		$bdL = $this->log('backup','get','');
		$bdL = count($bdL);
		$year = date('Y');
		if($year!=$bkyear){
			$info = array(
				'code'=>0,
				'msg'=>$year.'届还未开始备份，请点击开始按钮开始备份'
			);
		}else if($bdL<5){
			$info = array(
				'code'=>1,
				'msg'=>$year.'届检测到您上次有备份未完成，点击开始按钮继续'
			);	
		}else{
			$info = array(
				'code'=>2,
				'msg'=>$year.'届检测到您已备份过，如果数据未清空，点击开始按钮初始化数据'
			);	
			
		}
		return $info;
	}
	//备份表
	public function backup($tb){
		//首先检查一遍旧表中删除旧数据
		$year = date('Y');
		$this->wipeold($tb,$year);
		//转移数据
		$model = new \Think\Model();
		//这个不会只好所有表结构都列一遍
		/////////2015-7-7目前就写到了这里了
		switch($tb){
			case 'bs_kt':$sql = "insert into bs_kt_old select null,name,type,way,origin,bs_kt.require,content,goal,snum,bsnum,fee,env,reference,status,teacher,2015 from bs_kt";break;
			case 'bs_student_log':$sql = "insert into bs_student_log_old select null,user,content,2015 from bs_student_log";break;
			case 'bs_xt':$sql = "insert into bs_xt_old select null,bid,sid,time,2015 from bs_xt";break;
			case 'user_student':$sql = "insert into user_student_old select null,user,name,class,status,qq,email,cellphone,pic,2015 from user_student";break;
			case 'user_teacher':$sql = "insert into user_teacher_old select null,user,name,dep,status,pic,email,qq,cellphone,officephone,bsnum,2015 from user_teacher";break;
		}
		$f=$model->query($sql);
		if(!($f===false)){
			//执行成功则写入记录
			$this->log("backup","add",$tb);
			return array(
				'status'=>1,
				'msg'=>'表'.$tb.'备份成功！'
			);
		}else {
			return array(
				'status'=>0,
				'msg'=>'表'.$tb.'备份失败！'
			);
			
		}
		
	}
	
	//清除旧表中的数据
	public function wipeold($tb,$year){
		$model = new \Think\Model();
		$sql = "delete from $tb"."_old"." where year=$year";
		if($model->query($sql))return 1;
		else return 0;
	}
	//清空表
	public function wipe($tb){
		$model = new \Think\Model();
		$sql = "delete from $tb";
		$f= $model->query($sql);
		if(!($f===false)){
			$msg = array(
				'status'=>1,
				'msg'=>'表'.$tb.'初始化成功！'
			);
			
		}else{
			$msg = array(
				'status'=>0,
				'msg'=>'表'.$tb.'初始化失败！'
			);
			
		}
		return $msg;
	}
	
	//备份记录
	/**日志格式
	{"year":"2015","backup":["user_student","bs_xt"]}
	$k-->键值
	$t-->类型包括get,update,add,delete
	**/
	public function log($k,$t,$s){
		$this->checkBF();
		switch($t){
			case 'get':$rs = $this->logget($k);break;
			case 'update':$rs = $this->logupdate($k,$s);break;
			case 'add':$rs = $this->logadd($k,$s);break;
			case 'del':$rs = $this->logdel($k);
		}
		return $rs;
	}
	//检查备份记录文件是否存在
	public function checkBF(){
		$file = $this->logfile;
		if(!file_exists($file)){
			//写入空
			
			$log = array(
				"year"=>"1970",
				"backup"=>array()
			);
			$logStr = json_encode($log);
			file_put_contents($file,$logStr);
		}
	}
	//获取某个字段
	public function logget($key){
		$file = $this->logfile;
		$logstr = file_get_contents($file);
		$log = json_decode($logstr,true);
		return $log[$key];
		
	}
	public function logupdate($key,$value){
		//$value可能为字符串或数组
		$file = $this->logfile;
		$f= fopen($file,'w+');
		$logstr = fread($f,filesize($file));
		$log = json_decode($logstr,true);
		$log[$key]=$value;
		$logStr = json_encode($log);
		$r = fwrite($logStr);
		fclose($f);
		return $r;
		
	}
	public function logadd($key,$value){
		//$value为字符串
		$file = $this->logfile;
		$year = date('Y');			//备份的年份
		$f= fopen($file,'r');
		$logstr = fread($f,filesize($file));
		fclose($f);
		$log = json_decode($logstr,true);
		//检查年份是否一致，一致则追加，不一致则置空
		
		if($log['year']==$year){			//追加
				//不存在则追加
				if(!in_array($value,$log[$key])){
					array_push($log[$key],$value);
				}
		}else{												//更新
				$log['year'] = $year;
				$log[$key] = array($value);
		}
		$logStr = json_encode($log);
		$r = file_put_contents($file,$logStr);
		return $r;
	}
	//清空某个字段
	//就是将某个字段设置为空数组
	public function logdel($key){
		return $this->logupdate($key,array());
	}
	
	//初始化状态
	public function checkStatus(){
		$file = './backup.log';
		if(file_exists($file)){
			//读取备份数据
			$s=file_get_contents($file);
			$status = json_decode($s);
			return $status;
		}else{
			return 0;
		}
		
	}
	
}

?>