<?php
if (!defined('BASEPATH'))
	exit('No direct script access allowed');

class HomeController extends MY_Controller {

	/**
	 * Home Page for Home controller.
	 */
	public function index() {

		$itemList = array("itemList"=>array(
			"item1" => array("img/logo.jpg","./index.php/member", "會員管理"),
			"item2" => array("img/logo.jpg","./index.php/news", "公佈欄管理"),
			"item3" => array("img/logo.jpg","./", "會員登出")
			));

		$this -> layout -> view('view/home/default', $itemList);
	}

}
