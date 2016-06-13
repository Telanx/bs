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

	public function xt_cancel($sid = '',$bid = '')
	{
		$result = M('bs_xt')->where(array('bid'=>$bid,'sid'=>$sid))->delete();
		if ($result) {
			$this->success('取消成功');
		}else{
			$this->error('取消失败');
		}
	}

    //查历史数据
    public function history(){
		$this->login_check(1);
		$user = public_user_id();
		
		$this->assign('user',$user);
		
		$ttype = public_user_ttype();
		$this->assign("ttype",$ttype);
		$this->display();
	}

    //指定学生选题
    public function assign_kt(){
              $this->login_check(1);
              $ktId = I('get.ktid');
              $this->assign('ktId',$ktId);
              $this->display();
    }

    //指定选题
    public function xt(){
        $this->login_check(2);
        $ktId = I('post.ktid');
        $sId = I('post.sid');
        $rs = array(
            'status'=>0,
            'msg'=>'非法请求！'
        );
        //检查课题是否处于已审核并未被选状态
        //检查学生是否处于未选课题状态，学号是否有效
        if($ktId && $sId){
            $model_bs = D('Bs');
            $rs = $model_bs->xt($sId,$ktId);
        }
        $this->ajaxReturn($rs);
    }
	
}
