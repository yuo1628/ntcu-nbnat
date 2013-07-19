<?php
if (!defined('BASEPATH'))
	exit('No direct script access allowed');

class ExamController extends MY_Controller {

	public function index($id) {
		$this -> load -> model('exam/map/m_link', 'link');
		$this -> load -> model('exam/map/m_node', 'node');
		$this -> load -> model('exam/map/m_subject', 'subject');
		$this -> load -> model('member_model', 'member');
		$this -> load -> model('exam/map/m_km', 'km');

		$node = $this -> node -> findNode(array("km_id"=>$id));
		$km=$this->km->findKmById($id);

		$s_name=$this->subject->findSubjectById($km[0]->subject_id);
		$t_name=$this->member->get(array("id"=>$km[0]->t_id));


		$user = $this -> session -> userdata('user');

		$itemList = array("itemList"=>array(
							array("back","./index.php/home", "返回主選單"),
							array("manage","./index.php/map/manage", "管理知識結構圖"),
							array("read","./index.php/map", "查看知識結構圖"),
							array("logout","./index.php/login/logout", "登出帳號")
					), 	"result" 	=> 	$node,
						"state"		=>	$this->userMeta());
		$itemList['kmGrade'] =$km[0]->grade;
		$itemList['kmSub'] =$s_name[0]->subject;
		$itemList['tName'] = $t_name[0]->name;
		$itemList['childList'] =array();

		$exist_uuid = '0';

		foreach ($node as $item){
			//print_r($item);
			if($exist_uuid != $item->uuid)
			{
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


			$exist_uuid = $item->uuid;
		}

		$this -> layout -> addStyleSheet("css/exam/exam/examLock.css");


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

	public function lockToggle()
	{
		$_uuid = $this -> input -> post("uuid");
		$_lock = $this -> input -> post("lock");
		$this -> load -> model('exam/map/m_node', 'node');
		$this -> node -> updNode(array('lock' => $_lock),array('uuid' => $_uuid));
	}

	function closePractice()
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
	private function userMeta() {
		return $this -> load -> view('view/userMeta','',TRUE);
	}



}
