<?php

//栏目管理的控制器
class Category_model extends CI_Model{
	public function check_cate(){
		$data=$this->db->order_by('cid','asc')->get('category')->result_array();
		return $data;
	}
	
	//添加栏目的方法,插入数据库表hd_category
	public function  add_cate($data){
		$this->db->insert('category',$data);
	}
	
	//删除栏目的方法,删除数据库表hd_category，根据cid删除相应的栏目
	public function  delete_cate($data){
		$this->db->delete('category',$data);
	}
	
	//根据cid查询栏目的方法
	public function check_byCid($cid){
		$data=$this->db->where('cid',$cid)->get('category')->result_array();
		return $data;
	}
	//根据cid修改栏目的名称
	public function update_cate($cid,$data){
		$arr=$this->db->update('category',$data,array('cid'=>$cid));//第一个参数是要更新的表，第二个是要更新的数据，第三个是要更新的条件
		return $arr;
	}
	
}