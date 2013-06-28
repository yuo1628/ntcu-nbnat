<?php
if (!defined('BASEPATH'))
	exit('No direct script access allowed');
class MemberController extends MY_Controller {

	/**
	 * Home Page for Home controller.
	 */
	public function index() {
		$this->edit();
	}
	public function edit() {
		$this -> layout -> view('view/member/default', $this->_mainmenu());
	}
	public function create() {
		$this -> load -> model('member_model', 'member');		
		$itemList=$this->_mainmenu();
		
		$itemList["city_list"]	=	$this -> member -> get_city("");
		$itemList["school_type"]=	$this -> member -> get_schoolType();
		$itemList["class_type"]	=	$this -> member -> get_classGroupBy("type");
		$itemList["class_grade"]	=	$this -> member -> get_classGroupBy("grade");
		$itemList["class_name"]	=	$this -> member -> get_classGroupBy("name");
		$this -> layout -> addScript("js/member/create.js");		
		$this -> layout -> addStyleSheet("css/member/create.css");
		$this -> layout -> view('view/member/create',$itemList);
		
	}
	public function manage() {
		$this -> layout -> view('view/member/manage', $this->_mainmenu());
	}
	private function _mainmenu()
	{
		$itemList = array("itemList" => array(
		 array("back","./index.php/home", "返回主選單"),
		 array("edit", "./index.php/member", "修改個人資料"), 
		 array("create", "./index.php/member/create", "建立會員帳號"), 
		 array("manage", "./index.php/member/manage", "管理會員帳號"),
		 array("logout", "./", "會員登出")
		));
		return $itemList;
	}	
	public function selectOption()
	{
		$key			=	$this->input->post("key");
		$value			=	$this->input->post("value");
		$search_index	=	array();
		foreach ($key as $i=>$column) {
           $search_index[$column]=$value[$i];
        }
		$this -> load -> model('member_model', 'member');			
		$optionList		=	$this -> member -> get_school($search_index);
		echo json_encode($optionList);
		//$this -> layout -> setLayout('layout/empty');
		//$this -> layout -> view('view/member/selectOption', $optionList);
	}
	
	public function insertCity()
	{
		$this -> load -> model('member_model', 'member');	
		$city_id=$this->member->insert_city(array("city_name"=>$this->input->post("city_name")));
		echo $city_id;
	}
	
	public function insertSchool()
	{		
		$this -> load -> model('member_model', 'member');	
		$_schoolId=$this->member->insert_school(array(
									"school_type"=>$this->input->post("school_type"),
									"school_name"=>$this->input->post("school_name"),
									"school_address"=>$this->input->post("school_address"),
									"school_phone"=>$this->input->post("school_phone"),
									"school_city_id"=>$this->input->post("city_id")
									));	
		echo $_schoolId;			
	}
	
	public function insertClass($_schoolId)
	{
		
	}

}
