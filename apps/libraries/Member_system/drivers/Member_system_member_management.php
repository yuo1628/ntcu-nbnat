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
     * 此方法會從傳入的會員編號來尋找並填入會員的資料。
     * 
     * @access public
     * @param string $id 會員編號
     * @return Member|NULL 如果找不到會員編號為指定值的會員，則會回傳NULL
     */
    public function get_member_by_id($id)
    {
        return $this->model_to_member(array($this->CI->member_model->PK => $id));
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
        return $this->model_to_member(array($this->member_model->USERNAME => $username));
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