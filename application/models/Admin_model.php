<?php


class Admin_model extends CI_Model{
	//根据用户名查询是否存在此用户
	public function check_byUsername($usernamee){
		$data=$this->db->where('username',$usernamee)->get('admin')->result_array();
		return $data;
	}
	
	//根据密码查询是否存在此用户(修改密码的方法)
	public function check_byPasswd($passwd){
		$data=$this->db->where('passwd',$passwd)->get('admin')->result_array();
		return $data;
	}
	
	//更改密码操作
	public function update_passwd($data,$uid){
		$this->db->update('admin',array('passwd'=>md5($data)),array('uid'=>$uid));
	}
}