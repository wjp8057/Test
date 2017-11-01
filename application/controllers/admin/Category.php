<?php
defined('BASEPATH') OR exit('No direct script access allowed');


/*
 * 栏目管理控制器
 * */
class Category extends MY_Controller{
	//查看栏目方法
	public function index(){
		$this->load->model('Category_model','cate');
		$data['category']=$this->cate->check_cate();
		$this->load->view('admin/check_cate.html',$data);
	}
	
	//跳转到添加栏目方法
	public function add(){
		$this->load->helper('form');
		$this->load->view('admin/add_cate.html');
	}
	
	//添加栏目的动作方法
	public function add_cate(){
		$this->load->library('form_validation');
		$status=$this->form_validation->run('cate');
		if($status){
// 			echo '数据库操作';
 			$data=array(
 				'cname'=>$this->input->post('cname')
 			);
//  			p($data);die;
 			$this->load->model('Category_model','cate');
 			$this->cate->add_cate($data);
 			success("admin/category/index", "添加成功");
		}else {
			$this->load->helper('form');
			$this->load->view('admin/add_cate.html');
		}
	}
	
	//删除栏目的方法
	public function delete_cate(){
		//获取传递过来的url参数
		$cid=$this->uri->segment(4);
		$data=array(
			'cid'=>$cid	
		);
		$this->load->model('Category_model','cate');
		$this->cate->delete_cate($data);
		success('admin/category/index', "删除成功");
	}
	
	//点击编辑跳转到编辑页面
	public function edit(){
		
		//接收url传递过来的参数(cid值)
		$cid=$this->uri->segment(4);
		$this->load->model('Category_model','cate');
		$data['category']=$this->cate->check_byCid($cid);
		$this->load->helper('form');
		$this->load->view('admin/edit_cate.html',$data);
	}
	
	//编辑修改栏目的方法
	public function edit_cate(){
		$this->load->library('form_validation');
		$status=$this->form_validation->run('cate');
		if($status){
			$cid=$this->input->post('cid');
 			$data=array(
 				'cname'=>$this->input->post('cname')
 			);
 			$this->load->model('Category_model','cate');
 			$this->cate->update_cate($cid,$data);
 			success("admin/category/index", "修改成功");
		}else {
			echo "<script type='text/javascript'>
					alert('栏目名称不能为空或不能超过6个字符');window.history.back();</script>";
			
		}
	}
}