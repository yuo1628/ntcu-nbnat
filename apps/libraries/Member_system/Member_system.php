<?php
if ( ! defined('BASEPATH')) {
    exit('No direct script access allowed');
}

/**
 * Member System
 *
 * @author yuo1628 <pors37@gmail.com>
 */
class Member_system extends CI_Driver_Library {
    // 使用者層級表示
    // 這些值應該不被更動
    const RANK_TEACHER = 'TEACHER';
    const RANK_STUDENT = 'STUDENT';
    const RANK_ADMIN = 'ADMIN';
    
    private $CI;
    
    /**
     * 初始化類別，並載入子Drivers
     * 
     * @access public
     */
    public function __construct()
    {
        $this->valid_drivers = array('member_system_authentication',
									 'member_system_member_management');
        $this->CI = & get_instance();
        $this->CI->load->model('member_model');
    }

    /**
     * 確認指定的使用者層級是否可使用
     *
     * @access public
     * @param string $rank 可傳入任何值，通常為一個代表使用者層級的字串
     * @return boolean，如果是合法的使用者層級會回傳True，否則回傳False
     */
    public function is_rank_avaiable($rank)
    {
        $ranks = array($this->RANK_TEACHER,
                       $this->RANK_STUDENT,
                       $this->RANK_ADMIN);
        return in_array($rank, $ranks);
    }
    
    /**
     * 從Model中取得指定的會員資料
     *
     * @access protected
     * @param array $member_data 指定條件的會員資料，指定的條件所查詢出
     * 的結果需是單一會員紀錄，否則此方法產出的結果會無法預期。
     * @return Member|NULL 回傳已填入指定會員資料的Member類別實體，如果
     * 找不到指定的會員，則回傳NULL。
     */
    public function model_to_member($member_data)
    {
        $member = $this->member_management->get_empty_member_instance();
		$userDataArray = $this->CI->member_model->get($member_data); // array
        // 如果為空陣列，則代表找不到指定會員資料
        if (!$userDataArray) {
            return NULL;
        }
        // 填入使用者資料
        $userData = $userDataArray[0];
		foreach ($userData as $key => $value) {
			$this->fill_member_user_data($key, $value, $member);
		}
		// 填入服務單位資料
		$key_unit_id = 'unit_id';
		$unitPk = $userData->$key_unit_id;
		$unitData = $this->CI->member_model->get_unit(array($this->CI->member_model->UNIT_PK => $unitPk))[0];
		foreach ($unitData as $key => $value) {
			$this->fill_member_unit_data($key, $value, $member);
		}
		// 填入班級資料
		$key_class_id = 'class_id';
		$classPk = $userData->$key_class_id;
		$classData = $this->CI->member_model->get_class(array($this->CI->member_model->CLASS_PK => $classPk))[0];
		foreach ($classData as $key => $value) {
			$this->fill_member_class_data($key, $value, $member);
		}
		// 填入學校資料
		$key_school_id = 'school_id';
		$schoolPk = $classData->$key_school_id;
		$schoolData = $this->CI->member_model->get_school(array($this->CI->member_model->SCHOOL_PK => $schoolPk))[0];
		foreach ($classData as $key => $value) {
            $this->fill_member_school_data($key, $value, $member);
		}
		// 填入城市資料
		$key_city_id = 'city_id';
		$cityPk = $schoolData->$key_city_id;
		$cityData = $this->CI->member_model->get_city(array($this->CI->member_model->CITY_PK => $cityPk))[0];
		foreach ($cityData as $key => $value) {
			$this->fill_member_city_data($key, $value, $member);
		}
		return $member;
    }
    
    /**
     * 將使用者資料填入Member類別實體對應的屬性
	 *
     * @access protected
     * @param string $key 資料庫的欄位名稱
     * @param mixed $value 資料庫的欄位值
     * @param Member $member 要被填入資料的Member類別實體
     * @return boolean 填入資料成功則回傳TRUE，否則回傳FALSE
     */
	protected function fill_member_user_data($key, $value, &$member) {
		switch ($key) {
			case 'id':
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
	
    /**
	 * 將班級資料填入Member類別實體對應的屬性
     *
     * @access protected
     * @param string $key 資料表的欄位名稱
     * @param mixed $value 資料表的欄位值
     * @param Member $member 要被填入資料的Member類別實體
	 * @return boolean 填入資料成功則回傳TRUE，否則回傳FALSE
     */
	protected function fill_member_class_data($key, $value, &$member) {
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

    /**
	 * 將學校資料填入Member類別實體對應的屬性
	 *
     * @access protected
     * @param string $key 資料表的欄位名稱
     * @param mixed $value 資料表的欄位值
     * @param Member $member 要被填入資料的Member類別實體
     * @return boolean 填入資料成功則回傳TRUE，否則回傳FALSE
     */
	protected function fill_member_school_data($key, $value, &$member) {
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
	
    /**
	 * 將服務單位資料填入Member類別實體對應的屬性
     *
     * @access public
     * @param string $key 資料表的欄位名稱
     * @param mixed $value 資料表的欄位值
     * @param Member $member 要被填入資料的Member類別實體
     * @return boolean 資料填入成功則回傳TRUE，否則回傳FALSE
     */
	protected function fill_member_unit_data($key, $value, &$member) {
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
	
    /**
	 * 將城市資料填入Member類別實體對應的屬性
     *
     * @access public
     * @param string $key 資料表的欄位名稱
     * @param mixed $value 資料表的欄位值
     * @param Member $member 要被填入資料的Member會員實體
     * @return boolean 資料填入成功則回傳TRUE，否則回傳FALSE
     */
	protected function fill_member_city_data($key, $value, &$member) {
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
	
	protected function fill_unit_unit_data($key, $value, &$unit)
	{
	}
    
    /**
     * 將Member類別實體轉換為member_model的會員資料陣列
     *
     * @access public
     * @param Member $member 要轉換的Member類別實體
     * @return array 符合member_model的會員資料格式的陣列，key為member_model的常數
     */
    public function member_to_array($member)
    {
        $member_array = array($this->CI->member_model->PK => $member->id,
                              $this->CI->member_model->USERNAME => $member->username,
                              $this->CI->member_model->PASSWORD => $member->password,
                              $this->CI->member_model->NAME => $member->name,
                              $this->CI->member_model->SEX => $member->sex,
                              $this->CI->member_model->RANK => $member->rank,
                              $this->CI->member_model->BIRTHDAY => $member->birthday,
                              $this->CI->member_model->IC_NUMBER => $member->ic_number,
                              $this->CI->member_model->PHONE => $member->phone,
                              $this->CI->member_model->TEL => $member->tel,
                              $this->CI->member_model->ADDRESS => $member->address,
                              $this->CI->member_model->EMAIL => $member->email,
                              $this->CI->member_model->UNIT_ID => $member->unit_id,
                              $this->CI->member_model->CLASS_ID => $member->class_id);
        return $member_array;
    }
    
    public function __get($name) 
    {
        if (defined('self::'.$name))
        {
            return constant('self::'.$name);
        }
        return parent::__get($name);
    }
    
}

/* End of file */