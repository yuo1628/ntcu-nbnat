<?php
if (!defined('BASEPATH'))
	exit('No direct script access allowed');

class ExamController extends MY_Controller {
	
	public function index() {

		$itemList = array("itemList"=>array(
			array("back","./index.php/home", "返回主選單"),
			array("news","./index.php/mExam", "管理試題"),			
			array("exam","./index.php/map", "管理知識結構圖"),
			array("exam","./index.php/exam", "輸出試題分析"),
			array("exam","./index.php/practice", "線上測驗練習"),
			array("exam","./index.php/exam", "測驗成果查詢"),
			array("logout","./", "登出帳號")
			));

		$this -> layout -> view('view/exam/default', $itemList);
	}	
	
}
