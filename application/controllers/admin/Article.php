<?php
defined('BASEPATH') OR exit('No direct script access allowed');


class Article extends MY_Controller{
	/*
	 * 发表文章模板显示
	* */
	public function send_article(){
		$this->load->helper('form');
		$this->load->model('Category_model','art');
		$data['article']=$this->art->check_cate();
		$this->load->view('admin/article.html',$data);
	}
	
	//发布文章提交方法
	public function send(){
		//配合文件上传的信息
		$config['upload_path']='./uploads/';//上传的路径
		$config['max_size']='10240';//设置上传图片的文件最大值
		$config['allowed_types']='gif|jpg|png';//设置文件上传的格式
		$config['file_name']=time().'-'.mt_rand(1, 9999);
		//加载ci中图片上传的类,并递交设置的歌参数值
		$this->load->library('upload',$config);
		//执行上传,并返回一个bool值
		$status=$this->upload->do_upload('thumb');
		if (!$status) {
			$wrong=$this->upload->display_errors();
			error($wrong);
		}
		$data=$this->upload->data();//返回上传文件的信息

		
		//缩略图的配置
		$arr['source_image']=$data['full_path'];//原图位置
		$arr['create_thumb']=FALSE;//是否创建缩略图
		$arr['maintain_ratio']=TRUE;//保持一定的比率
		$arr['width']=200;
		$arr['height']=200;
		
		//载入缩略图类
		$this->load->library('image_lib',$arr);
		//执行动作
		$status=$this->image_lib->resize();
		if(!$status){
			error('缩略图片失败，请重新上传');
		}
		
		//载入表单验证类
		$this->load->library('form_validation');
		$status=$this->form_validation->run('article');
		if($status){
// 			echo '数据库操作';
     		//载入文章管理模型
     		$this->load->model('Article_model','art');
			$data=array(
				'title'=>$this->input->post('title'),
				'type'=>$this->input->post('type'),
				'cid'=>$this->input->post('cid'),
				'info'=>$this->input->post('info'),
				'content'=>$this->input->post('content'),
				'thumb'=>$data['file_name'],
				'time'=>time()
			);
			
			$this->art->add($data);
			success("/admin/article/index", "发布成功");
		}else {
			$this->load->helper('form');
			$this->load->model('Category_model','art');
			$data['article']=$this->art->check_cate();
			$this->load->view('admin/article.html',$data);
		}
			
	}
	
	//查看文章方法
	public function index(){
		//加载查看文章的模型
		$this->load->model('Article_model','art');
		
		//载入分页类
		$perpage=5;
 		$this->load->library('pagination');
		//配置分页类链接
		$config['base_url']=site_url('admin/article/index');
		//分页 设置
		$config['total_rows']=$this->db->count_all_results('article');//数据总条数
		$config['per_page']=$perpage;//每页显示的数量
		$config['uri_segment']=4;//地址栏中的第几个参数，默认是第3个
		//设置上下页
		$config['next_tag_open']='<font color="red">';
		$config['next_tag_close']='</font>';
		$config['prev_link']='上一页';
		$config['next_link']='下一页';
		$config['first_link'] = '首页';
		$config['last_link'] = '末页';
	
		//初始化设置
		$this->pagination->initialize($config);
		$offset=$this->uri->segment(4);
		$this->db->limit($perpage,$offset);
		
		$data['article']=$this->art->article_category();
		$this->load->view('admin/check_article.html',$data);
	}
	
	//根据aid删除文章
	public function delete_articleByAid(){
		$aid=$this->uri->segment(4);
		$this->load->model('Article_model','art');
		$this->art->deleteArt_Aid($aid);
		success("admin/article/index", '删除成功');
	}
	
	//跳转到修改文章页面的方法
	public function edit_articleByAid(){
		//根据传递过来的aid查询这篇文章
		$this->load->helper('form');
		$aid=$this->uri->segment(4);
		$this->load->model('Article_model','art');
		$data['editArt']=$this->art->select_byAid($aid);
		$this->load->model('Category_model','cate');
		$data['cate']=$this->cate->check_cate();
//     		p($data);die;
		$this->load->view('admin/edit_article.html',$data);
	}
	
	//修改文章的处理方法
	public function edit(){
		//配合文件上传的信息
		$config['upload_path']='./uploads/';//上传的路径
		$config['max_size']='10240';//设置上传图片的文件最大值
		$config['allowed_types']='gif|jpg|png';//设置文件上传的格式
		$config['file_name']=time().'-'.mt_rand(1, 9999);
		//加载ci中图片上传的类,并递交设置的歌参数值
		$this->load->library('upload',$config);
		//执行上传,并返回一个bool值
		$status=$this->upload->do_upload('thumb');
		if (!$status) {
			$wrong=$this->upload->display_errors();
			error($wrong);
		}
		$data=$this->upload->data();//返回上传文件的信息
		
		
		//缩略图的配置
		$arr['source_image']=$data['full_path'];//原图位置
		$arr['create_thumb']=FALSE;//是否创建缩略图
		$arr['maintain_ratio']=TRUE;//保持一定的比率
		$arr['width']=200;
		$arr['height']=200;
		
		//载入缩略图类
		$this->load->library('image_lib',$arr);
		//执行动作
		$status=$this->image_lib->resize();
		if(!$status){
			error('缩略图片失败，请重新上传');
		}
		
		//载入表单验证类
		$this->load->library('form_validation');
		$status=$this->form_validation->run('article');
		if($status){
			//载入文章管理模型
			$this->load->model('Article_model','art');
			$aid=$this->input->post('aid');
			$data=array(
					'title'=>$this->input->post('title'),
					'type'=>$this->input->post('type'),
					'cid'=>$this->input->post('cid'),
					'info'=>$this->input->post('info'),
					'content'=>$this->input->post('content'),
					'thumb'=>$data['file_name'],
					'time'=>time()
			);	
			$this->art->update_ByAid($aid,$data);
			success("/admin/article/index", "修改成功");
		}else {
			echo "<script type='text/javascript'>
					alert('请填写正确后再提交');window.history.back();</script>";
		}
	}
}  
  