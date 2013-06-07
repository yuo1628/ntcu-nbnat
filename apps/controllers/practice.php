<?php
if (!defined('BASEPATH'))
	exit('No direct script access allowed');

class PracticeController extends MY_Controller {

	public function index() {
		$this -> load -> model('exam/map/m_node', 'node');
		$node = $this -> node -> allNode();
		$itemList = array("itemList" => array(
											array("back", "./index.php/home", "返回主選單"),
											array("news", "./index.php/mExam", "管理試題"),
											array("exam", "./index.php/map", "管理知識結構圖"),
											array("exam", "./index.php/exam", "輸出試題分析"),
											array("exam", "./index.php/practice", "線上測驗"),											
											array("logout", "./", "登出帳號")
										),
						  "result" => $node);
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
		
			$item->count_e = $this->countExam($item->uuid);
			$item->count_a = $this->countAns($item->uuid);
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
	
	function countAns($_id)
	{
		$this -> load -> model('exam/exam/m_answer', 'answer');
		return $this -> answer -> countAnswer($_id);		
	}
	function findExamList() {
		$_uid = $this -> input -> post("uid");
		$this -> load -> model('exam/exam/m_question', 'question');
		$this -> load -> model('exam/map/m_node', 'node');
		$this -> load -> model('exam/exam/m_option', 'option');
		
		$itemList['examList'] =array();			
		
		$data = $this -> question -> findQuestion(array('nodes_uuid' => $_uid,'public' => "true"));	
		$node = $this -> node -> findNode(array("uuid"=>$_uid));		
		
		
		foreach ($data as $item)
		{
			$item->optionList = $this -> option -> findOptionByQId($item->id);
			$itemList['examList'][]=$item;
		}
				
		$itemList['examTitle'] =$node;
		
		$this -> layout -> addStyleSheet("css/exam/practice/examList.css");	
		$this -> layout -> setLayout('layout/empty');
		$this -> layout -> view('view/exam/practice/examList', $itemList);
	}
	function addAnswer()
	{
		$uuid = $this -> input -> post("uuid");
		$ans = $this -> input -> post("answer");
		$spend = $this -> input -> post("spend");
		
		
		$input_data=array("answer"=>$ans,"spend"=>$spend,"nodes_uuid"=>$uuid);
		
		$this -> load -> model('exam/exam/m_answer', 'answer');
		$this -> answer -> addAnswer($input_data);
		
	}
	
	function resultRoute($a_uid,$_sort="desc")
	{
		$this -> load -> model('exam/exam/m_answer', 'answer');
		$_id=$this -> answer -> findFirstAnswerId($a_uid,$_sort);
		$this ->result($a_uid,$_id);
	}
	
	function result($a_uid,$_id)
	{
		$this -> load -> model('exam/exam/m_answer', 'answer');
		$this -> load -> model('exam/exam/m_question', 'question');
		$this -> load -> model('exam/map/m_node', 'node');
		$this -> load -> model('exam/exam/m_option', 'option');
		
		$ansTitle=$this -> answer -> findAnswer(array("nodes_uuid"=>$a_uid));
				
				
		$userAns=$this -> answer -> findAnswerById($_id);
				
		$userAnsArray=json_decode($userAns[0]->answer,true);
		$count=count($userAnsArray);
		$quizArray=$this->quizToArray($a_uid,$userAnsArray);
				
		foreach ($userAnsArray as $userAnsItem) 
		{			
			foreach ($quizArray as $i=>$quizAnsItem) 
			{
				if($userAnsItem["topicId"]==$quizAnsItem["topicId"])
				{
					$userTemp[]=$userAnsItem["ans"];						
					foreach ($quizAnsItem["ans"] as $item) 
					{
						if($item["correct"]=="true")
						{
							$temp[$i][]=$item["id"];
						}						
					}
				}
			}			
		}	
		
		
		$score=0;
		
		foreach ($userTemp as $i=>$item) 
		{			
			if($item==$temp[$i])
			{
				$correct[$i]="1";
				$score=$score+$quizArray[$i]["score"];
			}
			else
			{
				$correct[$i]="0";
			}				
		}
	
		$itemList = array("itemList" => array(
										array("back", "./index.php/home", "返回主選單"),
										array("news", "./index.php/mExam", "管理試題"),
										array("exam", "./index.php/map", "管理知識結構圖"),
										array("exam", "./index.php/exam", "輸出試題分析"),
										array("exam", "./index.php/practice", "線上測驗"),											
										array("logout", "./", "登出帳號")
										),
						 "uuid"=>$a_uid,
						 "result"=>$ansTitle,						 
						 "count"=>$count,
						 "score"=>$score,
						 "correct"=>$correct,						 
						 "quizAns"=>$quizArray,
						 "userAns"=>$userAns,
						 "userOptionAns"=>$userTemp
						 
						 );
		$this -> layout -> addStyleSheet("css/exam/practice/examList.css");					  
		$this -> layout -> addStyleSheet("css/exam/practice/result.css");
		$this -> layout -> addScript("js/exam/practice/result.js");
		$this -> layout -> view('view/exam/practice/result', $itemList);
		
	}

	function quizToArray($a_uid,$userAnsArray)
	{
		$this -> load -> model('exam/exam/m_question', 'question');
		
		foreach ($userAnsArray as $i=>$userAnsItem) 
		{		
			$quiz=$this -> question -> findQuestion(array("nodes_uuid"=>$a_uid,"id"=>$userAnsItem["topicId"]));
				
			foreach ($quiz as $item)
			{
				$ans["topicId"]=$item->id;			
				$ans["type"]=$item->type;
				$ans["topic"]=$item->topic;
				$ans["tips"]=$item->tips;
				$ans["score"]=($item->score)/100;
				$correctArray = $this -> option -> findOption(array("questions_id"=>$item->id));
				$ansArr=array();
				foreach ($correctArray as $correctItem)
				{
					$item2 = array();
					$item2["id"] = $correctItem->id;
					$item2["value"] = $correctItem->value; 
					$item2["correct"] = $correctItem->correct; 
					$ansArr[]= $item2; 
					//$ansArr[$correctItem->id]=$correctItem->value; 
				}	
				
				$ans["ans"]=$ansArr;
				$arr[]=$ans;	
			}
		}
		return $arr;		
	}
	
	

}
