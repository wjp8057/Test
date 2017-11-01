<?php
class MY_Controller extends CI_Controller{
	public function __construct(){
		parent::__construct();
		$username=$_SESSION['userSession']['username'];
		$uid=$_SESSION['userSession']['uid'];
		if (!$username||!$uid) {
			redirect("admin/login/index");
		}
	}
}