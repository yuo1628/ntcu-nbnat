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
                                     'member_system_member_management',
                                     'member_system_city_management',
                                     'member_system_school_management',
                                     'member_system_class_management',
                                     'member_system_unit_management',
                                     'member_system_importer',
                                     'member_system_exporter');
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
    
    // Quick Fix
    public function get_empty_member_instance()
    {
        return $this->member_management->get_empty_member_instance();
    }
    
    /**
     * 將Model取得的會員資料轉換為Member類別實體
     *
     * @access public
     * @param stdClass $member_data
     * @return Member|NULL 回傳已填入指定會員資料的Member類別實體，如果
     * 找不到指定的會員，則回傳NULL。
     */
    public function model_to_member($member_data)
    {
        $member = $this->member_management->get_empty_member_instance();
        $memberData = $member_data;

        // 填入使用者資料
        foreach ($memberData as $key => $value) {
            $this->fill_member_user_data($key, $value, $member);
        }
        // 填入服務單位資料
        $key_unit_id = 'unit_id';
        $unitPk = $memberData->$key_unit_id;
		
        $unitData = $this->CI->member_model->get_unit(array($this->CI->member_model->UNIT_PK => $unitPk));
        foreach ($unitData[0] as $key => $value) {
            $this->fill_member_unit_data($key, $value, $member);
        }
        // 填入班級資料
        $key_class_id = 'class_id';
        $classPk = $memberData->$key_class_id;
        $classData = $this->CI->member_model->get_class(array($this->CI->member_model->CLASS_PK => $classPk));
        foreach ($classData[0] as $key => $value) {
            $this->fill_member_class_data($key, $value, $member);
        }
        // 填入學校資料
        $key_school_id = 'school_id';
        $schoolPk = $classData[0]->$key_school_id;
        $schoolData = $this->CI->member_model->get_school(array($this->CI->member_model->SCHOOL_PK => $schoolPk));
        foreach ($classData[0] as $key => $value) {
            $this->fill_member_school_data($key, $value, $member);
        }
        // 填入城市資料
        $key_city_id = 'city_id';
        $cityPk = $schoolData[0]->$key_city_id;
        $cityData = $this->CI->member_model->get_city(array($this->CI->member_model->CITY_PK => $cityPk));
        foreach ($cityData[0] as $key => $value) {
            $this->fill_member_city_data($key, $value, $member);
        }
        return $member;
    }
    
    /**
     * 將從member_model取得的班級資料轉換成Member_class類別實體
     *
     * @access public
     * @param stdClass $class_data
     * @return Member_class 已填入傳入的班級資料的Member_class類別實體
     */
    public function model_to_class($class_data)
    {
        $member_class = $this->class_management->get_empty_class_instance();
        foreach ($class_data as $key => $value) {
            $this->fill_class_class_data($key, $value, $member_class);
        }
        // 填入班級的學校資料
        if (!is_null($member_class->school_id)) {
            $school_data_array = $this->CI->member_model->get_school(
                array($this->CI->member_model->SCHOOL_PK => $member_class->school_id));
            if ($school_data_array) {
                $school_data = $school_data_array[0];
                foreach ($school_data as $key => $value) {
                    $this->fill_class_school_data($key, $value, $member_class);
                }
            }
        }
        // 填入班級的縣市資料
        if (!is_null($member_class->city_id)) {
            $city_data_array = $this->CI->member_model->get_city(
                array($this->CI->member_model->CITY_PK => $member_class->city_id));
            if ($city_data_array) {
                $city_data = $city_data_array[0];
                foreach ($city_data as $key => $value) {
                    $this->fill_class_city_data($key, $value, $member_class);
                }
            }
        }
        return $member_class;
    }
    
    /**
     * 將從member_model取得的縣市資料轉換成City類別實體
     *
     * @access public
     * @param stdClass $city_data
     * @return City 已填入傳入的縣市資料的City類別實體
     */
    public function model_to_city($city_data)
    {
        $city = $this->city_management->get_empty_city_instance();
        foreach ($city_data as $key => $value) {
            $this->fill_city_city_data($key, $value, $city);
        }
        return $city;
    }
    
    /**
     * 將從member_model取得的學校資料轉換成School類別實體
     *
     * @access public
     * @param stdClass $school_data
     * @return School 已填入傳入的學校資料的School類別實體
     */
    public function model_to_school($school_data)
    {
        $school = $this->school_management->get_empty_school_instance();
        foreach ($school_data as $key => $value) {
            $this->fill_school_school_data($key, $value, $school);
        }
        // 填入學校的縣市資料
        if (!is_null($school->city_id)) {
            $cityDataArray = $this->CI->member_model->get_city(array($this->CI->member_model->CITY_PK => $school->city_id));
            // 如果有找到縣市資料，才填入學校縣市資料
            if ($cityDataArray) {
                $cityData = $cityDataArray[0];
                foreach ($cityData as $key => $value) {
                    $this->fill_school_city_data($key, $value, $school);
                }
            }
        }
        return $school;
    }
    
    /**
     * 將從member_model取得的服務單位資料轉換成Unit類別實體
     *
     * @access public
     * @param stdClass $unit_data
     * @return Unit 已填入傳入的服務單位資料的Unit類別實體
     */
    public function model_to_unit($unit_data)
    {
        $unit = $this->unit_management->get_empty_unit_instance();
        foreach ($unit_data as $key => $value) {
            $this->fill_unit_unit_data($key, $value, $unit);
        }
        return $unit;
    }
    
    /**
     * 將服務單位資料填入Unit類別實體
     *
     * @access protected
     * @param string $key 服務單位資料表的欄位名稱
     * @param mixed $value 服務單位資料表的欄位值
     * @param Unit $unit 要被填入資料的Unit類別實體
     * @return boolean 填入資料成功則回傳TRUE，否則回傳FALSE
     */
    protected function fill_unit_unit_data($key, $value, &$unit)
    {
        switch ($key) {
            case 'id':
                $unit->id = $value;
                break;
            case 'name':
                $unit->name = $value;
                break;
            default:
                return FALSE;
        }
        return TRUE;
    }
    
    /**
     * 將班級資料填入Member_class類別實體
     *
     * @access protected
     * @param string $key 班級資料表的欄位名稱
     * @param mixed $value 班級資料表的欄位值
     * @param Member_class $member_class 要被填入資料的Member_class類別實體
     * @return boolean 填入資料成功則回傳TRUE，否則回傳FALSE
     */
    protected function fill_class_class_data($key, $value, &$member_class)
    {
        switch ($key) {
            case 'id':
                $member_class->id = $value;
                break;
            case 'type':
                $member_class->type = $value;
                break;
            case 'grade':
                $member_class->grade = $value;
                break;
            case 'name':
                $member_class->name = $value;
                break;
            case 'school_id':
                $member_class->school_id = $value;
                break;
            default:
                return FALSE;
        }
        return TRUE;
    }
    
    /**
     * 將學校資料填入Member_class類別實體
     *
     * @access protected
     * @param string $key 學校資料表的欄位名稱
     * @param mixed $value 學校資料表的欄位值
     * @param Member_class $member_class 要被填入資料的Member_class類別實體
     * @return boolean 填入資料成功則回傳TRUE，否則回傳FALSE
     */
    protected function fill_class_school_data($key, $value, &$member_class)
    {
        switch ($key) {
            case 'id':
                $member_class->school_id = $value;
                break;
            case 'type':
                $member_class->school_type = $value;
                break;
            case 'name':
                $member_class->school_name = $value;
                break;
            case 'address':
                $member_class->school_address = $value;
                break;
            case 'phone':
                $member_class->school_phone = $value;
                break;
            case 'city_id':
                $member_class->city_id = $value;
                break;
            default:
                return FALSE;
        }
        return TRUE;
    }
    
    /**
     * 將縣市資料填入Member_class類別實體
     *
     * @access protected
     * @param string $key 縣市資料表的欄位名稱
     * @param mixed $value 縣市資料表的欄位值
     * @param Member_class $member_class 要被填入資料的Member_class類別實體
     * @return boolean 填入資料成功則回傳TRUE，否則回傳FALSE
     */
    protected function fill_class_city_data($key, $value, &$member_class)
    {
        switch ($key) {
            case 'id':
                $member_class->city_id = $value;
                break;
            case 'name':
                $member_class->city_name = $value;
                break;
            default:
                return FALSE;
        }
        return TRUE;
    }
    
    /**
     * 將縣市資料填入指定的City類別實體
     *
     * @access protected
     * @param string $key 縣市資料表的欄位名稱
     * @param mixed $value 縣市資料表的欄位值
     * @param City $city 要被填入資料的City類別實體
     * @return boolean 填入資料成功則回傳TRUE，否則回傳FALSE
     */
    protected function fill_city_city_data($key, $value, &$city)
    {
        switch ($key) {
            case 'id':
                $city->id = $value;
                break;
            case 'name':
                $city->name = $value;
                break;
            default:
                return FALSE;
        }
        return TRUE;
    }
    
    /**
     * 將學校資料填入指定的School類別實體
     *
     * @access protected
     * @param string $key 學校資料表的欄位名稱
     * @param mixed $value 學校資料表的欄位值
     * @param School $school 要被填入資料的School類別實體
     * @return boolean 填入資料成功則回傳TRUE，否則回傳FALSE
     */
    protected function fill_school_school_data($key, $value, &$school)
    {
        switch ($key) {
            case 'id':
                $school->id = $value;
                break;
            case 'type':
                $school->type = $value;
                break;
            case 'name':
                $school->name = $value;
                break;
            case 'address':
                $school->address = $value;
                break;
            case 'phone':
                $school->phone = $value;
                break;
            case 'city_id':
                $school->city_id = $value;
                break;
            default:
                return FALSE;
        }
        return TRUE;
    }
    
    /**
     * 將縣市資料填入指定的School類別實體
     *
     * @access protected
     * @param string $key 縣市資料表的欄位名稱
     * @param mixed $value 縣市資料表的欄位值
     * @param School $school 要被填入資料的School類別實體
     * @return boolean 資料填入成功則回傳TRUE，否則回傳FALSE
     */
    public function fill_school_city_data($key, $value, &$school)
    {
        switch ($key) {
            case 'id':
                $school->city_id = $value;
                break;
            case 'name':
                $school->city_name = $value;
                break;
            default:
                return FALSE;
        }
        return TRUE;
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
            case 'created_time':
                $member->created_time = $value;
                break;
            case 'password_edited_time':
                $member->password_edited_time = $value;
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
                              $this->CI->member_model->CREATED_TIME => $member->created_time,
                              $this->CI->member_model->PASSWORD_EDITED_TIME => $member->password_edited_time,
                              $this->CI->member_model->UNIT_ID => $member->unit_id,
                              $this->CI->member_model->CLASS_ID => $member->class_id);
        return $member_array;
    }
    
    /**
     * 將Member_class類別實體轉換成member_model可接受的陣列格式
     *
     * @access public
     * @param Member_class $member_class 要轉換的Member_class類別實體
     * @retrun array 符合member_model的班級資料格式的陣列，key為member_model的常數
     */
    public function class_to_array($member_class)
    {
        $classArray = array($this->CI->member_model->CLASS_PK => $member_class->id,
                            $this->CI->member_model->CLASS_TYPE => $member_class->type,
                            $this->CI->member_model->CLASS_GRADE => $member_class->grade,
                            $this->CI->member_model->CLASS_NAME => $member_class->name,
                            $this->CI->member_model->CLASS_SCHOOL_ID => $member_class->school_id);
        return $classArray;
    }
    
    /**
     * 將School類別實體轉換成member_model可接受的陣列格式
     *
     * @access public
     * @param School $school 要轉換的School類別實體
     * @return array 符合member_model的學校資料格式的陣列，key為member_model的常數
     */
    public function school_to_array($school)
    {
        $schoolArray = array($this->CI->member_model->SCHOOL_PK => $school->id,
                             $this->CI->member_model->SCHOOL_TYPE => $school->type,
                             $this->CI->member_model->SCHOOL_NAME => $school->name,
                             $this->CI->member_model->SCHOOL_ADDRESS => $school->address,
                             $this->CI->member_model->SCHOOL_PHONE => $school->phone,
                             $this->CI->member_model->SCHOOL_CITY_ID => $school->city_id);
        return $schoolArray;
    }
    
    /**
     * 將City類別實體資料轉換成member_model可接受的陣列格式
     *
     * @access public 
     * @param City $city 要轉換的City類別實體
     * @return array 符合member_model的縣市資料格式的陣列，key為member_model的常數
     */
    public function city_to_array($city)
    {
        $cityArray = array($this->CI->member_model->CITY_PK => $city->id,
                           $this->CI->member_model->CITY_NAME => $city->name);
        return $cityArray;
    }
    
    /**
     * 將Unit類別實體資料轉換成member_model可接受的陣列格式
     *
     * @access public
     * @param Unit $unit 要轉換的Unit類別實體
     * @return array 符合member_model的服務單位資料格式的陣列，key為member_model的常數
     */
    public function unit_to_array($unit)
    {
        $unitArray = array($this->CI->member_model->UNIT_PK => $unit->id,
                           $this->CI->member_model->UNIT_NAME => $unit->name);
        return $unitArray;
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