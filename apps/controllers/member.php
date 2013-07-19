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
	public function edit()
	{
	    $user=$this->session->userdata("user");

	    $this -> load -> model('member_model', 'member');
		$itemList=$this->_mainmenu();
        $itemList["member_profile"]  =   $user;
        $class=$this -> member -> get_class(array("class_pk"=>$user[0]->class_id));
        $itemList["member_class"]  =  $class;
		$this -> layout -> addStyleSheet("css/member/edit.css");
		$this -> layout -> view('view/member/default', $itemList);
	}
	public function create() {
		$this -> load -> model('member_model', 'member');
		$itemList=$this->_mainmenu();

		$itemList["city_list"]	=	$this -> member -> get_city("");
		$itemList["school_type"]=	$this -> member -> get_schoolType();
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
		 array("read", "./index.php/member", "查看帳號資訊"),
		 array("edit", "./index.php/member", "修改個人資料"),
		 array("create", "./index.php/member/create", "建立會員帳號"),
		 array("manage", "./index.php/member/manage", "管理會員帳號"),
		 array("logout", "./index.php/login/logout", "登出帳號")
		),"state"=>$this->userMeta());
		return $itemList;
	}
	private function userMeta() {
		return $this -> load -> view('view/userMeta',"",TRUE);
	}
	public function selectSchoolOption()
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

	}
	public function selectClassOption()
	{
		$key			=	$this->input->post("key");
		$value			=	$this->input->post("value");
		$search_index	=	array();
		foreach ($key as $i=>$column) {
           $search_index[$column]=$value[$i];
        }
		$this -> load -> model('member_model', 'member');
		$optionList		=	$this -> member -> get_class($search_index);
		echo json_encode($optionList);
	}
    public function selectUnitOption()
    {

        $this -> load -> model('member_model', 'member');
        $unitList     =   $this -> member -> get_unit("");
        echo json_encode($unitList);
    }
    public function insertUnit()
    {
        $this -> load -> model('member_model', 'member');
        $unit_id=$this->member->insert_unit(array("unit_name"=>$this->input->post("unit_name")));
        echo $unit_id;
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
									"school_type"	=>	$this->input->post("school_type"),
									"school_name"	=>	$this->input->post("school_name"),
									"school_address"=>	$this->input->post("school_address"),
									"school_phone"	=>	$this->input->post("school_phone"),
									"school_city_id"=>	$this->input->post("city_id")
									));
		echo $_schoolId;
	}

	public function insertClass()
	{
		$this -> load -> model('member_model', 'member');
		$_classId=$this->member->insert_class(array(
									"class_type"	=>	$this->input->post("class_type"),
									"class_grade"	=>	$this->input->post("class_grade"),
									"class_name"=>	$this->input->post("class_name"),
									"class_school_id"	=>	$this->input->post("class_school_id")
									));
		echo $_classId;
	}
	public function insertUser()
	{
		$user_value	=	$this->input->post("value");
		$this -> load -> model('member_model', 'member');
		$this -> member -> insert($user_value);

	}
	public function findUserRank()
	{
		$user=$this->session->userdata("user");
		echo $user[0]->rank;
	}
}
