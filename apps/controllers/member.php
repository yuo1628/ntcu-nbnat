<?php
if (!defined('BASEPATH'))
	exit('No direct script access allowed');

class MemberController extends MY_Controller {

	/**
	 * Home Page for Home controller.
	 */
	public function index() {
		$this -> layout -> view('view/member/default', $this->_mainmenu());
	}
	public function create() {
		$this -> layout -> view('view/member/create', $this->_mainmenu());
	}
	public function manage() {
		$this -> layout -> view('view/member/manage', $this->_mainmenu());
	}
	private function _mainmenu()
	{
		$itemList = array("itemList" => array(
		 array("img/logo.jpg", "./index.php/home", "返回主選單"),
		 array("img/logo.jpg", "./index.php/member", "修改個人資料"), 
		 array("img/logo.jpg", "./index.php/member/create", "建立會員帳號"), 
		 array("img/logo.jpg", "./index.php/member/manage", "管理會員帳號"),
		 array("img/logo.jpg", "./", "會員登出")
		));
		return $itemList;
	}

}
