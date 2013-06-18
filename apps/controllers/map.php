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
		
		$itemList = array(
			"link" => $this -> link,
			"node" => $this -> node,
			"controllerInstance" => $this,
			"itemList"=>array(
			array("back","./index.php/exam", "返回選單"),
			array("news","./index.php/map", "知識結構圖"),
			array("exam","./index.php/node", "指標管理"),			
			array("logout","./", "登出帳號")
			));
			
			
		$this -> layout -> addScript("js/knowledge/def.js");
		$this -> layout -> addScript("js/knowledge/json2.js");
		$this -> layout -> addStyleSheet("css/knowledge/css.css");
		$this -> layout -> addStyleSheet("css/knowledge/controlbar.css");
		$this -> layout -> addStyleSheet("css/knowledge/toolsbar.css");
		$this -> layout -> view('view/exam/map/map', $itemList);
		
	}	
	
	public function addNode() {
		$str = $this->input->post("data");
		$json = json_decode($str);
		
		$itemList = array();
		
		
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
				"y" => $item->y
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
	
	
	
}
