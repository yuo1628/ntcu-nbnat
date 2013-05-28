<?php
if (!defined('BASEPATH'))
	exit('No direct script access allowed');

class MapController extends MY_Controller {
	
	public function index() {

		$itemList = array("itemList"=>array(
			array("back","./index.php/exam", "返回選單"),
			array("news","./index.php/map", "知識結構圖"),
			array("exam","./index.php/node", "指標管理"),			
			array("logout","./", "登出帳號")
			));

		$this -> layout -> view('view/exam/map/default', $itemList);
	}	
}
