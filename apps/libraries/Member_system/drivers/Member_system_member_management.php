<?php
/**
 * Member_system_member_management
 *
 * 以使用Member類別存放會員資料的方式進行會員的取得、新增與更新
 */
class Member_system_member_management extends CI_Driver {

    private $CI;

    public function __construct()
    {
        $this->CI = & get_instance();
        $this->CI->load->model('member_model');
    }

    /**
     * 取得一個空白的Member類別實體
     *
     * @access public
     * @return 一個空白的Member類別實體
     */
    public function get_empty_member_instance()
    {
        return new Member();
    }
    
    /**
     * 取得填入資料的Member類別實體
     *
     * 此方法會從傳入的會員主鍵值來尋找並填入會員的資料。
     * 
     * @access public
     * @param string $id 會員主鍵值
     * @return Member|NULL 如果找不到會員編號為指定值的會員，則會回傳NULL
     */
    public function get_member_by_id($id)
    {
        $memberArray = $this->CI->member_model->get(array($this->CI->member_model->PK => $id));
        // 找不到指定的會員
        if (!$memberArray) {
            return NULL;
        }
        $memberData = $memberArray[0];
        return $this->model_to_member($memberData);
    }
    
    /**
     * 取得填入資料的Member類別實體
     *
     * 此方法會從傳入的會員帳號來尋找並填入會員的資料。
     * 
     * @access public
     * @param string $username 會員帳號
     * @return Member|NULL 如果找不到會員帳號為指定值的會員，則會回傳NULL
     */
    public function get_member_by_username($username)
    {
        $memberArray = $this->CI->member_model->get(array($this->CI->member_model->USERNAME => $username));
        // 找不到指定的會員
        if (!$memberArray) {
            return NULL;
        }
        $memberData = $memberArray[0];
        return $this->model_to_member($memberData);
    }
    
    /**
     * 刪除指定主鍵值的會員
     *
     * @access public
     * @param string $id 會員的主鍵值
     * @return boolean 刪除成功則回傳TRUE，刪除失敗（如找不到指定主鍵的會員）
     * 則回傳FALSE
     */
    public function delete_member_by_id($id)
    {
        $affectedMemberNumber = $this->CI->member_model->delete(array($this->CI->member_model->PK => $id));
        // 無刪除的會員資料筆數，代表找不到指定的會員
        if(!$affectedMemberNumber) {
            return FALSE;
        }
        else {
            return TRUE;
        }
    }
    
    /**
     * 刪除指定帳號的會員
     *
     * @access public
     * @param string $username 會員帳號
     * @return boolean 刪除成功則回傳TRUE，刪除失敗（如找不到指定帳號的會員）
     * 則回傳FALSE
     */
    public function delete_member_by_username($username)
    {
        $affectedMemberNumber = $this->CI->member_model->delete(array($this->CI->member_model->USERNAME => $username));
        // 無刪除的會員資料筆數，代表找不到指定的會員
        if (!$affectedMemberNumber) {
            return FALSE;
        } else {
            return TRUE;
        }
    }
    
    /**
     * 更新或新增會員資料
     *
     * @access public
     * @param Member $member 要更新或新增的使用者資料，如果會員的id有設定，則
     * 此方法會執行更新操作，否則此方法會執行新增操作
     * @return boolean 更新或新增成功則回傳True，否則回傳False
     */
    public function save_member($member)
    {
        $member_data = $this->member_to_array($member);
        if (is_null($member->id)) {
            $this->CI->member_model->insert($member_data);
        }
        else {
            $this->CI->member_model->update($member_data);
        }
    }
}

/** 
 * Member
 * 呈現會員的資料
 */
class Member {
    // 資料庫主鍵值
    private $id;
    // 帳號
    private $username;
    // 密碼
    private $password;
    // 使用者名稱
    private $name;
    // 性別
    private $sex;
    // 使用者層級
    private $rank;
    // 使用者生日
    private $birthday;
    // 身份證號碼
    private $ic_number;
    // 家電話
    private $phone;
    // 手機
    private $tel;
    // 地址
    private $address;
    // email
    private $email;
    // 班級資料庫主鍵值
    private $class_id;
    // 班級學制
    private $class_type;
    // 班級年級
    private $class_grade;
    // 班級
    private $class_name;
    // 學校資料庫主鍵值
    private $school_id;
    // 學校類型
    private $school_type;
    // 學校名稱
    private $school_name;
    // 學校地址
    private $school_address;
    // 學校電話
    private $school_phone;
    // 學校縣市資料庫編號
    private $city_id;
    // 學校縣市
    private $city_name;
    // 服務單位資料庫主鍵值
    private $unit_id;
    // 服務單位名稱;
    private $unit_name;
    
    public function __get($name)
    {
        return $this->$name;
    }
    
    public function __set($name, $value)
    {
        $this->$name = $value;
    }
}
/* End of file */