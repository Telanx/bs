<?php
// 本类由系统自动生成，仅供测试用途
namespace Home\Controller;
use Think\Controller;
class IndexController extends Controller {
	//首页
    public function index(){
		//获取link链接最多5个
		$model_index = D('Index');
		$rs_link = $model_index->getLink();
		$rs_plan = $model_index->getPlan();
		$rs_news = $model_index->getNews();
		$rs_file = $model_index->getFile();
		//获取登录用户信息
		$user_type = public_user_type();
		$user=array(
			'login'=>0,
			'name'=>'',
			'pic'=>'',
			'home'=>''
		);
		if($user_type){
			$user_id = public_user_id();
			$model_user = D('User');
			$rs_user = $model_user->getInfo($user_type,$user_id);
			$user = array(
				'login'=>1,
				'name'=>$rs_user['name'],
				'pic'=>$rs_user['pic'],
				'home'=>$rs_user['home']
			);
		}
		
		$this->assign('user',$user);
		$this->assign('plan',$rs_plan);
		$this->assign('link',$rs_link);
		$this->assign('news',$rs_news);
		$this->assign('file',$rs_file);
		$this->display();
    }	
	//显示连接
	public function link(){
		//获取登录用户信息
		$user_type = public_user_type();
		$user=array(
			'login'=>0,
			'name'=>'',
			'pic'=>'',
			'home'=>''
		);
		if($user_type){
			$user_id = public_user_id();
			$model_user = D('User');
			$rs_user = $model_user->getInfo($user_type,$user_id);
			$user = array(
				'login'=>1,
				'name'=>$rs_user['name'],
				'pic'=>$rs_user['pic'],
				'home'=>$rs_user['home']
			);
		}
		//获取网站
		$model_link = D('Index');
		$rs_link = $model_link->getLinks();
		$this->assign('user',$user);
		$this->assign('link',$rs_link);
		$this->display();
	}
	//显示新闻列表
	public function news(){
		//获取登录用户信息
		$user_type = public_user_type();
		$user=array(
			'login'=>0,
			'name'=>'',
			'pic'=>'',
			'home'=>''
		);
		if($user_type){
			$user_id = public_user_id();
			$model_user = D('User');
			$rs_user = $model_user->getInfo($user_type,$user_id);
			$user = array(
				'login'=>1,
				'name'=>$rs_user['name'],
				'pic'=>$rs_user['pic'],
				'home'=>$rs_user['home']
			);
		}
		//分页获取新闻
		$p = I('get.p')?I('get.p'):1;
		$model_index = D('Index');
		$rs_news = $model_index->getNewsList($p);
		$this->assign('news',$rs_news['list']);
		$this->assign('page',$rs_news['page']);
		$this->assign('user',$user);
		$this->display();
	}
	//新闻详情页面
	public function newsdetail(){
		$id = (int)I('get.id');
		$model_news = D('index');
		$rs_news = $model_news->getNewsDetail($id);
		$this->assign('news',$rs_news);
		$this->display();
	}
	
	//文件下载
	public function file(){
		//获取登录用户信息
		$user_type = public_user_type();
		$user=array(
			'login'=>0,
			'name'=>'',
			'pic'=>'',
			'home'=>''
		);
		if($user_type){
			$user_id = public_user_id();
			$model_user = D('User');
			$rs_user = $model_user->getInfo($user_type,$user_id);
			$user = array(
				'login'=>1,
				'name'=>$rs_user['name'],
				'pic'=>$rs_user['pic'],
				'home'=>$rs_user['home']
			);
		}
		$model_file = D('Index');
		$file = $model_file->getFiles();
		$this->assign('total',count($file));
		$this->assign('file',$file);
		$this->assign('user',$user);
		$this->display();
	}
	
	//相关链接,暂不需要扩充
	
}