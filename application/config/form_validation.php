<?php
// 数组里面只有一个字段，这个字段 对应的值是一个数组，这个数组每个下标的值第一个的又是一个数组
$config = array (
		'article' => array (
				array (
						'field' => 'title',
						'label' => '标题',
						'rules' => 'required|min_length[3]' 
				),
				array (
						'field' => 'type',
						'label' => '类型',
						'rules' => 'required|integer' 
				),
				array (
						'field' => 'cid',
						'label' => '栏目',
						'rules' => 'integer' 
				),
				array (
						'field' => 'info',
						'label' => '摘要',
						'rules' => 'required|max_length[300]' 
				),
				array (
						'field' => 'content',
						'label' => '内容',
						'rules' => 'required|max_length[5000]' 
				) 
		),
		'cate' => array (
				array (
						'field' => 'cname',
						'label' => '栏目名称',
						'rules' => 'required|max_length[5]' 
				) ,
		) ,
);