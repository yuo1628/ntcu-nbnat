<?php
/**
  * Member_model
  *
  * 提供新增、更新、刪除會員資料的功能。
  *
  * 此類別的方法所傳入的篩選條件都會使用正好相等來篩選資料庫欄位，
  * 如果需要like等其他的篩選方式，可以呼叫此類別的getDb取得ci
  * 的db物件，之後可使用ActiveRecord的方法來調用自訂的篩選。
  *
  * @author yuo1628 <pors37@gmail.com>
  */
class Member_model extends CI_Model {
    // 此model傳遞資料所使用的鍵值
    // 這些值不應該更動
    const CITY_PK = 'city_pk';
    const CITY_NAME = 'city_name';
    
    const SCHOOL_PK = 'school_pk';
    const SCHOOL_TYPE = 'school_type';
    const SCHOOL_NAME = 'school_name';
    const SCHOOL_ADDRESS = 'school_address';
    const SCHOOL_PHONE = 'school_phone';
    const SCHOOL_CITY_ID = 'school_city_id';
    
    const CLASS_PK = 'class_pk';
    const CLASS_TYPE = 'class_type';
    const CLASS_GRADE = 'class_grade';
    const CLASS_NAME = 'class_name';
    const CLASS_SCHOOL_ID = 'class_school_id';
    
    const UNIT_PK = 'unit_pk';
    const UNIT_NAME = 'unit_name';
    
    const PK = 'id';
    const USERNAME = 'username';
    const PASSWORD = 'password';
    const NAME = 'name';
    const SEX = 'sex';
    const RANK = 'rank';
    const BIRTHDAY = 'birthday';
    const IC_NUMBER = 'ic_number';
    const PHONE = 'phone';
    const TEL = 'tel';
    const ADDRESS = 'address';
    const EMAIL = 'email';
    const CREATED_TIME = 'created_time';
    const PASSWORD_EDITED_TIME = 'password_edited_time';
    const UNIT_ID = 'unit_id';
    const CLASS_ID = 'class_id';
    
    public function __construct() {
        parent::__construct();
        $this->load->database();
        $this->load->helper('array');
    }
    
    /**
     * 更新使用者資料
     *
     * 此方法會用指定的使用者主鍵值來找要更新的使用者紀錄。
     * 如果不指定使用者的主鍵值，則會更新所有使用者的資料。
     *
     * @access public
     * @param array $data 參數data為一陣列，內容為要更新的使用者資料，
     * 格式為 columnName => value，columnName可使用此類別定義的常數。
     * @return NULL
     */
    public function update($data) {
        $userData = elements(array($this->PK,
                                   $this->USERNAME,
                                   $this->PASSWORD,
                                   $this->NAME,
                                   $this->SEX,
                                   $this->RANK,
                                   $this->BIRTHDAY,
                                   $this->IC_NUMBER,
                                   $this->PHONE,
                                   $this->TEL,
                                   $this->ADDRESS,
                                   $this->EMAIL,
                                   $this->CREATED_TIME,
                                   $this->PASSWORD_EDITED_TIME,
                                   $this->UNIT_ID,
                                   $this->CLASS_ID),
                            $data, NULL);
        // 取出要特殊處理的資料
        $userPassword = $userData[$this->PASSWORD];
        if (! is_null($userPassword)) {
            $this->db->set('password', "PASSWORD('{$userPassword}')", FALSE);
        }
        unset($userData[$this->PASSWORD]);
        $this->where('id', $userData[$this->PK]);
        unset($userData[$this->PK]);
        
        foreach ($userData as $key => $value) {
            $columnName = $this->to_database_column_name($key);
            $this->set($columnName, $value);
        }
        
        $this->db->update('user');
    }
    
    /**
     * 更新服務單位資料
     *
     * 此方法會用指定的服務單位主鍵值來找要更新的服務單位紀錄。
     * 如果沒有指定服務單位的主鍵值，則會更新所有服務單位的資料。
     *
     * @access public
     * @param array $data 參數data為一陣列，內容為要更新的服務單位資料，
     * 格式為 columnName => value，columnName可使用此類別定義的常數。
     * @return NULL
     */
    public function update_unit($data) {
        $unitData = elements(array($this->UNIT_PK,
                                   $this->UNIT_NAME),
                             $data, NULL);
        $this->where('id', $unitData[$this->UNIT_PK]);
        $this->set('name', $unitData[$this->UNIT_NAME]);
        $this->db->update('unit');
    }

