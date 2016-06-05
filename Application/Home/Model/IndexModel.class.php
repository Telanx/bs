<?php
	namespace Home\Model;
	use Think\Model;
	class IndexModel extends Model{
	//获取plan,news,link等信息
		//获取前5个链接
		public function getLink(){
			$model_link = M('home_link');
			$rs_link = $model_link->limit(0,5)->select();
			return $rs_link;
		}
		//获取所有链接
		public function getLinks(){
			$model_link = M('home_link');
			$rs_link = $model_link->select();
			//var_dump($rs_link);
			return $rs_link;
		}
		//获取计划
		public function getPlan(){
			$model_plan  =M('home_plan');
			$rs_plan = $model_plan->select();
				return $rs_plan;
		}
		//获取动态新闻
		public function getNews(){
			//$model_news = M('home_news');
			//$rs_news = $model_news->limit(0,5)->select();
			$model_news = new \Think\Model();
			$sql="select * from home_news order by publishtime desc limit 0,5";
			$rs_news = $model_news->query($sql);
			return $rs_news;
			
		}
		//获取新闻详情
		public function getNewsDetail($id){
			$model_news = M('home_news');
			$rs_news = $model_news->where("id=$id")->select();
			return $rs_news[0];
		}
		//获取文件
		public function getFile(){
			$model_file = M('home_doc');
			$rs_file = $model_file->limit(0,5)->select();
			return $rs_file;
		}
		public function getFiles(){
			$model_file = M('home_doc');
			$rs_file = $model_file->select();
			return $rs_file;
		}
		//获取动态
		public function getNewsList($p=1){
			$model_news = M('home_news');
			$cp =8 ;//每一页显示的数据
			$start = $cp*($p-1);
			$total = ceil($model_news->count()/$cp);
			$rs_news = $model_news->field('id,title,publishtime')->limit($start,$cp)->select();
			$rs = array(
				'page'=>array(
					'total'=>$total,
					'current'=>$p,
					),
				'list'=>$rs_news
			);
			return $rs;
		}
		
		
	}
?>