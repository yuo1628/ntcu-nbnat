<?php
if (!defined('BASEPATH'))
	exit('No direct script access allowed');

class HomeController extends MY_Controller {

	/**
	 * Home Page for Home controller.
	 */
	public function index() {

		$itemList = array("itemList"=>array(
			array("member","./index.php/member", "會員管理"),
			array("news","./index.php/news", "公佈欄管理"),
			array("exam","./index.php/exam", "試題庫管理"),
			array("logout","./", "登出帳號")
			));

		$this -> layout -> view('view/home/default', $itemList);
	}

}