    /**
     * 更新城市資料
     *
     * 此方法會用指定的城市主鍵值來找要更新的城市紀錄。
     * 如果沒有指定城市的主鍵值，則會更新所有的城市資料。
     *
     * @access public
     * @param array $data 參數data為一陣列，內容為要更新的城市資料，
     * 格式為 columnName => value，columnName可使用此類別定義的常數。
     * @return NULL
     */
    public function update_city($data) {
        $cityData = elements(array($this->CITY_PK,
                                   $this->CITY_NAME),
                             $data, NULL);
        $this->where('id', $cityData[$this->CITY_PK]);
        $this->set('name', $cityData[$this->CITY_NAME]);
        $this->db->update('city');
    }
    
    /**
     * 更新學校資料
     *
     * 此方法會用指定的學校主鍵值來找要更新的學校紀錄。
     * 如果沒有指定學校的主鍵值，則會更新所有的學校資料。
     *
     * @access public
     * @param array $data 參數data為一陣列，內容為要更新的學校資料，
     * 格式為 columnName => value，columnName可使用此類別定義的常數。
     * @return NULL
     */
    public function update_school($data) {
        $schoolData = elements(array($this->SCHOOL_PK,
                                     $this->SCHOOL_TYPE,
                                     $this->SCHOOL_NAME,
                                     $this->SCHOOL_ADDRESS,
                                     $this->SCHOOL_PHONE,
                                     $this->SCHOOL_CITY_ID),
                                $data, NULL);
        $this->where('id', $schoolData[$this->SCHOOL_PK]);
        $this->set('type', $schoolData[$this->SCHOOL_TYPE]);
        $this->set('name', $schoolData[$this->SCHOOL_NAME]);
        $this->set('address', $schoolData[$this->SCHOOL_ADDRESS]);
        $this->set('phone', $schoolData[$this->SCHOOL_PHONE]);
        $this->set('city_id', $schoolData[$this->SCHOOL_CITY_ID]);
        $this->db->update('school');
    }
    
    /**
     * 更新班級資料
     * 
     * 此方法會用指定的班級主鍵值來找要更新的班級紀錄。
     * 如果沒有指定班級的主鍵值，則會更新所有的班級資料。
     *
     * @access public
     * @param array $data 參數data為一陣列，內容為要更新的班級資料，
     * 格式為 columnName => value，columnName可使用此類別定義的常數。
     * @return NULL
     */
    public function update_class($data) {
        $classData = elements(array($this->CLASS_PK,
                                    $this->CLASS_TYPE,
                                    $this->CLASS_GRADE,
                                    $this->CLASS_NAME,
                                    $this->CLASS_SCHOOL_ID),
                              $data, NULL);
        $this->where('id', $classData[$this->CLASS_PK]);
        $this->set('type', $classData[$this->CLASS_TYPE]);
        $this->set('grade', $classData[$this->CLASS_GRADE]);
        $this->set('name', $classData[$this->CLASS_NAME]);
        $this->set('school_id', $classData[$this->CLASS_SCHOOL_ID]);
        $this->db->update('class');
    }
    
    /**
     * 插入使用者資料
     * 
     * 此方法會將使用者的密碼以MySQL的PASSWORD函式處理後再儲存至資料庫。
     *
     * @access public
     * @param array $data 參數data為一陣列，內容為要插入的使用者資料，
     * 格式為 columnName => value，columnName可使用此類別定義的常數。
     * @return NULL
     */
    public function insert($data) {
        $userData = elements(array($this->USERNAME,
                                   $this->PASSWORD,
                                   $this->NAME,
                                   $this->SEX,
                                   $this->RANK,
                                   $this->BIRTHDAY,
                                   $this->IC_NUMBER,
                                   $this->PHONE,
                                   $this->TEL,
                                   $this->ADDRESS,
                                   $this->CREATED_TIME,
                                   $this->PASSWORD_EDITED_TIME,
                                   $this->CLASS_ID),
                            $data, NULL);
        // 取出要特殊處理的資料
        $userPassword = $userData[$this->PASSWORD];
        unset($userData[$this->PASSWORD]);

        $this->db->set('password', "PASSWORD('{$userPassword}')", FALSE);
        $this->db->insert('user', $userData);
    }
    
