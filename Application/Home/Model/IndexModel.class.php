<?php
	namespace Home\Model;
	use Think\Model;
	class IndexModel extends Model{
	//��ȡplan,news,link����Ϣ
		//��ȡǰ5������
		public function getLink(){
			$model_link = M('home_link');
			$rs_link = $model_link->limit(0,5)->select();
			return $rs_link;
		}
		//��ȡ��������
		public function getLinks(){
			$model_link = M('home_link');
			$rs_link = $model_link->select();
			//var_dump($rs_link);
			return $rs_link;
		}
		//��ȡ�ƻ�
		public function getPlan(){
			$model_plan  =M('home_plan');
			$rs_plan = $model_plan->select();
				return $rs_plan;
		}
		//��ȡ��̬����
		public function getNews(){
			//$model_news = M('home_news');
			//$rs_news = $model_news->limit(0,5)->select();
			$model_news = new \Think\Model();
			$sql="select * from home_news order by publishtime desc limit 0,5";
			$rs_news = $model_news->query($sql);
			return $rs_news;
			
		}
		//��ȡ��������
		public function getNewsDetail($id){
			$model_news = M('home_news');
			$rs_news = $model_news->where("id=$id")->select();
			return $rs_news[0];
		}
		//��ȡ�ļ�
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
		//��ȡ��̬
		public function getNewsList($p=1){
			$model_news = M('home_news');
			$cp =8 ;//ÿһҳ��ʾ������
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