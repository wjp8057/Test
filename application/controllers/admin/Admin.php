<?php
defined('BASEPATH') OR exit('No direct script access allowed');


/*
 * 后台默认控制器
 * */
class Admin extends MY_Controller{
	//访问首页的方法
	public function index(){
		$this->load->view('admin/index.html');
	}
	
	/*
	 * 后台界面默认欢迎页
	 * */
	public function copy(){
		$this->load->view('admin/copy.html');
	}
	
	//跳转到系统信息页面
	public function system_info(){
		$this->load->view('admin/copy.html');
	}
	
	//跳转到密码修改的页面
	public function edit_passwd(){
		$this->load->view('admin/edit_passwd.html');
	}
	
	//密码修改的处理页面
	public function editPwd(){
		//首先判断用户输入的原始密码是否和原始密码一致,原始密码要从数据库中查询
		$passwd1=$this->input->post('passwd1');//获取用户输入的原始密码
		//根据用户输入的原始密码去查询用户表，看是否存此用户，如果返回null则表示没有 
		$this->load->model('Admin_model','admin');
		$data=$this->admin->check_byPasswd(md5($passwd1));
		if($data[0]['passwd']!=md5($passwd1)){
			error('原始密码不正确');
		}
		//判断第一个输入的新密码是否和第二次的相同
		$passwd2=$this->input->post('passwd2');//获取用户输入的新密码
		$passwd3=$this->input->post('passwd3');//获取用户输入的新密码
		if ($passwd2!=$passwd3) {
			error("两次密码输入不一致");
		}else {
			$this->load->model('Admin_model','admin');
			$this->admin->update_passwd($passwd3,$data[0]['uid']);
			$this->session->sess_destroy();
			success('admin/login/index', '修改成功,请重新登录');
		}
	}
	

}