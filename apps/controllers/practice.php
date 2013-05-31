<?php
if (!defined('BASEPATH'))
	exit('No direct script access allowed');

class PracticeController extends MY_Controller {

	public function index() {
		$this -> load -> model('exam/map/m_node', 'node');
		$node = $this -> node -> allNode();
		$itemList = array("itemList" => array( array("back", "./index.php/home", "返回主選單"), array("news", "./index.php/mExam", "管理試題"), array("exam", "./index.php/map", "管理知識結構圖"), array("exam", "./index.php/exam", "輸出試題分析"), array("exam", "./index.php/practice", "線上測驗練習"), array("exam", "./index.php/exam", "測驗成果查詢"), array("logout", "./", "登出帳號")), "result" => $node);
		$this -> layout -> addStyleSheet("css/exam/practice/default.css");
		$this -> layout -> addScript("js/exam/practice/default.js");
		$this -> layout -> view('view/exam/practice/default', $itemList);
	}

	function findChild($_id) {
		$this -> load -> model('exam/map/m_node', 'node');
		$itemList = $this -> node -> findNode(array('parent_node' => $_id));
		
		//$result=array("childList"=>array());
		$result['childList'] =array();
		
		foreach ($itemList as $item){
		
			$item->count = $this->countExam($item->id);
			$result['childList'][] = $item;
		}
		
		$this -> layout -> setLayout('layout/empty');
		$this -> layout -> view('view/exam/practice/childList', $result);
	}
	
	function countExam($_id)
	{
		$this -> load -> model('exam/exam/m_question', 'question');
		return $this -> question -> countQuestion($_id);		
	}


	function findExamList() {
		$_id = $this -> input -> post("id");
		$this -> load -> model('exam/exam/m_question', 'question');
		$this -> load -> model('exam/map/m_node', 'node');
		$this -> load -> model('exam/exam/m_option', 'option');
		
		$itemList['examList'] =array();	
		
		
		$data = $this -> question -> findQuestion(array('nodes_id' => $_id));	
		$node = $this -> node -> findNodeById($_id);		
		
		
		foreach ($data as $item)
		{
			$item->optionList = $this -> option -> findOptionByQId($item->id);
			$itemList['examList'][]=$item;
		}
				
		$itemList['examTitle'] =$node;
	
		$this -> layout -> setLayout('layout/empty');
		$this -> layout -> view('view/exam/practice/examList', $itemList);
	}
	function addAnswer()
	{
		$n_id = $this -> input -> post("n_id");
		$ans = $this -> input -> post("ans");
		
		
	}

}
