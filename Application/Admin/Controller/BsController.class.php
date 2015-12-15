<?php
// 本类由系统自动生成，仅供测试用途
namespace Admin\Controller;
use Think\Controller;
class BsController extends Controller {
	//身份验证
	public function login_check($t){
		if(public_user_type()!=3){
			if($t==1){
				//直接跳转
				$this->error('请先登录后操作！',U('Home/Login/index'),3);
			}
			else if($t==2){
				//ajax返回
				$msg=array(
					'status'=>0,
					'msg'=>'未登录，无法操作'
				);
				$this->ajaxReturn($msg);
			}
		}
	}
	//毕设数据统计
	
	public function preview(){
		$this->login_check(1);
		$user = public_user_id();
		
		
		$this->assign('user',$user);
		//查询学生、教师、课题数
		$model = D("Bs");
		$snum1 = $model->queryStudentNum(1);
		$snum2 = $model->queryStudentNum(2);
		
		$tnum = $model->queryTeacherNum();
		
		$knum1 = $model->queryKtNum(1);
		$knum2 = $model->queryKtNum(2);
		$rs = array(
			"snum1"=>$snum1,
			"snum2"=>$snum2,
			"tnum"=>$tnum,
			"knum1"=>$knum1,
			"knum2"=>$knum2
		);
		//var_dump($rs);
		
		$this->assign("rs",$rs);
		$ttype = public_user_ttype();
		$this->assign("ttype",$ttype);
		$this->display();
	}
	//查看课题
	public function view(){
		
		$this->login_check(1);
		$this->assign("user",public_user_id());
		$this->display();
	}
	
	public function kt_handler(){
		$this->login_check(2);
		$type=I('post.t');//类型
		$model_kt = D('Bs');
		$post = I('post.');
		if($type=='search'){
		//查询
			$rs_kt = $model_kt->search(I('post.'));
		}
		$this->ajaxReturn($rs_kt);
		
	}

    public function assign_kt(){
        $ass_post = I('post.');
        //dump($ass_post);
        $model = M('bs_xt');
        $stu_sid = I('post.sid');
        $kt_bid = I('post.bid');
        $model_kt = new \Think\Model();
        $search_result=$model->where("sid='$stu_sid'")->count();
        if($search_result[0]){
            $msg=array(
                'status'=>0,
                'msg'=>'操作失败！'
            );
        }
        else{
            $msg=array(
                'status'=>1,
                'msg'=>'操作成功！'
            );
            //$model_kt->query("INSERT INTO bs_xt(bid,sid) VALUE(".$kt_bid.",".$stu_sid.");");
            $insert_data=array(
                'sid'=>I('post.sid'),
                'bid'=>I('post.bid')
            );
            $model->add($insert_data);
            echo("插入操作的返回值");
            dump($insert_data);
        }
        $this->ajaxReturn($msg);

    }
	
	//历史数据查询
	public function history(){
		$this->login_check(1);
		$user = public_user_id();
		
		$this->assign('user',$user);
		
		$ttype = public_user_ttype();
		$this->assign("ttype",$ttype);
		$this->display();
	}
	
	
}