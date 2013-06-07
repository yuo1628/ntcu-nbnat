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
				array("exam","./index.php/practice", "線上測驗"),
				array("logout","./", "登出帳號")
				),
			"result"=>$node
				);
		$this -> layout -> addScript("js/exam/create/editTemplate.js");
		$this -> layout -> addStyleSheet("css/exam/create/editTemplate.css");
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
		$_score=$this->input->post("score");
		$_topic=$this->input->post("topic");
		$_type=$this->input->post("type");
		$_tips=$this->input->post("tips");
		$_nodes_uuid=$this->input->post("nodes_uuid");
		$_option=$this->input->post("option");
		$_public=$this->input->post("_public");
		
		$input_data = array('topic' => $_topic,
							'type' => $_type,
							'tips' => $_tips,
							'score'=> $_score*100,
							'public'=>$_public,
							'nodes_uuid' => $_nodes_uuid
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
	function findExamList() {
		$_uid = $this -> input -> post("uid");
		$this -> load -> model('exam/exam/m_question', 'question');
		$this -> load -> model('exam/map/m_node', 'node');
		$this -> load -> model('exam/exam/m_option', 'option');
		
		$itemList['examList'] =array();	
		
		$data = $this -> question -> findQuestion(array('nodes_uuid' => $_uid));	
		$node = $this -> node -> findNode(array("uuid"=>$_uid));		
		
		
		foreach ($data as $item)
		{
			$item->optionList = $this -> option -> findOptionByQId($item->id);
			$itemList['examList'][]=$item;
		}
				
		$itemList['examTitle'] =$node;
		$this -> layout -> addScript("js/exam/create/examList.js");
		$this -> layout -> addStyleSheet("css/exam/create/examList.css");			
		$this -> layout -> setLayout('layout/empty');
		$this -> layout -> view('view/exam/create/examList', $itemList);		
	}

	function findQuizMeta()
	{
		$_id = $this -> input -> post("id");
		$this -> load -> model('exam/exam/m_question', 'question');		
		$this -> load -> model('exam/exam/m_option', 'option');
		
		$itemList['optionList'] =array();	
		
		$itemList['quiz']= $this -> question -> findQuestion(array('id' => $_id));	
		
		foreach ($itemList['quiz'] as $item)
		{		
			$item->optionList = $this -> option -> findOptionByQId($item->id);
			$itemList['optionList'][]=$item;
		}
						
		$this -> layout -> setLayout('layout/empty');
		$this -> layout -> view('view/exam/create/quizMeta', $itemList);		
	}
	function delQuiz()
	{
		$_id = $this -> input -> post("id");
		$this -> load -> model('exam/exam/m_question', 'question');		
		$this -> question -> delQuestion(array('id' => $_id));
	}
	
	function editQuiz()
	{
		$_id = $this -> input -> post("id");
		$_data = explode(",",$this -> input -> post("data"));
		$_option=$this->input->post("option");
		$_newOption=$this->input->post("newOption");
		
		
		foreach ($_data as $i => $value) {
			$temp=explode(":",$value);
			$itemList[$temp[0]]=$temp[1];
		}
				
		$this -> load -> model('exam/exam/m_option', 'option');
		$this -> load -> model('exam/exam/m_question', 'question');		
		
		$_oldOptionArray = $this -> option ->findOptionByQId($_id);
		
		foreach ($_option as $value)
		{
			$_newArray[]=$value["id"];	
			
		}
		
		foreach ($_oldOptionArray as $item)
		{			
			if (in_array($item->id, $_newArray)) 
			{
	 		  	foreach ($_option as $key => $value)
				{
					$this -> option -> updOption(array("correct"=>$value["correct"],"value"=>$value["value"]),array("id"=>$value["id"]));
				}
			}
			else
			{
				$this -> option -> delOption(array("id"=>$item->id));
				
			}			
		}
		
		
		foreach ($_newOption as $item)
		{
			$item["questions_id"]=$_id;			
			$this -> option -> addOption($item);
		}
		
		$this -> question -> updQuestion($itemList,array('id' => $_id));		
	}
	
	
	function editQuizTemplate()
	{
		$_id = $this -> input -> post("id");
		$this -> load -> model('exam/exam/m_question', 'question');		
		$this -> load -> model('exam/exam/m_option', 'option');
		
		$itemList['optionList'] =array();	
		
		$itemList['quiz']= $this -> question -> findQuestion(array('id' => $_id));	
		
		foreach ($itemList['quiz'] as $item)
		{		
			$item->optionList = $this -> option -> findOptionByQId($item->id);
			$itemList['optionList'][]=$item;
		}
			
		$this -> layout -> setLayout('layout/empty');
		$this -> layout -> view('view/exam/create/editTemplate', $itemList);
	}


}
