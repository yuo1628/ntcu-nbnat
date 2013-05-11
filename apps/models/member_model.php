<?php
class Member_model extends CI_Model {
    // 此model傳遞資料所使用的鍵值
    // 這些值不應該更動
    public $CITY_PK = 'city_pk';
    public $CITY_NAME = 'city_name';
    
    public $SCHOOL_PK = 'school_pk';
    public $SCHOOL_TYPE = 'school_type';
    public $SCHOOL_NAME = 'school_name';
    public $SCHOOL_ADDRESS = 'school_address';
    public $SCHOOL_PHONE = 'school_phone';
    public $SCHOOL_CITY_ID = 'school_city_id';
    
    public $CLASS_PK = 'class_pk';
    public $CLASS_TYPE = 'class_type';
    public $CLASS_GRADE = 'class_grae';
    public $CLASS_NAME = 'class_name';
    public $CLASS_SCHOOL_ID = 'class_school_id';
    
	public $UNIT_PK = 'unit_pk';
	public $UNIT_NAME = 'unit_name';
	
    public $PK = 'id';
    public $USERNAME = 'username';
    public $PASSWORD = 'password';
    public $NAME = 'name';
    public $SEX = 'sex';
    public $RANK = 'rank';
    public $BIRTHDAY = 'birthday';
    public $IC_NUMBER = 'ic_number';
    public $PHONE = 'phone';
    public $TEL = 'tel';
    public $ADDRESS = 'address';
    public $EMAIL = 'email';
    public $UNIT_ID = 'unit_id';
    public $CLASS_ID = 'class_id';
    
    public function __construct() {
        parent::__construct();
        $this->load->database();
        $this->load->helper('array');
    }
    
	// 更新使用者資料
	// 必須指定使用者的主鍵值，否則會更新所有使用者的資料
	// 參數data為一陣列，內容為要插入的使用者資料
	// 格式為 columnName => value
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
	
	// 更新服務單位資料
	// 必須指定服務單位的主鍵值，否則會更新所有服務單位的資料
	// 參數data為一陣列，內容為要插入的使用者資料
	// 格式為 columnName => value
	public function update_unit($data) {
		$unitData = elements(array($this->UNIT_PK,
								   $this->UNIT_NAME),
							 $data, NULL);
		$this->where('id', $unitData[$this->UNIT_PK]);
		$this->set('name', $unitData[$this->UNIT_NAME]);
		$this->db->update('unit');
	}

	// 更新城市資料
	// 必須指定城市的主鍵值，否則會更新所有的城市資料
	// 參數data為一陣列，內容為要更新的城市資料
	// 格式為 columnName => value
	public function update_city($data) {
		$cityData = elements(array($this->CITY_PK,
								   $this->CITY_NAME),
							 $data, NULL);
		$this->where('id', $cityData[$this->CITY_PK]);
		$this->set('name', $cityData[$this->CITY_NAME]);
		$this->db->update('city');
	}
	
