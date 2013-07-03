<?php
if (!defined('BASEPATH'))
	exit('No direct script access allowed');

class MapController extends MY_Controller {
	
	
	/**
	 * 知識結構圖
	 */
	public function index() {
		
		//echo $this->input->get("id");;
		
		$this -> load -> model('exam/map/m_link', 'link');
		$this -> load -> model('exam/map/m_node', 'node');
		$this -> load -> model('exam/map/m_subject', 'subject');
		$this -> load -> model('member_model', 'member');	
		
		
		$user = $this -> session -> userdata('user');
		$rank = $user[0] -> rank;
		
		if($rank<3)
		{
			$itemList = array(
			"link" => $this -> link,
			"node" => $this -> node,
			"controllerInstance" => $this,
			"sunjectList"	=>	$this->subject->allSubject() ,
			"teacherList"	=>	$this->member->get(array("rank"=>"2")),
			"itemList"=>array(
							array("back","./index.php/home", "返回主選單"),
							array("examManage","./index.php/exam", "管理試卷"),			
							array("map","./index.php/map", "知識結構圖"),
							/*array("result","./index.php/exam", "試題分析"),*/
							array("practice","./index.php/practice", "線上測驗"),			
							array("logout","./index.php/login/logout", "登出帳號")
			),
			"state"	=>$this->userMeta());
		}
		else
		{
			$itemList = array(
			"link" => $this -> link,
			"node" => $this -> node,
			"controllerInstance" => $this,
			"itemList"=>array(
				array("back","./index.php/home", "返回主選單"),									
				array("map","./index.php/map", "知識結構圖"),
				array("practice","./index.php/practice", "線上測驗"),
				array("logout","./index.php/login/logout", "登出帳號")
				),
			"state"	=>$this->userMeta());
			
		}		
		
		$this -> layout -> addScript("js/jquery.transform2d.js");
		$this -> layout -> addScript("js/exam/exam/examLock.js");
		$this -> layout -> addScript("js/exam/practice/default.js");
		$this -> layout -> addScript("js/knowledge/def.js");
		$this -> layout -> addScript("js/knowledge/json2.js");
		$this -> layout -> addScript("js/jquery.color.js");
		$this -> layout -> addScript("js/exam/map/default.js");
		
		$this -> layout -> addStyleSheet("css/knowledge/css.css");
		$this -> layout -> addStyleSheet("css/knowledge/controlbar.css");
		$this -> layout -> addStyleSheet("css/knowledge/toolsbar.css");
		//$this -> layout -> view('view/exam/map/map', $itemList);
		$this -> layout -> view('view/exam/map/default', $itemList);
		
		//echo $this->input->get("id");;
	}	

	public function map() {
		//echo '123';
		
		$this -> load -> model('exam/map/m_link', 'link');
		$this -> load -> model('exam/map/m_node', 'node');
		$this -> load -> model('exam/map/m_subject', 'subject');
		$this -> load -> model('member_model', 'member');	
		
		$user = $this -> session -> userdata('user');
		$rank = $user[0] -> rank;
		
		if($rank<3)
		{
			$itemList = array(
			"link" => $this -> link,
			"node" => $this -> node,
			"controllerInstance" => $this,
			"sunjectList"	=>	$this->subject->allSubject() ,
			"teacherList"	=>	$this->member->get(array("rank"=>"2")),
			"itemList"=>array(
							array("back","./index.php/home", "返回主選單"),
							array("examManage","./index.php/exam", "管理試卷"),			
							array("map","./index.php/map", "知識結構圖"),
							array("practice","./index.php/practice", "線上測驗"),			
							array("logout","./index.php/login/logout", "登出帳號")
			),
			"state"	=>$this->userMeta());
		}
		else
		{
			$itemList = array(
			"link" => $this -> link,
			"node" => $this -> node,
			"controllerInstance" => $this,
			"itemList"=>array(
				array("back","./index.php/home", "返回主選單"),									
				array("map","./index.php/map", "知識結構圖"),
				array("practice","./index.php/practice", "線上測驗"),
				array("logout","./index.php/login/logout", "登出帳號")
				),
			"state"	=>$this->userMeta());
			
		}		
		
		$this -> layout -> addScript("js/jquery.transform2d.js");
		//$this -> layout -> addScript("js/exam/exam/examLock.js");
		//$this -> layout -> addScript("js/exam/practice/default.js");
		$this -> layout -> addScript("js/knowledge/def.js");
		$this -> layout -> addScript("js/knowledge/json2.js");
		$this -> layout -> addScript("js/jquery.color.js");
		//$this -> layout -> addScript("js/exam/map/default.js");
		
		$this -> layout -> addStyleSheet("css/knowledge/css.css");
		$this -> layout -> addStyleSheet("css/knowledge/controlbar.css");
		$this -> layout -> addStyleSheet("css/knowledge/toolsbar.css");
		$this -> layout -> view('view/exam/map/map', $itemList);
	}
	
