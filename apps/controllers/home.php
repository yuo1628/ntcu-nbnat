<?php
if (!defined('BASEPATH'))
	exit('No direct script access allowed');

class HomeController extends MY_Controller {

	/**
	 * Home Page for Home controller.
	 */
	
	 
	public function index() {
		
		$session = $this->session->userdata('who');
		
		if(empty($session) || $session == '0')
		{
			$itemList = array("itemList"=>array(
				array("member","./index.php/member", "會員管理"),
				array("news","./index.php/news", "公佈欄管理"),
				array("exam","./index.php/exam", "試題庫管理"),
				array("logout","./", "登出帳號")
				));
		}
		else
		{
			$itemList = array("itemList"=>array(
				array("map","./index.php/map", "知識結構圖"),
				array("practice","./index.php/practice", "線上測驗"),
				array("logout","./", "登出帳號")
				));
			
		}
		
		//echo $_SESSION['who'];
		

		$this -> layout -> view('view/home/default', $itemList);
	}
	
	

}
