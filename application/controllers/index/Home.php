<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/*
 * 默认前台控制器
 * */
class Home extends CI_Controller{
	
	public function __construct(){
		parent::__construct();
		$this->load->model('Category_model','cate');
		$this->load->model('Article_model','art');
	}
	
	//默认首页显示方法
	public function index(){
// 		$this->load->model('Category_model','cate');
// 		$this->load->model('Article_model','art');
		$data=$this->art->index_check(3);
		$data['category']=$this->cate->check_cate();
		$data['Rtitle']=$this->art->right_title(8);
//   		p($data);die;
		$this->load->view("index/home.html",$data);
	}
	
	//分类显示
	public function category(){
		$cid=$this->uri->segment(4);
		//载入分页类
		$perpage=3;
		$this->load->library('pagination');
		//配置分页类链接
		$config['base_url']=site_url('index/home/category').'/'.$cid;
		//分页 设置
		$config['total_rows']=$this->db->where(array('cid'=>$cid))->count_all_results('article');//数据总条数
// 		echo $config['total_rows'];die;
		$config['per_page']=$perpage;//每页显示的数量
		$config['uri_segment']=5;//地址栏中的第几个参数，默认是第3个
		//设置上下页
		$config['next_tag_open']='<font color="red">';
		$config['next_tag_close']='</font>';
		$config['prev_link']='上一页';
		$config['next_link']='下一页';
		$config['first_link'] = '首页';
		$config['last_link'] = '末页';
		
		//初始化设置
		$this->pagination->initialize($config);
		$offset=$this->uri->segment(5);
//  		$this->db->limit($perpage,$offset);
		
// 		echo  $this->pagination->create_links();die;
		
// 		$cid=$this->uri->segment(4);
// 		$this->load->model('Category_model','cate');
// 		$this->load->model('Article_model','art');
		$data=$this->art->index_check(3);
		$data['article']=$this->art->check_articleByCid($cid,$perpage,$offset);
		$data['category']=$this->cate->check_cate();
		$data['Rtitle']=$this->art->right_title(8);
// 		p($data);die;
		$this->load->view('index/category.html',$data);
	}
	
	//文章阅读页显示
	public function article(){
		$cid=$this->uri->segment(4);
		$aid=$this->uri->segment(4);
// 		$this->load->model('Category_model','cate');
// 		$this->load->model('Article_model','art');
		$data=$this->art->index_check(3);
		$data['article']=$this->art->check_articleByCid($cid,4);
		$data['category']=$this->cate->check_cate();
		$data['Rtitle']=$this->art->right_title(8);
		$data['detials']=$this->art->checkArticle_byAid($aid);
//  		p($data);die;
		$this->load->view('index/article.html',$data);
	}
	
}