    /**
     * 插入服務單位資料
     * 
     * @access public
     * @param array $data 參數data為一陣列，內容為要插入的服務單位資料，
     * 格式為 columnName => value，columnName可使用此類別定義的常數。
     * @return NULL
     */
    public function insert_unit($data) {
        $unitData = elements(array($this->UNIT_PK,
                                   $this->UNIT_NAME),
                             $data, NULL);
        $this->set('id', $unitData[$this->UNIT_PK]);
        $this->set('name', $unitData[$this->UNIT_NAME]);
        $this->db->insert('unit');
        return $this->db->insert_id();
    }

    /**
     * 插入城市資料
     *
     * @access public
     * @param array $data 參數data為一陣列，內容為要插入的城市資料，
     * 格式為 columnName => value，columnName可使用此類別定義的常數。
     * @return NULL
     */
    public function insert_city($data) {

        $cityData = elements(array($this->CITY_NAME),
                             $data, NULL);

       // $this->set('id', $cityData[$this->CITY_PK]);
        $this->set('name', $cityData[$this->CITY_NAME]);
        $this->db->insert('city');
		return $this->db->insert_id();
    }
    
    /**
     * 插入學校資料
     *
     * @access public
     * @param array $data 參數data為一陣列，內容為要插入的學校資料，
     * 格式為 columnName => value，columnName可使用此類別定義的常數。
     * @return NULL
     */
    public function insert_school($data) {
        $schoolData = elements(array($this->SCHOOL_PK,
                                     $this->SCHOOL_TYPE,
                                     $this->SCHOOL_NAME,
                                     $this->SCHOOL_ADDRESS,
                                     $this->SCHOOL_PHONE,
                                     $this->SCHOOL_CITY_ID),
                                $data, NULL);
        $this->set('id', $schoolData[$this->SCHOOL_PK]);
        $this->set('type', $schoolData[$this->SCHOOL_TYPE]);
        $this->set('name', $schoolData[$this->SCHOOL_NAME]);
        $this->set('address', $schoolData[$this->SCHOOL_ADDRESS]);
        $this->set('phone', $schoolData[$this->SCHOOL_PHONE]);
        $this->set('city_id', $schoolData[$this->SCHOOL_CITY_ID]);
        $this->db->insert('school');
		return $this->db->insert_id();
    }
    
    /**
     * 插入班級資料
     *
     * @access public
     * @param array $data 參數data為一陣列，內容為要插入的班級資料，
     * 格式為 columnName => value，columnName可使用此類別定義的常數。
     * @return NULL
     */
    public function insert_class($data) {
        $classData = elements(array($this->CLASS_PK,
                                    $this->CLASS_TYPE,
                                    $this->CLASS_GRADE,
                                    $this->CLASS_NAME,
                                    $this->CLASS_SCHOOL_ID),
                              $data, NULL);
        $this->set('id', $classData[$this->CLASS_PK]);
        $this->set('type', $classData[$this->CLASS_TYPE]);
        $this->set('grade', $classData[$this->CLASS_GRADE]);
        $this->set('name', $classData[$this->CLASS_NAME]);
        $this->set('school_id', $classData[$this->CLASS_SCHOOL_ID]);

        $this->db->insert('class');
        return $this->db->insert_id();
    }
    
    /**
     * 取得縣市資料
     *
     * @access public
     * @param array $data 參數data為一陣列，可放入要篩選的值進入陣列中
     * 格式為 columnName => value，columnName可使用此類別定義的常數。
     * @return array
     */
    public function get_city($data) {
        $cityData = elements(array($this->CITY_PK, $this->CITY_NAME), $data, NULL);
		
        $this->db->from('city');
        // 篩選
        foreach ($cityData as $key => $value) {
            $this->where($this->to_database_column_name($key), $value);
        }
		$this->db->order_by("name desc");
        return $this->db->get()->result();
    }
    /**
     * 取得學校資料
     *
     * @access public
     * @param array $data 參數data為一陣列，可放入要篩選的值進入陣列中
     * 格式為 columnName => value，columnName可使用此類別定義的常數。
     * @return array
     */
    public function get_school($data) {
        $schoolData = elements(array($this->SCHOOL_PK,
                                    $this->SCHOOL_TYPE,
                                    $this->SCHOOL_NAME,
                                    $this->SCHOOL_ADDRESS,
                                    $this->SCHOOL_PHONE,
                                    $this->SCHOOL_CITY_ID),
                              $data, NULL);
        $this->db->from('school');
        // 篩選
        foreach ($schoolData as $key => $value) {
            $this->where($this->to_database_column_name($key), $value);
        }
        return $this->db->get()->result();
    }    
	
