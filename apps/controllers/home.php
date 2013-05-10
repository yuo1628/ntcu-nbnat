<?php
if (!defined('BASEPATH'))
	exit('No direct script access allowed');

class HomeController extends MY_Controller {

	/**
	 * Home Page for Home controller.
	 */
	public function index() {

		$itemList = array("itemList"=>array(
			"item1" => array("member","./index.php/member", "會員管理"),
			"item2" => array("news","./index.php/news", "公告管理"),
			"item3" => array("logout","./", "登出帳號")
			));

		$this -> layout -> view('view/home/default', $itemList);
	}

}
