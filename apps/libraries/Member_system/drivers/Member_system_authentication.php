<?php

// ���ѨϥΪ̵n�J�B�n�X�\��
class Member_system_authentication extends CI_Driver {
	
	// ����SESSION�ϥΪ��e��
	public $PREFIX = 'member_system_authentication_';
	
	private $CI;
	
	public function __construct() {
		$this->CI = & get_instance();
		$this->CI->load->library('session');
		$this->CI->load->model('member_model');
	}
	
	// �n�J
	// �^��True��ܵn�J���\
	// �^��False��ܵn�J����
	public function login($username, $password) {
		$userData = array($this->CI->member_model->USERNAME => $username,
						  $this->CI->member_model->PASSWORD => $password);
		$users = $this->CI->member_model->get($userData);
		// �䤣����w�ϥΪ̪����(�b���αK�X��J���~)
		if (!$users) {
			return FALSE;
		}
		$user = $users[0]; // get��k�^�ǥ]�t�d�ߨ쪺�ϥΪ̪��}�C
		// ����session
		$key_pk = $this->CI->member_model->to_database_column_name($this->CI->member_model->PK);
		$pk = $user->$key_pk;
		$this->CI->session->set_userdata($this->PREFIX . $this->CI->member_model->PK, $pk);
		return TRUE;
	}
	
	// �O�_�ثe���Τ�ݤw�g�n�J
	// �^��True��ܤw�g�n�J�AFalse����٥��n�J
	public function isLogin() {
		if ($this->CI->session->userdata($this->PREFIX . $this->CI->member_model->PK)) {
			return TRUE;
		} else {
			return FALSE;
		}
	}
	
	// ���o�w�n�J�ϥΪ̪����
	// �^��Member���O����
	// �^��False��ܨϥΪ̩|���n�J
	public function getLoginUser() {
		$user_pk = $this->CI->session->userdata($this->PREFIX . $this->CI->member_model->PK);
		if (!$user_pk) {
			return False;
		}
		$member = $this->getEmptyMemberInstance();
		// ��J�ϥΪ̸��
		$userData = $this->CI->member_model->get(array($this->CI->member_model->PK => $user_pk))[0]; // array
		foreach ($userData as $key => $value) {
			$this->fillUserData($key, $value, $member);
		}
		// ��J�A�ȳ����
		$key_unit_id = 'unit_id';
		$unitPk = $userData->$key_unit_id;
		$unitData = $this->CI->member_model->get_unit(array($this->CI->member_model->UNIT_PK => $unitPk))[0];
		foreach ($unitData as $key => $value) {
			$this->fillUnitData($key, $value, $member);
		}
		// ��J�Z�Ÿ��
		$key_class_id = 'class_id';
		$classPk = $userData->$key_class_id;
		$classData = $this->CI->member_model->get_class(array($this->CI->member_model->CLASS_PK => $classPk))[0];
		foreach ($classData as $key => $value) {
			$this->fillClassData($key, $value, $member);
		}
		// ��J�Ǯո��
		$key_school_id = 'school_id';
		$schoolPk = $classData->$key_school_id;
		$schoolData = $this->CI->member_model->get_school(array($this->CI->member_model->SCHOOL_PK => $schoolPk))[0];
		foreach ($classData as $key => $value) {
			$this->fillClassData($key, $value, $member);
		}
		// ��J�������
		$key_city_id = 'city_id';
		$cityPk = $schoolData->$key_city_id;
		$cityData = $this->CI->member_model->get_city(array($this->CI->member_model->CITY_PK => $cityPk))[0];
		foreach ($cityData as $key => $value) {
			$this->fillCityData($key, $value, $member);
		}
		return $member;
	}
	
	// �N�ϥΪ̸�ƶ�JMember���O����������ݩ�
	// �^��True��ܶ�J���\�A�_�h�^��False
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
	
	// �N�Z�Ÿ�ƶ�JMember���O����������ݩ�
	// �^��True��ܶ�J���\�A�_�h�^��False
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

	// �N�Ǯո�ƶ�JMember���O����������ݩ�
	// �^��True��ܶ�J���\�A�_�h�^��False
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
	
	// �N�A�ȳ���ƶ�JMember���O����������ݩ�
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
	
	// �N������ƶ�JMember���O����������ݩ�
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
	
	// �^��False��ܨϥΪ̩|���n�J
	// �n�X�t��
	public function logout() {
		// �u�M���P�n�J�t�ά��������
		$this->CI->session->unset_userdata($this->PREFIX . $this->CI->member_model->PK);
	}
}
?>