	 /**
     * 取得學校類型資料
     *
     * @access public     * 
     * @return array
     */
    public function get_schoolType() {
    	
    	$this->db->select('type');
    	$this->db->group_by("type"); 		
        $query = $this -> db -> get("school");
		return $query -> result();      
    }    
	 	 
    /**
     * 取得班級資料
     *
     * @access public
     * @param array $data 參數data為一陣列，可放入要篩選的值進入陣列中
     * 格式為 columnName => value，columnName可使用此類別定義的常數。
     * @return array
     */
    public function get_class($data) {
        $classData = elements(array($this->CLASS_PK,
                                    $this->CLASS_TYPE,
                                    $this->CLASS_GRADE,
                                    $this->CLASS_NAME,
                                    $this->CLASS_SCHOOL_ID),
                              $data, NULL);
        // 篩選資料
        $this->db->from('class');
        foreach ($classData as $key => $value) {
            $this->where($this->to_database_column_name($key), $value);
        }
		$this->where('id !=','0');
       
        return $this->db->get()->result();
    }
	
	 /**
     * 取得學制資料
     *
     * @access public     * 
     * @return array
     */
    public function get_classGroupBy($field) {    	
    	$this->db->select($field);
    	$this->db->group_by($field); 		
        $query = $this -> db -> get("class");
		return $query -> result();      
    } 
    
    /**
     * 取得服務單位資料
     *
     * @access public
     * @param array $data 參數data為一陣列，可放入要篩選的值進入陣列中
     * 格式為 columnName => value，columnName可使用此類別定義的常數。
     * @return array
     */
    public function get_unit($data) {
        $unitData = elements(array($this->UNIT_PK,
                                   $this->UNIT_NAME),
                             $data, NULL);
        $this->db->from('unit');
        $this->where('id', $unitData[$this->UNIT_PK]);
        $this->where('name', $unitData[$this->UNIT_NAME]);
        return $this->db->get()->result();
    }
    
    /**
     * 取得會員資料
     *
     * @access public
     * @param array $data 參數data為一陣列，可放入要篩選的值進入陣列中
     * 格式為 columnName => value，columnName可使用此類別定義的常數。
     * @return array
     */
    public function get($data) {
        $userData = elements(array($this->PK,
                                   $this->USERNAME,
                                   $this->PASSWORD,
                                   $this->NAME,
                                   $this->SEX,
                                   $this->RANK,
                                   $this->BIRTHDAY,
                                   $this->IC_NUMBER,
                                   $this->PHONE,
                                   $this->TEL,
                                   $this->ADDRESS,
                                   $this->EMAIL,
                                   $this->CREATED_TIME,
                                   $this->PASSWORD_EDITED_TIME,
                                   $this->UNIT_ID,
                                   $this->CLASS_ID),
                             $data, NULL);
        // 篩選
        $this->db->from('user');
        // 挑出需特殊處理的欄位
        $userPassword = $userData[$this->PASSWORD];
        unset($userData[$this->PASSWORD]);
        if ( ! is_null($userPassword)) {
            $this->db->where('password', "PASSWORD('$userPassword')", FALSE);
        }
        foreach ($userData as $key => $value) {
            $this->where($this->to_database_column_name($key), $value);
        }
        return $this->db->get()->result();
    }
    
    /**
     * 刪除縣市資料
     *
     * 使用此方法時如果未傳入要篩選的值，則會刪除所有的縣市資料。
     *
     * @access public
     * @param array $data 參數data為一陣列，可放入要篩選的值進入陣列中
     * 格式為 columnName => value，columnName可使用此類別定義的常數。
     * @return int 表示刪除的資料筆數
     */
    public function delete_city($data) {
        $cityData = elements(array($this->CITY_PK, $this->CITY_NAME), $data, NULL);
        $this->db->from('city');
        foreach ($cityData as $key => $value) {
            $this->where($this->to_database_column_name($key), $value);
        }
        $this->db->delete();
        return $this->db->affected_rows();
    }
    
