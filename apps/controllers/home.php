<?php
if (!defined('BASEPATH'))
	exit('No direct script access allowed');

class HomeController extends MY_Controller {

	/**
	 * Home Page for Home controller.
	 */

	public function index() {

		$user = $this -> session -> userdata('user');
		$rank = $user[0] -> rank;
		
		$menu=array();
		
		if($rank<3)
		{
			$menu	=	array(
							array("member","./index.php/member", "會員管理"),
							array("news","./index.php/news", "公佈欄管理"),
							array("exam","./index.php/exam", "試題庫管理"),
							array("logout","./index.php/login/logout", "登出帳號")
						);
		}
		else
		{
			$menu	=	array(
							array("member","./index.php/member", "修改個人資料"),
							array("news","./index.php/news", "公佈欄資訊"),
							array("practice","./index.php/practice", "線上測驗"),
							array("logout","./index.php/login/logout", "登出帳號")
						);
		}


		/*{
		 $itemList = array("itemList"=>array(
		 array("member","./index.php/member", "會員管理"),
		 array("news","./index.php/news", "公佈欄管理"),
		 array("exam","./index.php/exam", "試題庫管理"),
		 array("logout","./", "登出帳號")
		 ),"state"=>$this->userMeta());
		 }
		 else
		 {
		 $itemList = array("itemList"=>array(
		 array("map","./index.php/map", "知識結構圖"),
		 array("practice","./index.php/practice", "線上測驗"),
		 array("logout","./", "登出帳號")
		 ));

		 }*/

		//echo $_SESSION['who'];
		 $itemList = array("itemList"=>$menu,"state"=>$this->userMeta());

		$this -> layout -> view('view/home/default', $itemList);
	}

	private function userMeta() {
		return $this -> load -> view('view/userMeta',"",TRUE);
	}

}
