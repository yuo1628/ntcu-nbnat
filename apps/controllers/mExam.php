<?php
if (!defined('BASEPATH'))
	exit('No direct script access allowed');

class MExamController extends MY_Controller {
	
	public function index() {
		$this -> load -> model('exam/map/m_node', 'node');
		$node = $this -> node -> allNode();
		$itemList = array(
			"itemList"=>array(
				array("back","./index.php/home", "返回主選單"),
				array("news","./index.php/mExam", "管理試題"),				
				array("exam","./index.php/map", "管理知識結構圖"),
				array("exam","./index.php/exam", "輸出試題分析"),
				array("exam","./index.php/practice", "線上測驗練習"),
				array("exam","./index.php/exam", "測驗成果查詢"),
				array("logout","./", "登出帳號")
				),
			"result"=>$node
				);
		$this -> layout -> addStyleSheet("css/exam/create/create.css");
		$this -> layout -> addScript("js/exam/create/default.js");
		$this -> layout -> view('view/exam/create/default', $itemList);
	}	
	function findChild($_id)
	{
		$this -> load -> model('exam/map/m_node', 'node');		
		$itemList = array("childList" => $this -> node -> findNode(array(
													'parent_node' => $_id 
													))
					);
		$this->layout->setLayout('layout/empty');			
		$this -> layout -> view('view/exam/create/childList', $itemList);
	}
	function showTemplate($_type)
	{
		//$this -> layout -> addStyleSheet("css/exam/create/".$_type.".css");
		$this -> layout -> addScript("js/exam/create/".$_type.".js");
		$this->layout->setLayout('layout/empty');			
		$this -> layout -> view('view/exam/create/'.$_type."Template");
	}
	function addQuestion()
	{		
		$_topic=$this->input->post("topic");
		$_type=$this->input->post("type");
		$_tips=$this->input->post("tips");
		$_nodes_id=$this->input->post("nodes_id");
		$_option=$this->input->post("option");
		
		$input_data = array('topic' => $_topic,
							'type' => $_type,
							'tips' => $_tips, 
							'nodes_id' => $_nodes_id
							);
		$this -> load -> model('exam/exam/m_question', 'question');
		$q_id = $this -> question -> addQuestion($input_data);
				
		for($i=0;$i<count($_option);$i++)
		{
			$_option[$i]["questions_id"]=$q_id;				
		}
		$this -> load -> model('exam/exam/m_option', 'option');
		for($i=0;$i<count($_option);$i++)
		{		
			$this -> option -> addOption($_option[$i]);
		}		
	}
}