    /**
     * 刪除學校資料
     *
     * 使用此方法時如果未傳入要篩選的值，則會刪除所有的學校資料。
     *
     * @access public
     * @param array $data 參數data為一陣列，可放入要篩選的值進入陣列中
     * 格式為 columnName => value，columnName可使用此類別定義的常數。
     * @return int 表示刪除的資料筆數
     */
    public function delete_school($data) {
        $schoolData = elements(array($this->SCHOOL_PK,
                                    $this->SCHOOL_TYPE,
                                    $this->SCHOOL_NAME,
                                    $this->SCHOOL_ADDRESS,
                                    $this->SCHOOL_PHONE,
                                    $this->SCHOOL_CITY_ID),
                              $data, NULL);
        $this->db->from('school');
        foreach ($data as $key => $value) {
            $this->where($this->to_database_column_name($key), $value);
        }
        $this->db->delete();
        return $this->db->affected_rows();
    }
    
    /**
     * 刪除班級資料
     *
     * 使用此方法時如果未傳入要篩選的值，則會刪除所有的班級資料。
     *
     * @access public
     * @param array $data 參數data為一陣列，可放入要篩選的值進入陣列中
     * 格式為 columnName => value，columnName可使用此類別定義的常數。
     * @return int 表示刪除的資料筆數
     */
    public function delete_class($data) {
        $classData = elements(array($this->CLASS_PK,
                                    $this->CLASS_TYPE,
                                    $this->CLASS_GRADE,
                                    $this->CLASS_NAME,
                                    $this->CLASS_SCHOOL_ID),
                              $data, NULL);
        // 篩選資料
        $this->db->from('class');
        foreach ($classData as $key => $value) {
            $this->where($this->to_database_column_name($key), $value);
        }
        $this->db->delete();
        return $this->db->affected_rows();
    }
    
    /**
     * 刪除服務單位資料
     *
     * 使用此方法時如果未傳入要篩選的值，則會刪除所有的服務單位資料。
     *
     * @access public
     * @param array $data 參數data為一陣列，可放入要篩選的值進入陣列中
     * 格式為 columnName => value，columnName可使用此類別定義的常數。
     * @return int 表示刪除的資料筆數
     */
    public function delete_unit($data) {
        $unitData = elements(array($this->UNIT_PK,
                                   $this->UNIT_NAME),
                             $data, NULL);
        $this->db->from('unit');
        foreach ($unitData as $key => $value) {
            $this->where($this->to_database_column_name($key), $value);
        }
        $this->db->delete();
        return $this->db->affected_rows();
    }
    
    /**
     * 刪除會員資料
     *
     * 如果使用此方法時未傳入要篩選的資料，則會刪除所有的會員資料。
     *
     * @access public
     * @param array $data 參數data為一陣列，可放入要篩選的值進入陣列中
     * 格式為 columnName => value，columnName可使用此類別定義的常數。
     * @return int 表示刪除的資料筆數
     */
    public function delete($data) {
        $userData = elements(array($this->PK,
                                   $this->USERNAME,
                                   $this->PASSWORD,
                                   $this->NAME,
                                   $this->SEX,
                                   $this->RANK,
                                   $this->BIRTHDAY,
                                   $this->IC_NUMBER,
                                   $this->PHONE,
                                   $this->TEL,
                                   $this->ADDRESS,
                                   $this->EMAIL,
                                   $this->CREATED_TIME,
                                   $this->PASSWORD_EDITED_TIME,
                                   $this->UNIT_ID,
                                   $this->CLASS_ID),
                             $data, NULL);
        // 篩選
        $this->db->from('user');
        // 取出需特殊處理的篩選資料
        $userPassword = $userData[$this->PASSWORD];
        if (!is_null($userPassword)) {
            $this->db->where($this->to_database_column_name($this->PASSWORD), "PASSWORD('$userPassword')", FALSE);
        }
        unset($userData[$this->PASSWORD]);
        
        // 設定每個需篩選的資料
        foreach ($userData as $key => $value) {
            $this->where($this->to_database_column_name($key), $value);
        }
        
        $this->db->delete();
        return $this->db->affected_rows();
    }
    
    /**
     * 對目前db的資料庫語句做 where 篩選
     *
     * 如果data為NULL，則不做篩選
     *
     * @access protected
     * @param string $columnName 資料表中的欄位名稱
     * @param mixed $data 指定的資料表欄位要儲存的資料，如果值為NULL，則不做篩選
     * @return NULL
     */
    protected function where($columnName, $data) {
        if ( ! is_null($data)) {
            $this->db->where($columnName, $data);
        }
    }
    