	public function addNode() {
		$str = $this->input->post("data");
		$json = json_decode($str);
				
		//print_r($json) ;
		foreach($json as $i => $item)
		{
			//echo $item->type;
			if($item->type == "point")
			{
				$itemList = array(
				"type" => "point",
				"pid" => $item->pid,				
				"lid" => $item->lid,
				"ch_lid" => $item->ch_lid,
				"name" => $item->text,
				"x" => $item->x,
				"y" => $item->y,
				"level" => $item->level,
				"media" => $item->media,
				"km_id" => $item->km_id
				);
				
				//寫入資料庫
				$this->load->model('exam/map/m_node', 'map');
				$this->map->addNode($itemList);
			}
			else if($item->type == "line")
			{
				$itemList = array(
				"type" => "line",
				"lid" => $item->lid,
				"node_from" => $item->cid,
				"node_to" => $item->tid,
				"width" => $item->width,
				"z" => $item->deg, //z
				"x" => $item->x,
				"y" => $item->y,
				"level" => $item->level,
				"is_child" => '0',
				"km_id" => $item->km_id
				);

				$this->load->model('exam/map/m_link', 'link');
				$this->link->addLink($itemList);
			}
			else if($item->type == "chLine")
			{
				$itemList = array(
				"type" => "chLine",
				"lid" => $item->ch_lid,
				"node_from" => $item->cid,
				"node_to" => $item->tid,
				"width" => $item->width,
				"z" => $item->deg, //z
				"x" => $item->x,
				"y" => $item->y,
				"level" => $item->level,
				"is_child" => '1',
				"km_id" => $item->km_id
				);
				
				//寫入資料庫
				$this->load->model('exam/map/m_link', 'link');
				$this->link->addLink($itemList);
			}
			
			$itemList = array();
		}		

		//echo $json;
		
	}
	
	public function readNode() {
		$km_id = $this->input->post("km_id");
		$this->load->model('exam/map/m_link', 'link');
		$this->load->model('exam/map/m_node', 'node');
		
		$con = array(
			"km_id" => $km_id
		);
		
		$node = $this->node->findNode($con);
		$link = $this->link->findLink($con);
		
		echo json_encode(array_merge($node,$link));
	}
	
	public function updNode() {
		$this->load->model('exam/map/m_link', 'link');
		$this->load->model('exam/map/m_node', 'node');
		
		
		$node = $this->node->allNode();
		$link = $this->link->allLink();
		
		$str = $this->input->post("data");
		$json = json_decode($str);
		
		
		foreach($json as $i => $item)
		{
			if($item->type == "point")
			{
					
				
				
				$n_ary = array(
					"pid" => $item->pid
				);
				
				//echo "media: " . $item->media;
				
				$itemList = array(
					"type" => "point",
					"pid" => $item->pid,				
					"lid" => $item->lid,
					"ch_lid" => $item->ch_lid,
					"name" => $item->text,
					"x" => $item->x,
					"y" => $item->y,
					"level" => $item->level,
					"media" => $item->media,
					"uuid" => $item->uuid,
					"km_id" => $item->km_id
					);
					
				$compare = array(
				"pid" => $item->pid
				);
				
				//echo "media =>" . $item->media;
				
				if($this->node->findNode($n_ary))
				{
					
					$this->node->updNode($itemList, $compare);
				}
				else
				{
					
					$this->node->AddNode($itemList);
				}
			}
			
			else if($item->type == "line")
			{
				
				
				$n_ary = array(
					"lid" => $item->lid
				);
				
				$itemList = array(
					"type" => "line",
					"lid" => $item->lid,
					"node_from" => $item->cid,
					"node_to" => $item->tid,
					"width" => $item->width,
					"z" => $item->deg, //z
					"x" => $item->x,
					"y" => $item->y,
					"is_child" => '0',
					"level" => $item->level,
					"km_id" => $item->km_id
				);
				
				//echo 'upd line data: ';
					
				$compare = array(
				"lid" => $item->lid
				);
				if($this->link->findLink($n_ary))
				{
					
					$this->link->updLink($itemList, $compare);
				}
				else
				{
					$this->link->AddLink($itemList);
				}
			}
			else if($item->type == "chLine")
			{
				$n_ary = array(
					"lid" => $item->ch_lid
				);
				
				$itemList = array(
					"type" => "chLine",
					"lid" => $item->ch_lid,
					"node_from" => $item->cid,
					"node_to" => $item->tid,
					"width" => $item->width,
					"z" => $item->deg, //z
					"x" => $item->x,
					"y" => $item->y,
					"is_child" => '1',
					"level" => $item->level,
					"km_id" => $item->km_id
				);
					
				$compare = array(
				"lid" => $item->ch_lid
				);
				if($this->link->findLink($n_ary))
				{
					
					$this->link->updLink($itemList, $compare);
				}
				else
				{
					$this->link->AddLink($itemList);
				}
			}
		}
		
		
	}

	function delNode() {
		$this->load->model('exam/map/m_node', 'node');
				
		$str = $this->input->post("data");
		$json = json_decode($str);
		
		
		if($json->type == "point")
		{
			$item = array(
				"pid" => $json->pid
			);
			$this->node->delNode($item);
			
		}
		
	}
	
	function delLink() {
		$this->load->model('exam/map/m_link', 'link');
				
		$str = $this->input->post("data");
		$json = json_decode($str);
		
		//echo $json;
		
		if($json->type == "line")
		{
			$item = array(
				"lid" => $json->lid,
				"type" => $json->type
			);
			$this->link->delLink($item);
			
		}
		else if($json->type == "chLine")
		{
			$item = array(
				"lid" => $json->ch_lid,
				"type" => $json->type
			);
			$this->link->delLink($item);
		}		
	}
	
	public function kmList(){
		$t	=$this->input->post("tId");
		$sub=$this->input->post("subjectId");
		$this -> load -> model('exam/map/m_km', 'km');		
		if(empty($sub))
		{
			$search=array("t_id"=>$t);
		}else if(empty($t))
		{
			$search=array("subject_id"=>$sub);
		}else{
			$search=array("subject_id"=>$sub,"t_id"=>$t);
		}		
		
		echo json_encode($this->km->findKm($search));		
	}
	
	private function userMeta() {
		return $this -> load -> view('view/userMeta',"",true);
	}
}
