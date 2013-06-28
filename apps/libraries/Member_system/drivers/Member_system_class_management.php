<?php

/**
 * Member_system_class_management
 *
 * 以使用Member_class類別儲存服務單位資料的方式進行服務單位的取得、新增與更新
 */
class Member_system_class_management extends CI_Driver {

    private $CI;
    
    public function __construct()
    {
        $this->CI = & get_instance();
        $this->CI->load->model('member_model');
    }
    /**
     * 取得空白的Member_class類別實體
     *
     * @access public
     * @return Member_class
     */
    public function get_empty_class_instance()
    {
        return new Member_class();
    }
    
    /**
     * 以班級編號來尋找並取得班級資料
     *
     * @access public
     * @param string $id 班級編號
     * @return Member_class|NULL 班級編號為指定編號的班級資料，如果無此編號的班級資料，則回傳NULL
     */
    public function get_class_by_id($id)
    {
        $classModelDataArray = $this->CI->member_model->get_class(array($this->CI->member_model->CLASS_PK => $id));
        if (!$classModelDataArray){
            return NULL;
        }
        $classModelData = $classModelDataArray[0];
        $classData = $this->model_to_class($classModelData);
        return $classData;
    }
    
    /**
     * 刪除指定主鍵值的班級資料
     *
     * @access public
     * @param string $id 班級的主鍵值
     * @return boolean 成功刪除資料則回傳TRUE，沒刪除到任何資料則回傳FALSE
     */
    public function delete_class_by_id($id)
    {
        $affectedClassNumber = $this->CI->member_model->delete_class(array($this->CI->member_model->CLASS_PK => $id));
        if ($affectedClassNumber != 0) {
            return TRUE;
        } else {
            return FALSE;
        }
    }
    
    /**
     * 新增或更新傳入的班級資料
     *
     * 如果班級主鍵值有設定（非NULL），則此方法會執行更新操作，否則執行新增操作。
     *
     * @access public
     * @param Member_class $member_class 要新增或更新的班級資料
     * @return boolean 新增或更新成功則回傳TRUE，否則回傳FALSE
     */
    public function save_class($member_class)
    {
        $classModelData = $this->class_to_array($member_class);
        if (is_null($member_class->id)) {
            $this->CI->member_model->insert_class($classModelData);
        } else {
            $this->CI->member_model->update_class($classModelData);
        }
    }
}

/**
 * MemberClass
 *
 * 存放班級的資料。
 * class為保留字，所以類別名稱改為Member_class
 */
class Member_class {
    // 班級編號
    private $id;
    // 班級學制
    private $type;
    // 班級年級
    private $grade;
    // 班級名稱
    private $name;
    // 班級的學校編號
    private $school_id;
    // 班級的學校類型
    private $school_type;
    // 班級的學校地址
    private $school_address;
    // 班級的學校電話
    private $school_phone;
    // 班級的縣市編號
    private $city_id;
    // 班級的縣市名稱
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