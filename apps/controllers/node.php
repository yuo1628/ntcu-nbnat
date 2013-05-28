<?php
if (!defined('BASEPATH'))
	exit('No direct script access allowed');

class NodeController extends MY_Controller {

	public function index() {

		$this -> load -> model('exam/map/m_node', 'node');
		$data = $this -> node -> allNode();
		$item = array(
				"itemList" => array( 
					array("back", "./index.php/exam", "返回選單"),
					array("news", "./index.php/map", "知識結構圖"), 
					array("exam", "./index.php/node", "指標管理"), 
					array("logout", "./", "登出帳號")
					),
				 "result" => $data);

		$this -> layout -> addStyleSheet("css/exam/map/node.css");
		$this -> layout -> addScript("js/exam/map/node.js");
		$this -> layout -> view('view/exam/map/node', $item);
	}

	public function addNode($level = 1, $parent = null, $first = 0) {
		$_value=$this->input->post("value");
		
		$input_date = array('name' => $_value, 'level' => $level, 'parent_node' => $parent, 'first_child' => $first);
		$this -> load -> model('exam/map/m_node', 'node');
		$_id = $this -> node -> addNode($input_date);
		if ($level == "1") 
		{
			$this -> addNode('2', $_id, '1');
		}

	}

	public function updNode($_id) {
		$_value=$this->input->post("value");

		$date = array('name' => $_value);
		$con = array('id' => $_id);
		$this -> load -> model('exam/map/m_node', 'node');
		$this -> node -> updNode($date, $con);
	}

	public function delNode($_id) {
		$con = array('id' => $_id);
		$this -> load -> model('exam/map/m_node', 'node');
		$this -> node -> delNode($con);
	}

	public function addLink($_from, $_to) {
		$date = array('node_from' => $_from, 'node_to' => $_to);
		$this -> load -> model('exam/map/m_link', 'link');
		$this -> link -> addLink($date);
	}

	public function delLink($_from, $_to) {
		$_from=$this->input->post("from");
		$_to=$this->input->post("to");
		$date = array();
		if($_from)
		{
			$date = array('node_from' => $_from);
		}
		if($_to)
		{
			$date = array('node_to' => $_to);
		}
		
		
		$this -> load -> model('exam/map/m_link', 'link');
		$this -> link -> delLink($date);
	}

	function nodeTemplate($_id) {
		$this -> load -> model('exam/map/m_link', 'link');
		$this -> load -> model('exam/map/m_node', 'node');
		$allNode = $this -> node -> allNode();
		$item = array(
			'id' => $_id, 
			"result" => $allNode, 
			"node_to" => $this -> link -> findLinkToName($_id), 
			"childFirst" => $this -> node -> findNode(array(
													'parent_node' => $_id, 
													'first_child' => '1')), 
			"childRote" => $this -> node -> findFirstNode($_id),
			"childList" => $this -> node -> findNode(array(
													'parent_node' => $_id, 
													'first_child' => '0'))
			);
		$this -> layout -> setLayout('layout/empty');
		$this -> layout -> addStyleSheet("css/exam/map/nodeTemplate.css");
		$this -> layout -> view('view/exam/map/nodeTemplate.php', $item);
	}

	public function addNodeAndLink($parent, $_to) {
		$_value=$this->input->post("value");
		
		$input = array('name' => $_value, 'level' => "2", 'parent_node' => $parent);
		$this -> load -> model('exam/map/m_node', 'node');
		$_id = $this -> node -> addNode($input);
		$this -> load -> model('exam/map/m_link', 'link');
		$_from = $this -> link -> findLink(array('node_to' => $_to));
	

		$link = array('node_from' => $_id, 'node_to' => $_to);
		$this -> load -> model('exam/map/m_link', 'link');
		$this -> link -> addLink($link);
		
		$this -> link -> updLink(array('node_to' => $_id),array('node_from' => $_from[0]->node_from));
		
	}
	public $str="";

	public function findRote($_id) {

		$result = $this -> findFrom($_id);
		if (!$result) {
			$item = array("node_rote" => $this->str);
			$this -> layout -> setLayout('layout/empty');
			$this -> layout -> view('view/exam/map/default.php', $item);
			
		} else {
			$this->str.="<= <div class='child' id='child-".$result->node_from."'  onclick=\"childEdit('".$result -> parent_node."','".$result -> node_from."')\">".$result->name."</div>";
			$this->findRote($result->node_from);
		}
	}

	public function findFrom($_id) {
		$this -> load -> model('exam/map/m_link', 'link');
		$item = $this -> link -> findLinkFromName($_id);

		if ($item == null) {
			return false;
		} else {

			return $item[0];
		}
	}

}
