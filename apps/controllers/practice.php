<?php
if (!defined('BASEPATH'))
	exit('No direct script access allowed');

class PracticeController extends MY_Controller {

	public function index() {
		$this -> load -> model('exam/map/m_node', 'node');
		$this -> load -> model('exam/exam/m_answer', 'answer');
		
		$node = $this -> node -> allNode();
		
				
		$user = $this -> session -> userdata('user');
		$rank = $user[0] -> rank;
		
		if($rank<3)
		{
			$itemList = array("itemList"	=>array(
									array("back","./index.php/home", "返回主選單"),
									array("examManage","./index.php/exam", "管理試卷"),			
									array("map","./index.php/map", "知識結構圖"),
									/*array("result","./index.php/exam", "試題分析"),*/
									array("practice","./index.php/practice", "線上測驗"),			
									array("logout","./index.php/login/logout", "登出帳號")
									),
								"result" 	=> $node,
								"state"		=>$this->userMeta());		
		}
		else
		{
			$itemList = array("itemList"=>array(
				array("back","./index.php/home", "返回主選單"),									
				array("map","./index.php/map", "知識結構圖"),
				array("practice","./index.php/practice", "線上測驗"),
				array("logout","./index.php/login/logout", "登出帳號")
				),"state"=>$this->userMeta());
			
		}		
		
		$itemList['childList'] =array();
		
		foreach ($node as $item){
			
			$score=0;
			$item->count_e = $this->countExam($item->uuid); 		//總試題數
			$item->count_a = $this->countAns($item->uuid);			//答題次數			
			$score_temp=$this->countQuizScore($item->uuid);			//總分
			foreach ($score_temp as $score_item)					
			{														
				$score=$score+$score_item->score;					
			}																	
			$item->count_score = ($score/100);						
			
			$item->isNotFinish=$this->answer->findAnswer(array("nodes_uuid"=>$item->uuid,"finish"=>"false"));
			
			
			$itemList['childList'][] = $item;
		}
						  
		$this -> layout -> addStyleSheet("css/exam/practice/default.css");
		$this -> layout -> addScript("js/exam/practice/default.js");
		$this -> layout -> addScript("js/exam/practice/timer.js");
		$this -> layout -> addStyleSheet("css/exam/practice/timer.css");	
		$this -> layout -> addStyleSheet("css/exam/practice/examList.css");	
		
		$this -> layout -> view('view/exam/practice/default', $itemList);
	}
	
	function countQuizScore($_uuid)
	{
		$this -> load -> model('exam/exam/m_question', 'question');
		return $this -> question -> findQuestion(array("nodes_uuid"=>$_uuid,"public"=>"true"));			
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
		return $this -> question -> countQuestion(array("nodes_uuid"=>$_id,'public' => "true"));		
	}
	
	function countAns($_uuid)
	{
		$this -> load -> model('exam/exam/m_answer', 'answer');
		return $this -> answer -> countAnswer($_uuid);		
	}
	function findExamList() {
		$_uid = $this -> input -> post("uid");
		$_ansId = $this -> input -> post("ansId");
		
		$this -> load -> model('exam/exam/m_question', 'question');
		$this -> load -> model('exam/map/m_node', 'node');
		$this -> load -> model('exam/exam/m_option', 'option');
		$this -> load -> model('exam/exam/m_answer', 'answer');
		
		$itemList['examList'] =array();			
			
		$data = $this -> question -> findQuestion(array('nodes_uuid' => $_uid,'public' => "true"));	
		$node = $this -> node -> findNode(array("uuid"=>$_uid));		
			
					
		if($_ansId)
		{
			$_ansMes=$this -> answer -> findAnswerById($_ansId);
			$itemList['lastAns']=$_ansMes;			
		}
			
		foreach ($data as $item)
		{
			$item->optionList = $this -> option -> findOptionByQId($item->id);
			
			if($_ansId)
			{					
				$_ansArr=(json_decode($_ansMes[0]->answer));
				
				foreach ($_ansArr as $ansItem)
				{
					foreach ($item->optionList as $_optionItem)
					{						
						if($ansItem->topicId==$_optionItem->questions_id )
						{
							foreach ($ansItem->ans as $_ansItem)
							{
								if($_ansItem==$_optionItem->id)
								{
									$_optionItem->checked=true;
								}														
							}							
						}
					}
				}						
			}		
			
			$itemList['examList'][]=$item;						
		}
					
		$itemList['examTitle'] =$node;
		
		
		$this -> layout -> setLayout('layout/empty');
		$this -> layout -> view('view/exam/practice/examList', $itemList);
		
	}
	function addAnswer()
	{
		$uuid = $this -> input -> post("uuid");
		$ans = $this -> input -> post("answer");
		$finish = $this -> input -> post("finish");
		$spend = $this -> input -> post("spend");		
		$type=$this -> input -> post("type");
		
		
		$this -> load -> model('exam/exam/m_answer', 'answer');
		if($type=="add"){
			$input_data=array("answer"=>$ans,"spend"=>$spend,"nodes_uuid"=>$uuid,"finish"=>$finish);
			$this -> answer -> addAnswer($input_data);
		}
		else
		{
			$_aid=$this -> input -> post("aid");
			$input_data=array("answer"=>$ans,"spend"=>$spend,"finish"=>$finish);
			$this -> answer -> updAnswer($input_data,array("id"=>$_aid));
		}
	}
		
	
	function resultRoute()
	{
		$a_uid=$this->input->get("id");
		$_sort=$this->input->get("sort");
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
		
		$ansTitle=$this -> answer -> findAnswer(array("nodes_uuid"=>$a_uid,"finish"=>"true"));
		$examMes=$this -> node -> findNode(array("uuid"=>$a_uid));
				
				
		$userAns=$this -> answer -> findAnswerById($_id);
				
		$userAnsArray=json_decode($userAns[0]->answer,true);
		
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
		$scoreTotal=0;
		
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
			$scoreTotal=$scoreTotal+$quizArray[$i]["score"];		
		}
		$count=count($userTemp);
	
		$itemList = array("itemList" =>	array(
										array("back","./index.php/home", "返回主選單"),
										array("examManage","./index.php/exam", "管理試卷"),			
										array("map","./index.php/map", "知識結構圖"),
										/*array("result","./index.php/exam", "試題分析"),*/
										array("practice","./index.php/practice", "線上測驗"),			
										array("logout","./index.php/login/logout", "登出帳號")
										),
						 "uuid"=>$a_uid,
						 "examMes"=>$examMes,
						 "result"=>$ansTitle,						 
						 "count"=>$count,
						 "scoreTotal"=>$scoreTotal,
						 "score"=>$score,
						 "correct"=>$correct,						 
						 "quizAns"=>$quizArray,
						 "userAns"=>$userAns,
						 "userOptionAns"=>$userTemp,
						 "state"=>$this->userMeta()						 
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
	
	function findTips()
	{
		$_id=$this->input->post("id");
		$this -> load -> model('exam/exam/m_question', 'question');
		
		$itemList=array("tipStep"=>$this -> question -> findQuestion(array('id' => $_id)));
				
		$this -> layout -> setLayout('layout/empty');
		$this -> layout -> view('view/exam/practice/tipsStep', $itemList);
	}
	
	function reStart()
	{
		$_uuid=$this->input->post("uuid");
		$this -> load -> model('exam/exam/m_answer', 'answer');
		$this->answer->updAnswer(array("finish"=>"true"),array("nodes_uuid"=>$_uuid));
		
	}
	private function userMeta() {
		$this -> load -> view('view/userMeta');
	}

}
