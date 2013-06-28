<?php

/**
 * Member_system_city_management
 *
 * 以使用City類別存放城市單位資料的方式進行城市單位的取得、新增與更新
 */
class Member_system_city_management extends CI_Driver {

    private $CI;
    
    public function __construct()
    {
        $this->CI = & get_instance();
        $this->CI->load->model('member_model');
    }
    
    /**
     * 取得空白的City類別實體
     *
     * @access public
     * @return City
     */
    public function get_empty_city_instance()
    {
        return new City();
    }
    
    /**
     * 以傳入的縣市主鍵值來尋找並回傳城市資料
     *
     * @access public
     * @param string $id 縣市的主鍵值
     * @return City|NULL 如果有找到指定編號的縣市，則回傳已填入資料的City類別實體。
     * 否則回傳NULL。
     */
    public function get_city_by_id($id)
    {
        $cityModelDataArray = $this->CI->member_model->get_city(array($this->CI->member_model->CITY_PK => $id));
        // 無縣市資料，代表找不到指定主鍵值的縣市
        if (!$cityModelDataArray) {
            return NULL;
        }
        $cityModelData = $cityModelDataArray[0];
        $cityData = $this->model_to_city($cityModelData);
        return $cityData;
    }
    
    /**
     * 以傳入的城市名稱來尋找並回傳城市資料
     *
     * @access public
     * @param string $name 城市名稱
     * @return City|NULL 如果有找到指定名稱的城市，則回傳已填入資料的City類別實體。
     * 否則回傳NULL。
     */
    public function get_city_by_name($name)
    {
        $cityModelDataArray = $this->CI->member_model->get_city(array($this->CI->member_model->CITY_NAME => $name));
        // 無縣市資料，代表找不到指定主鍵值的縣市
        if (!$cityModelDataArray) {
            return NULL;
        }
        $cityModelData = $cityModelDataArray[0];
        $cityData = $this->model_to_city($cityModelData);
        return $cityData; 
    }
    
    /**
     * 刪除指定主鍵值的縣市資料
     *
     * @access public
     * @param string $id 縣市主鍵值
     * @return boolean 刪除縣市資料成功則回傳TRUE，否則則回傳FALSE
     */
    public function delete_city_by_id($id)
    {
        $affectedCityDataNumber = $this->CI->member_model->delete_city(array($this->CI->member_model->CITY_PK => $id));
        if (!$affectedCityDataNumber) {
            return FALSE;
        } else {
            return TRUE;
        }
    }
    
    /**
     * 刪除指定名稱的縣市資料
     *
     * @access public
     * @param string $name 縣市名稱
     * @return boolean 刪除縣市資料成功則回傳TRUE，否則則回傳FALSE
     */
    public function delete_city_by_name($name)
    {
        $affectedCityDataNumber = $this->CI->member_model->delete_city(array($this->CI->member_model->CITY_NAME => $name));
        if (!$affectedCityDataNumber) {
            return FALSE;
        } else {
            return TRUE;
        }
    }
    
    /*
     * 新增或更新指定的縣市資料
     *
     * @access public
     * @param City $city 要更新或新增的縣市資料，如果有設定主鍵值，則此方法會
     * 進行更新操作，否則此方法會執行新增操作
     * @return NULL
     */
    public function save_city($city)
    {
        $cityDataArray = $this->city_to_array($city);
        if (is_null($city->id)) {
            $this->CI->member_model->insert_city($cityDataArray);
        } else {
            $this->CI->member_model->update_city($cityDataArray);
        }
    }
}

/**
 * City
 * 
 * 存放城市的資料
 */
class City {

    // 城市編號
    private $id;
    // 城市名稱
    private $name;
    
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