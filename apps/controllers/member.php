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
    
    /**
     * 會員匯入匯出
     * 
     * @access public
     */
    public function bridge() {
        $this->load->driver('member_system');
        $data = $this->_mainmenu();
        $data['post_url'] = './index.php/member/bridge';
        $data['types'] = array('CSV', 'Excel2007');
        $data['errors'] = array();
        $data['infos'] = array();
        
        $submitType = $this->input->post('submit');
        switch ($submitType) {
            // 匯入會員資料
            case '1':
                if (isset($_FILES['excel'])) {
                    $hasTitle = $this->input->post('hastitle');
                    $errors = $this->bridge_import($_FILES['excel']['tmp_name'], $hasTitle);
                    if ($errors) {
                        $data['errors'] = array_merge($data['errors'], $errors);
                    } else {
                        $data['infos'][] = '會員資料匯入成功';
                    }
                }
                break;
            // 匯出會員資料
            case '2':
                $type = $this->input->post('type'); // return False on failed
                if ($type !== FALSE) {
                    $result = $this->bridge_export($type);
                    if ($result) {
                        return;
                    } else {
                        $data['errors'][] = '會員資料匯出發生錯誤';
                    }
                }
                break;
            // 操作頁面
            default:
        }
        
        $this-> layout -> view('view/member/bridge', $data);
    }
    
    /**
     * 匯入會員資料
     *
     * @access private
     * @return array 包含錯誤訊息的陣列
     */
    private function bridge_import($filePath, $hasTitle) {
        $this->load->driver('member_system');
        // 讀取指定檔案（記得Catch PHPExcel_Reader_Exception）
        try {
            //print (new finfo(FILEINFO_MIME))->file($filePath);
            //$this->member_system->importer->importMembersFromExcel($filePath, $hasTitle);
            //header('Content-Type: text/html; charset=utf-8;');
            //print '<pre>';
            //print_r($this->member_system->importer->readMembersFromExcel($filePath, $hasTitle));
            //print '</pre>';
            try {
                $this->member_system->importer->importMembersFromExcel($filePath, $hasTitle);
            } catch (LengthException $e) {
                return array($e->getMessage());
            } catch (InvalidArgumentException $e) {
                return array($e->getMessage());
            }
        } catch (PHPExcel_Reader_Exception $e) {
            return array('檔案讀取失敗');
        }
        // 匯入資料
        return array();
    }
    
    /**
     * 匯出會員資料
     *
     * 匯出檔名以日期命名
     *
     * @access private
     * @return boolean 匯出成功回傳True，否則回傳False
     */
    private function bridge_export($type) {
        $this->load->driver('member_system');
        $tmpfname = tempnam('./media', 'FOO');
        // 檢查指定檔案類型（記得Catch PHPExcel_Reader_Exception）
        try {
            // 匯出會員資料
            $this->member_system->exporter->writeMembersToExcel($tmpfname, True, $type);
        } catch (PHPExcel_Reader_Exception $e) {
            return False;
        }
        
        // 寫出headers和檔案內容
        $this->output->set_content_type('application/octet-stream');
        $this->output->set_header('Content-Disposition: attachment; filename="' . (new DateTime())->format('Y-m-d') . '.xlsx"');
        $this->output->set_output(file_get_contents($tmpfname));
        return True;
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
