<?php
	namespace Home\Model;
	use Think\Model;
	class UserModel extends Model{
		//��ȡ�û���������������û�����1ѧ��,2��ʦ,3����Ա
		//���������ͼƬ��ַ����ҳ��ַ
		public function getInfo($t,$id){
			define('__IMG__','/bs/Public/img');
			if($t=='3')return array(
				'home'=>U('Admin/Index/index'),
				'pic'=>__IMG__.'/qq.jpg',
				'name'=>$id
			);	
			if($t=='1'){
				$tb = 'user_student';
				$home = U('Student/Index/index');
			}
			else if($t=='2'){
				$tb = 'user_teacher';
				$home = U('Teacher/Index/index');
			}
			$model_user = M($tb);
			$rs_user = $model_user->where("user='$id'")->select();
			$name = $rs_user[0]['name'];
			$pic = $rs_user[0]['qq']?'http://q.qlogo.cn/headimg_dl?dst_uin='.$rs_user[0]['qq'].'&spec=40':__IMG__.'qq.jpg';
			return array(
				'home'=>$home,
				'pic'=>$pic,
				'name'=>$name
			);
		}
	}
?>