<?php

/**
 * Member_system_school_management
 *
 * 以使用School類別存放學校單位資料的方式進行學校單位的取得、新增與更新
 */
class Member_system_school_management extends CI_Driver {
    
    private $CI;
    
    public function __construct()
    {
        $this->CI = & get_instance();
        $this->CI->load->model('member_model');
    }
    
    /**
     * 取得空白的School類別實體
     *
     * @access public
     * @return School
     */
    public function get_empty_school_instance()
    {
        return new School();
    }
    
    /**
     * 以學校編號來尋找並取得學校資料
     *
     * @access public
     * @param string $id 學校編號
     * @return School|NULL 如果有找到學校編號為指定編號的學校，則回傳School類別實體。
     * 否則回傳NULL。
     */
    public function get_school_by_id($id)
    {
        $schoolModelDataArray = $this->CI->member_model->get_school(array($this->CI->member_model->SCHOOL_PK => $id));
        if (!$schoolModelDataArray) {
            return NULL;
        }
        $schoolModelData = $schoolModelDataArray[0];
        $schoolData = $this->model_to_school($schoolModelData);
        return $schoolData;
    }
    
    /**
     * 刪除指定主鍵值的學校資料
     *
     * @access public
     * @param string $id 學校的主鍵值
     * @return boolean 資料刪除成功則回傳TRUE，否則回傳FALSE
     */
    public function delete_school_by_id($id) 
    {
        $affectedSchoolNumber = $this->CI->member_model->delete_school(array($this->CI->member_model->SCHOOL_PK => $id));
        if (!$affectedSchoolNumber) {
            return FALSE;
        } else {
            return TRUE;
        }
    }
    
    /**
     * 新增或更新傳入的學校資料
     *
     * @access public
     * @param School $school 要新增或更新的學校資料，如果有設定學校的主鍵值，則此方法
     * 會進行更新操作，否則則進行新增操作
     * @return boolean 更新或新增成功則回傳TRUE，否則回傳FALSE
     */
    public function save_school($school)
    {
        $schoolDataArray = $this->school_to_array($school);
        if (is_null($school->id)) {
            $this->CI->member_model->insert_school($schoolDataArray);
        } else {
            $this->CI->member_model->update_school($schoolDataArray);
        }
    }
}
/**
 * School
 *
 * 存放學校資料的類別
 */
class School {
    // 學校編號
    private $id;
    // 學校類型
    private $type;
    // 學校名稱
    private $name;
    // 學校地址
    private $address;
    // 學校電話
    private $phone;
    // 學校的縣市編號
    private $city_id;
    // 學校的縣市名稱
    private $city_name;
    
    public function __set($name, $value)
    {
        $this->$name = $value;
    }
    
    public function __get($name)
    {
        return $this->$name;
    }
}
/* End of file */