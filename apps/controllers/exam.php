<?php
if (!defined('BASEPATH'))
	exit('No direct script access allowed');

class ExamController extends MY_Controller {
	
	public function index() {

		$itemList = array("itemList"=>array(
			array("back","./index.php/home", "返回主選單"),
			array("examManage","./index.php/exam", "管理試卷"),			
			array("map","./index.php/map", "知識結構圖"),
			array("result","./index.php/exam", "試題分析"),
			array("practice","./index.php/practice", "線上測驗"),			
			array("logout","./", "登出帳號")
			));

		$this -> layout -> view('view/exam/default', $itemList);
	}	
	
}
