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
			/*array("result","./index.php/exam", "試題分析"),*/
			array("practice","./index.php/practice", "線上測驗"),			
			array("logout","./", "登出帳號")
			), "result" => $node);
			
		$itemList['childList'] =array();
		
		foreach ($node as $item){
			$score=0;
			$item->count_total = $this->countQuizTotal($item->uuid);
			$item->count_open = $this->countQuizOpen($item->uuid);
			$score_temp=$this->countQuizScore($item->uuid);
			foreach ($score_temp as $score_item){
				$score=$score+$score_item->score;
			}
			$item->count_score = ($score/100);
			$itemList['childList'][] = $item;
		}	
		
		$this -> layout -> addStyleSheet("css/exam/exam/examLock.css");
		$this -> layout -> addScript("js/exam/exam/examLock.js");
		
		$this -> layout -> addStyleSheet("css/exam/exam/default.css");	
		$this -> layout -> addStyleSheet("css/exam/practice/default.css");
		$this -> layout -> addScript("js/exam/exam/default.js");

		$this -> layout -> view('view/exam/exam/childList', $itemList);
	}	
	function findChild($_id) {
		$this -> load -> model('exam/map/m_node', 'node');
		$itemList = $this -> node -> findNode(array('parent_node' => $_id));
		
		//$result=array("childList"=>array());
		$result['childList'] =array();
		
		foreach ($itemList as $item){
			$score=0;
			$item->count_total = $this->countQuizTotal($item->uuid);
			$item->count_open = $this->countQuizOpen($item->uuid);
			$score_temp=$this->countQuizScore($item->uuid);
			foreach ($score_temp as $score_item){
				$score=$score+$score_item->score;
			}
			$item->count_score = ($score/100);
			$result['childList'][] = $item;
		}
		
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
	
	function countQuizScore($_uuid)
	{
		$this -> load -> model('exam/exam/m_question', 'question');
		return $this -> question -> findQuestion(array("nodes_uuid"=>$_uuid,"public"=>"true"));			
	}
	
	function lockToggle()
	{
		$_uuid = $this -> input -> post("uuid");
		$_lock = $this -> input -> post("lock");
		$this -> load -> model('exam/map/m_node', 'node');		
		$this -> node -> updNode(array('lock' => $_lock),array('uuid' => $_uuid));	
	}
	
	function openToggle()
	{
		$_uuid = $this -> input -> post("uuid");
		
		$this -> load -> model('exam/map/m_node', 'node');		
		$this -> node -> updNode(array('open_answer' => "close"),array('uuid' => $_uuid));	
	}
	
	function sentOpen()
	{
		$_uuid = $this -> input -> post("uuid");
		$_time = $this -> input -> post("time");
		$this -> load -> model('exam/map/m_node', 'node');		
		$this -> node -> updNode(array('limit_time' => $_time,'open_answer' => 'open'),array('uuid' => $_uuid));	
	
	}


}
