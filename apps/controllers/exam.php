<?php
if (!defined('BASEPATH'))
	exit('No direct script access allowed');

class ExamController extends MY_Controller {
	
	public function index() {
		$this -> load -> model('exam/map/m_node', 'node');
		$node = $this -> node -> allNode();

		$itemList = array("itemList"=>array(
			array("back","./index.php/home", "返回主選單"),
			array("examManage","./index.php/exam", "管理試卷"),			
			array("map","./index.php/map", "知識結構圖"),
			array("result","./index.php/exam", "試題分析"),
			array("practice","./index.php/practice", "線上測驗"),			
			array("logout","./", "登出帳號")
			), "result" => $node);
			
		$this -> layout -> addStyleSheet("css/exam/practice/default.css");
		$this -> layout -> addScript("js/exam/exam/default.js");

		$this -> layout -> view('view/exam/exam/default', $itemList);
	}	
	function findChild($_id) {
		$this -> load -> model('exam/map/m_node', 'node');
		$itemList = $this -> node -> findNode(array('parent_node' => $_id));
		
		//$result=array("childList"=>array());
		$result['childList'] =array();
		
		foreach ($itemList as $item){
		
			$item->count_total = $this->countQuizTotal($item->uuid);
			$item->count_open = $this->countQuizOpen($item->uuid);
			$result['childList'][] = $item;
		}
		$this -> layout -> addStyleSheet("css/exam/exam/default.css");
		$this -> layout -> setLayout('layout/empty');
		$this -> layout -> view('view/exam/exam/childList', $result);
	}
	
	function countQuizTotal($_uuid)
	{
		$this -> load -> model('exam/exam/m_question', 'question');
		return $this -> question -> countQuestion(array("nodes_uuid"=>$_uuid));		
	}
	
	function countQuizOpen($_uuid)
	{
		$this -> load -> model('exam/exam/m_question', 'question');
		return $this -> question -> countQuestion(array("nodes_uuid"=>$_uuid,"public"=>"true"));		
	}
}
