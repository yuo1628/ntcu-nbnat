<?php
if (!defined('BASEPATH'))
	exit('No direct script access allowed');

class NodeController extends MY_Controller {
	
	public function index() {
		
		$this->load->model('exam/map/m_node','node');	
		$date=$this->node->allNode();	
		$item = array(
			"itemList"=>array(
				array("back","./index.php/exam", "返回選單"),
				array("news","./index.php/map", "知識結構圖"),
				array("exam","./index.php/node", "指標管理"),			
				array("logout","./", "登出帳號")			
			),"result"=>$date);
			
		$this -> layout -> addStyleSheet("css/exam/map/node.css");
		$this -> layout -> addScript("js/exam/map/node.js");
		$this -> layout -> view('view/exam/node', $item);
	}	
	
	public function addNode($_value) {		
		$input_date=array(
		   'name' => $_value ,
		   'level' => '1'		   
		);		
		$this->load->model('exam/map/m_node','node');		
		$this->node->addNode($input_date);							
	}
	public function updNode($_id,$_value) {
		
		$date=array(		   
		   'name' =>$_value		   
		);		
		$con=array('id' => $_id);
		$this->load->model('exam/map/m_node','node');		
		$this->node->updNode($date,$con);								
	}	
	public function delNode($_id) {
		$date=array(
			   'id' => $_id			  	   
			);	
		$this->load->model('exam/map/m_node','node');		
		$this->node->delNode($date);	
			
	}	
	public function addLink($_from,$_to) {
				
		$date=array(
			   'node_from' => $_from,
			   'node_to'=>	$_to		  	   
			);	
		$this->load->model('exam/map/m_link','link');		
		$this->link->addLink($date);				
	}
	public function findLinkTo($_from) {
			
		$date=array(
			   'node_from' => $_from			   	  	   
		);	
		$this->load->model('exam/map/m_link','link');			
		
		$result = array("result"=>$this->link->findLink($date));
			
		$this->layout->setLayout('layout/empty');
		$this->layout->view('view/result.php',$result);
	}
	
	public function delLink($_from,$_to) {
		$date=array(
			   'node_from' => $_from,
			   'node_to' => $_to			  	   
			);	
		$this->load->model('exam/map/m_link','link');		
		$this->link->delLink($date);	
			
	}
}
