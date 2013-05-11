<?php

// 提供使用者登入、登出功能
class Member_system_authentication extends CI_Driver {
	
	// 紀錄SESSION使用的前綴
	public $PREFIX = 'member_system_authentication_';
	
	private $CI;
	
	public function __construct() {
		$this->CI = & get_instance();
		$this->CI->load->library('session');
		$this->CI->load->model('member_model');
	}
	
	// 登入
	// 回傳True表示登入成功
	// 回傳False表示登入失敗
	public function login($username, $password) {
		$userData = array($this->CI->member_model->USERNAME => $username,
						  $this->CI->member_model->PASSWORD => $password);
		$users = $this->CI->member_model->get($userData);
		// 找不到指定使用者的資料(帳號或密碼輸入錯誤)
		if (!$users) {
			return FALSE;
		}
		$user = $users[0]; // get方法回傳包含查詢到的使用者的陣列
		// 紀錄session
		$key_pk = $this->CI->member_model->to_database_column_name($this->CI->member_model->PK);
		$pk = $user->$key_pk;
		$this->CI->session->set_userdata($this->PREFIX . $this->CI->member_model->PK, $pk);
		return TRUE;
	}
	
	// 是否目前的用戶端已經登入
	// 回傳True表示已經登入，False表示還未登入
	public function isLogin() {
		if ($this->CI->session->userdata($this->PREFIX . $this->CI->member_model->PK)) {
			return TRUE;
		} else {
			return FALSE;
		}
	}
	
	// 取得已登入使用者的資料
	// 回傳Member類別實體
	// 回傳False表示使用者尚未登入
	public function getLoginUser() {
		$user_pk = $this->CI->session->userdata($this->PREFIX . $this->CI->member_model->PK);
		if (!$user_pk) {
			return False;
		}
		$member = $this->getEmptyMemberInstance();
		// 填入使用者資料
		$userData = $this->CI->member_model->get(array($this->CI->member_model->PK => $user_pk))[0]; // array
		foreach ($userData as $key => $value) {
			$this->fillUserData($key, $value, $member);
		}
		// 填入服務單位資料
		$key_unit_id = 'unit_id';
		$unitPk = $userData->$key_unit_id;
		$unitData = $this->CI->member_model->get_unit(array($this->CI->member_model->UNIT_PK => $unitPk))[0];
		foreach ($unitData as $key => $value) {
			$this->fillUnitData($key, $value, $member);
		}
		// 填入班級資料
		$key_class_id = 'class_id';
		$classPk = $userData->$key_class_id;
		$classData = $this->CI->member_model->get_class(array($this->CI->member_model->CLASS_PK => $classPk))[0];
		foreach ($classData as $key => $value) {
			$this->fillClassData($key, $value, $member);
		}
		// 填入學校資料
		$key_school_id = 'school_id';
		$schoolPk = $classData->$key_school_id;
		$schoolData = $this->CI->member_model->get_school(array($this->CI->member_model->SCHOOL_PK => $schoolPk))[0];
		foreach ($classData as $key => $value) {
			$this->fillClassData($key, $value, $member);
		}
		// 填入城市資料
		$key_city_id = 'city_id';
		$cityPk = $schoolData->$key_city_id;
		$cityData = $this->CI->member_model->get_city(array($this->CI->member_model->CITY_PK => $cityPk))[0];
		foreach ($cityData as $key => $value) {
			$this->fillCityData($key, $value, $member);
		}
		return $member;
	}
	
	// 將使用者資料填入Member類別實體對應的屬性
	// 回傳True表示填入成功，否則回傳False
	protected function fillUserData($key, $value, &$member) {
		switch ($key) {
			case 'id':
				$member->id = $value;
				break;
			case 'username':
				$member->username = $value;
				break;
			case 'password':
				$member->password = $value;
				break;
			case 'name':
				$member->name = $value;
				break;
			case 'sex':
				$member->sex = $value;
				break;
			case 'rank':
				$member->rank = $value;
				break;
			case 'birthday':
				$member->birthday = $value;
				break;
			case 'ic_number':
				$member->ic_number = $value;
				break;
			case 'phone':
				$member->phone = $value;
				break;
			case 'tel':
				$member->tel = $value;
				break;
			case 'address':
				$member->address = $value;
				break;
			case 'email':
				$member->email = $value;
				break;
			default:
				return FALSE;
		}
		return TRUE;
	}
	
	// 將班級資料填入Member類別實體對應的屬性
	// 回傳True表示填入成功，否則回傳False
	protected function fillClassData($key, $value, &$member) {
		switch ($key) {
			case 'id':
				$member->class_id = $value;
				break;
			case 'type':
				$member->class_type = $value;
				break;
			case 'grade':
				$member->class_grade = $value;
				break;
			case 'name':
				$member->class_name = $value;
				break;
			default:
				return FALSE;
		}
		return TRUE;
	}

	// 將學校資料填入Member類別實體對應的屬性
	// 回傳True表示填入成功，否則回傳False
	protected function fillSchoolData($key, $value, &$member) {
		switch ($key) {
			case 'id':
				$member->school_id = $value;
				break;
			case 'type':
				$member->school_type = $value;
				break;
			case 'name':
				$member->school_name = $value;
				break;
			case 'address':
				$member->school_address = $value;
				break;
			case 'phone':
				$member->school_phone = $value;
			default:
				return FALSE;
		}
		return TRUE;
	}
	
	// 將服務單位資料填入Member類別實體對應的屬性
	protected function fillUnitData($key, $value, &$member) {
		switch ($key) {
			case 'id':
				$member->unit_id = $value;
				break;
			case 'name':
				$member->unit_name = $value;
				break;
			default:
				return FALSE;
		}
		return TRUE;
	}
	
	// 將城市資料填入Member類別實體對應的屬性
	protected function fillCityData($key, $value, &$member) {
		switch ($key) {
			case 'id':
				$member->city_id = $value;
				break;
			case 'name':
				$member->city_name = $value;
				break;
			default:
				return FALSE;
		}
		return TRUE;
	}
	
	// 回傳False表示使用者尚未登入
	// 登出系統
	public function logout() {
		// 只清除與登入系統相關的資料
		$this->CI->session->unset_userdata($this->PREFIX . $this->CI->member_model->PK);
	}
}
?>