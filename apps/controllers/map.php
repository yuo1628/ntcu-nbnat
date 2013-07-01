<?php
if (!defined('BASEPATH'))
	exit('No direct script access allowed');

class MapController extends MY_Controller {
	
	
	/**
	 * 知識結構圖
	 */
	public function index() {
		$this -> load -> model('exam/map/m_link', 'link');
		$this -> load -> model('exam/map/m_node', 'node');
					
		$session = $this->session->userdata('who');
		
		if(empty($session) || $session == '0')
		{
			$itemList = array(
			"link" => $this -> link,
			"node" => $this -> node,
			"controllerInstance" => $this,
			"itemList"=>array(
			array("back","./index.php/exam", "返回選單"),
			array("map","./index.php/map", "知識結構圖"),
			array("node","./index.php/node", "指標管理"),			
			array("logout","./", "登出帳號")
			));
		}
		else
		{
			$itemList = array(
			"link" => $this -> link,
			"node" => $this -> node,
			"controllerInstance" => $this,
			"itemList"=>array(
				array("map","./index.php/map", "知識結構圖"),
				array("practice","./index.php/practice", "線上測驗"),
				array("logout","./", "登出帳號")
				));
			
		}		
			
		$this -> layout -> addScript("js/exam/exam/examLock.js");
		$this -> layout -> addScript("js/exam/practice/default.js");
		$this -> layout -> addScript("js/knowledge/def.js");
		$this -> layout -> addScript("js/knowledge/json2.js");
		$this -> layout -> addScript("js/jquery.color.js");
		
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
				"media" => $item->media
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
				"is_child" => '0'
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
				"is_child" => '1'
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
		$this->load->model('exam/map/m_link', 'link');
		$this->load->model('exam/map/m_node', 'node');
		
		$node = $this->node->allNode();
		$link = $this->link->allLink();
		
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
					"media" => $item->media
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
					"level" => $item->level
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
					"level" => $item->level
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
	
}
