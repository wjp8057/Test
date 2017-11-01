<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/*
 * 登录控制器
 * */
class Login extends CI_Controller{
	//登录默认方法
	public function index(){
		$this->load->view('admin/login.html');
	}

	//显示验证码的方法
	public function code(){
		$config=array(
				'width'=>80,
				'height'=>25,
				'fontSize'=>16
		);
		$this->load->library('code',$config);
		$this->code->show();
	}
	
	//处理登录的方法
	public function login_in(){
		$InputUsername=$this->input->post('username');
		$InputPasswd=$this->input->post('passwd');
		$InputCode=$this->input->post('code');
		//根据用户名查询是否存在这个用户
		$this->load->model('Admin_model','admin');
		$dataUser=$this->admin->check_byUsername($InputUsername);
		if(!$dataUser||$dataUser[0]['passwd']!=md5($InputPasswd)){
			error("用户名或密码错误，请重新输入");
		}
		 if($_SESSION['code']!=strtoupper($InputCode)){
			error('验证码错误，请重新输入');
		} 
		$sessionData=array(
			'uid'=>$dataUser[0]['uid'],
			'username'=>$InputUsername,
			'loginTime'=>time()
		);
		//存入到session中
		$_SESSION['userSession']=$sessionData;
// 		$arr=$_SESSION['userSession']['username'];
		success("admin/admin/index", "登录成功");
	}
	
	//退出登录的方法
	public function login_out(){
		 $this->session->sess_destroy();//注销所有session变量
		 success("admin/login/index", "退出成功");
	}
}