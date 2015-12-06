<?php
// 本类由系统自动生成，仅供测试用途
namespace Home\Controller;
use Think\Controller;
class StartController extends Controller {
	//表的初始化
	/**1.用户表及历史
		user_student、user_student_old、user_teacher、user_teacher_old、user_admin
		2.课题表以及选题表
		bs_kt、bs_kt_old、bs_xt、bs_xt_old、bs_student_log、bs_student_log_old
		3.首页数据
		home_doc、home_plan、home_pic、home_link、home_news
		4.系统配置
		sys_time(选题时间表)、bs_kt_sel
		**/
	protected $tabeConfig = array(
		//用户数据
		'user_student'=>'create table if not exists user_student(user text,name text,pwd text,class text,status bit(1),qq text,email text,cellphone text,pic text)',
		'user_teacher'=>'',
		'user_admin'=>'',
		//毕设
		'bs_kt'=>'',
		'bs_xt'=>'',
		//首页数据
		'home_doc'=>'',
		'home_plan'=>'',
		'home_news'=>'',
		'home_link'=>'',
		'home_pic'=>'',
		//系统配置
		'bs_kt_sel'=>'',
		'sys_time'=>'',
		//历史数据
		'user_student_old'=>'create table if not exists user_student(user text,name text,pwd text,class text,status bit(1),qq text,email text,cellphone text,pic text,year char(4))',
		'user_teacher_old'=>'',
		'user_kt_old'=>'',
		'user_xt_old'=>'',
		'user_student_log_old'=>''
	);
	public function setup(){
		$this->display();
	}
	
	//初始化表
	public function init(){
		if(I('post.type')){
			$table = I('post.table');
			//$sql = 
			
		}else{
			$error = array(
				'status'=>0,
				'msg'=>'Access denied!'
			);
		}
		
	}
}