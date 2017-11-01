<?php


/*
 * 文章管理模型
 * */
class Article_model extends CI_Model{
	//添加文章的方法
	public function add($data){
		$this->db->insert('article',$data);
	}
	
	//查看文章方法
	public function article_category(){
		$data=$this->db->select('aid,title,cname,time')->from('article')
		->join('category','article.cid=category.cid')->order_by('aid','asc')->get()->result_array();
		return $data;
	}
	
	//根据aid删除文章
	public function deleteArt_Aid($aid){
		$this->db->delete('article',array('aid'=>$aid));
	}
	//根据aid查询文章
	public function select_byAid($aid){
		$data=$this->db->where('aid',$aid)->get('article')->result_array();
		return $data;
	}
	
// 	根据aid修改文章
	public function update_ByAid($aid,$data){
		$this->db->update('article',$data,array('aid'=>$aid));//第一个参数是要更新的表，第二个是要更新的数据，第三个是要更新的条件
	}
	
//首页查询最新最热文章
	public function index_check($limit){
		$data['new']=$this->db->select('aid,thumb,title,info')->order_by('time','desc')->limit($limit)
		->get_where('article',array('type'=>0))->result_array();
		$data['hot']=$this->db->select('aid,thumb,title,info')->order_by('time','desc')->limit($limit)
		->get_where('article',array('type'=>1))->result_array();
		return $data;
	}
	
//内容中最新文章
	public function right_title($limit) {
		$data=$this->db->select('aid,title')->order_by('time','desc')->limit($limit)->get('article')->result_array();
		return $data;
	}
	
//根据栏目cid查询文章
	public function check_articleByCid($cid,$perpage='',$offset='') {
		$data=$this->db->select('aid,thumb,title,info')->order_by('time','desc')
				->where(array('cid'=>$cid))->get('article',$perpage,$offset)->result_array();
		return $data;
	}
	
	//根据aid查看文章详情
	public function checkArticle_byAid($aid){
		$data=$this->db->select('title,time,content,type,info')->where(array('aid'=>$aid))->get('article')->result_array();
		return $data;
	}
}