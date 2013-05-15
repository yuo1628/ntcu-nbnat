<?php
if ( ! defined('BASEPATH')) {
    exit('No direct script access allowed');
}

/**
 * Member System
 * @author yuo1628 <pors37@gmail.com>
 */
class Member_system extends CI_Driver_Library {
    // 使用者層級表示
    // 這些值應該不被更動
    const RANK_TEACHER = 'TEACHER';
    const RANK_STUDENT = 'STUDENT';
    const RANK_ADMIN = 'ADMIN';

    /**
     * 初始化類別，並載入子Drivers
     * 
     * @access public
     * @param 不需傳入參數
     */
    public function __construct()
    {
        $this->valid_drivers = array('member_system_authentication');
    }

    /** 確認指定的使用者層級是否可使用
     *
     * @access public
     * @param $rank，可傳入任何值，通常為一個代表使用者層級的字串
     * @return boolean，如果是合法的使用者層級會回傳True，否則回傳False
     */
    public function is_rank_avaiable($rank)
    {
        $ranks = array($this->RANK_TEACHER,
                       $this->RANK_STUDENT,
                       $this->RANK_ADMIN);
        return in_array($rank, $ranks);
    }
    
    /** 取得一個空白的Member類別實體
     *
     * @access public
     * @param 不需傳入參數
     * @return 一個空白的Member類別實體
     */
    public function getEmptyMemberInstance()
    {
        return new Member();
    }
    
    public function __get($name) 
    {
        if (defined('self::'.$name))
        {
            return constant('self::'.$name);
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
// End of file