    /**
     * 對目前db的資料庫語句做 like 篩選
     *
     * 如果data為NULL，則不做篩選
     *
     * @access protected
     * @param string $columnName 資料表中的欄位名稱
     * @param mixed $data 指定的資料表欄位要儲存的資料，如果值為NULL，則不做篩選
     * @return NULL
     */
    protected function like($columnName, $data) {
        if ( ! is_null($data) ) {
            $this->db->like($columnName, $data);
        }
    }
    
    /**
     * 設定更新或插入資料的欄位值
     *
     * 參數ignoreNull如果設為True，則可以在參數data為NULL時不做設定欄位值的操作
     *
     * @access protected
     * @param string $columnName 資料表中的欄位名稱
     * @param mixed $data 指定的資料表欄位要儲存的資料，如果值為NULL，則不做篩選
     * @param boolean $ignoreNull 如果值設為TRUE，則在$data為NULL時不做任何操作，
     * 如果為FALSE，則在$data為任意值時都會做設定欄位值的操作
     * @return NULL
     */
    protected function set($columnName, $data, $ignoreNull=True) {
        if ( !is_null($data) || ! $ignoreNull) {
            $this->db->set($columnName, $data);
        }
    }
    
    /**
     * 可指定欄位來排序排序資料
     *
     * @access public
     * @param string $columnConst 要排序的欄位，名稱使用此類別定義的欄位名稱常數
     * @param string $direction 欄位的排序方式，可指定'asc'表示遞增或'desc'表示遞減
     * @return NULL
     */
    public function orderby($columnConst, $direction) {
        $columnName = $this->to_database_column_name($columnConst);
        $this->db->order_by($columnName, $direction);
    }
    
    /**
     * 將此類別定義的欄位值轉換成資料庫欄位名稱
     * 如果找不到對應的欄位名稱時，則回傳NULL
     *
     * @access public
     * @param string $columnConst 此類別定義的欄位名稱常數
     * @return NULL
     */
    public function to_database_column_name($columnConst) {
        switch ($columnConst) {
            case $this->PK:
            case $this->CLASS_PK:
            case $this->SCHOOL_PK:
            case $this->UNIT_PK:
            case $this->CITY_PK:
                return 'id';
            case $this->NAME:
            case $this->CITY_NAME:
            case $this->SCHOOL_NAME:
            case $this->CLASS_NAME:
            case $this->UNIT_NAME:
                return 'name';
            case $this->SCHOOL_TYPE:
            case $this->CLASS_TYPE:
                return 'type';
            case $this->PHONE:
            case $this->SCHOOL_PHONE:
                return 'phone';
            case $this->SCHOOL_ADDRESS:
            case $this->ADDRESS:
                return 'address';
            case $this->SCHOOL_CITY_ID:
                return 'city_id';
            case $this->CLASS_GRADE:
                return 'grade';
            case $this->CLASS_SCHOOL_ID:
                return 'school_id';
            case $this->USERNAME:
                return 'username';
            case $this->PASSWORD:
                return 'password';
            case $this->SEX:
                return 'sex';
            case $this->RANK:
                return 'rank';
            case $this->BIRTHDAY:
                return 'birthday';
            case $this->IC_NUMBER:
                return 'ic_number';
            case $this->TEL:
                return 'tel';
            case $this->EMAIL:
                return 'email';
            case $this->CREATED_TIME:
                return 'created_time';
            case $this->PASSWORD_EDITED_TIME:
                return 'password_edited_time';
            case $this->UNIT_ID:
                return 'unit_id';
            case $this->CLASS_ID:
                return 'class_id';
                
        }
    }
    
    /**
     * 取得可操作會員系統資料庫的db物件
     *
     * 使用db物件做任何的篩選動作會影響到接下來的取得、更新和刪除動作。
     * 最好在需要特殊的條件篩選時才使用此方法。
     *
     * @access public
     * @return db
     */
    public function getDb() {
        return $this->db;
    }
    
    
    public function __get($name) {
        // 是否為常數的名稱
        if (defined('self::'.$name)) {
            return constant('self::'.$name);
        }
        return parent::__get($name);
    }
}
/* End of File */