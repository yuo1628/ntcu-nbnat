<?php

class Member_system_member extends CI_Driver {

    // 取得一個空白的Member類別實體
    public function getEmptyMemberInstance() {
        return new Member();
    }
    
}

// 會員類別
// 呈現會員的資料
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
    // 學校資料庫編號
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
    
    public function __get($name) {
        return $this->$name;
    }
    
    public function __set($name, $value) {
        $this->$name = $value;
    }
}
?>