	// 更新學校資料
	// 必須指定學校的主鍵值，否則會更新所有的學校資料
	// 參數data為一陣列，內容為要更新的學校資料
	// 格式為 columnName => value
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
		$this->set('city_id', $schholData[$this->SCHOOL_CITY_ID]);
		$this->db->update('school');
	}
	
	// 更新班級資料
	// 必須指定班級的主鍵資料，否則會更新所有的班級資料
	// 參數data為一陣列，內容為要更新的班級資料
	// 格式為 columnName => value
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
	
	// 插入使用者資料
	// 參數data為一陣列，內容為要插入的使用者資料
	// 格式為 columnName => value
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
								   $this->EMAIL,
								   $this->UNIT_ID,
								   $this->CLASS_ID),
							$data, NULL);
		// 取出要特殊處理的資料
		$userPassword = $userData[$this->PASSWORD];
		unset($userData[$this->PASSWORD]);
		$this->db->set('password', "PASSWORD('{$userPassword}')", FALSE);
		$this->db->insert('user', $userData);
	}
	
	// 插入服務單位資料
	// 參數data為一陣列，內容為要插入的服務單位資料
	// 格式為 columnName => value
	public function insert_unit($data) {
		$unitData = elements(array($this->UNIT_PK,
								   $this->UNIT_NAME),
							 $data, NULL);
		$this->set('id', $unitData[$this->UNIT_PK]);
		$this->set('name', $unitData[$this->UNIT_NAME]);
		$this->db->insert('unit');
	}

	// 插入城市資料
	// 參數data為一陣列，內容為要插入的城市資料
	// 格式為 columnName => value
	public function insert_city($data) {
		$cityData = elements(array($this->CITY_PK,
								   $this->CITY_NAME),
							 $data, NULL);
		$this->set('id', $cityData[$this->CITY_PK]);
		$this->set('name', $cityData[$this->CITY_NAME]);
		$this->db->insert('city');
	}
	
	// 插入學校資料
	// 參數data為一陣列，內容為要插入的學校資料
	// 格式為 columnName => value
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
	}
	
	// 插入班級資料
	// 參數data為一陣列，內容為要插入的班級資料
	// 格式為 columnName => value
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
		return $this->db->insert('class');
	}
	
    // 取得縣市資料
    // 參數data為一陣列，可放入要篩選的值進入陣列中
    // 格式為 columnName => value
    // return array
    public function get_city($data) {
        $cityData = elements(array($this->CITY_PK, $this->CITY_NAME), $data, NULL);
        $this->db->from('city');
        // 篩選
        foreach ($cityData as $key => $value) {
			$this->where($this->to_database_column_name($key), $value);
		}
		return $this->db->get()->result();
    }
    
    // 取得學校資料
    // 參數data為一陣列，可放入要篩選的值進入陣列中
    // 格式為 columnName => value
    // return array
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
    
    // 取得班級資料
    // 參數data為一陣列，可放入要篩選的值進入陣列中
    // 格式為 columnName => value
    // return array
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
        return $this->db->get()->result();
    }
    
	// 取得服務單位資料
	// 參數data為一陣列，可放入要篩選的值進入陣列中
    // 格式為 columnName => value
    // return array
	public function get_unit($data) {
		$unitData = elements(array($this->UNIT_PK,
								   $this->UNIT_NAME),
							 $data, NULL);
		$this->db->from('unit');
		$this->where('id', $unitData[$this->UNIT_PK]);
		$this->where('name', $unitData[$this->UNIT_NAME]);
		return $this->db->get()->result();
	}
	
    // 取得會員資料
    // 參數data為一陣列，可放入要篩選的值進入陣列中
    // 格式為 columnName => value
    // return array
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
	
	// 刪除縣市資料
    // 參數data為一陣列，可放入要篩選的值進入陣列中
    // 格式為 columnName => value
    public function delete_city($data) {
        $cityData = elements(array($this->CITY_PK, $this->CITY_NAME), $data, NULL);
        $this->db->from('city');
		foreach ($cityData as $key => $value) {
			$this->where($this->to_database_column_name($key), $value);
		}
		$this->db->delete();
    }
    
    // 刪除學校資料
    // 參數data為一陣列，可放入要篩選的值進入陣列中
    // 格式為 columnName => value
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
    }
    
    // 刪除班級資料
    // 參數data為一陣列，可放入要篩選的值進入陣列中
    // 格式為 columnName => value
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
        return $this->db->delete();
    }
    
	// 刪除服務單位資料
	// 參數data為一陣列，可放入要篩選的值進入陣列中
    // 格式為 columnName => value
	public function delete_unit($data) {
		$unitData = elements(array($this->UNIT_PK,
								   $this->UNIT_NAME),
							 $data, NULL);
		$this->db->from('unit');
		foreach ($unitData as $key => $value) {
			$this->where($this->to_database_column_name($key), $value);
		}
		return $this->db->delete();
	}
	
    // 刪除會員資料
    // 參數data為一陣列，可放入要篩選的值進入陣列中
    // 格式為 columnName => value
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
                                   $this->UNIT_ID,
                                   $this->CLASS_ID),
                             $data, NULL);
        // 篩選
        $this->db->from('user');
		// 取出需特殊處理的資料
		$userPassword = $userData[$this->PASSWORD];
		$this->db->where($this->to_database_column_name($this->PASSWORD), "PASSWORD('$userPassword')", FALSE);
		unset($userData[$this->PASSWORD]);
		foreach ($userData as $key => $value) {
			$this->where($this->to_database_column_name($key), $value);
		}
        return $this->db->delete();
    }
	
    // 對目前db的資料庫語句做 where 篩選
    // 如果data為NULL，則不做篩選
    protected function where($columnName, $data) {
        if ( ! is_null($data)) {
            $this->db->where($columnName, $data);
        }
    }
    
    // 對目前db的資料庫語句做 like 篩選
    // 如果data為NULL，則不做篩選
    protected function like($columnName, $data) {
        if ( ! is_null($data) ) {
            $this->db->like($columnName, $data);
        }
    }
	
	// 設定更新或插入資料的欄位值
	// 參數ignoreNull如果設為True，則可以在參數data為NULL時不做設定欄位值的操作
	protected function set($columnName, $data, $ignoreNull=True) {
		if ( !is_null($data) || ! $ignoreNull) {
			$this->db->set($columnName, $data);
		}
	}
	
	// 可指定欄位來排序排序資料
	// 欄位名稱使用此類別設定的變數來指定
	// 參數direction可設定為'asc'或'desc'
	public function orderby($columnConst, $direction) {
		$columnName = $this->to_database_column_name($columnConst);
		$this->db->order_by($columnName, $direction);
	}
	
	// 將此類別定義的欄位值轉換成資料庫欄位名稱
	// 如果找不到對應的欄位名稱時，則回傳NULL
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
			case $this->UNIT_ID:
				return 'unit_id';
			case $this->CLASS_ID:
				return 'class_id';
				
		}
	}
	
	// 取得db
	public function getDb() {
		return $this->db;
	}
}
?>