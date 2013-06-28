<?php

/**
 * Member_system_unit_management
 *
 * 以使用Unit類別存放服務單位資料的方式進行服務單位的取得、新增與更新
 */
class Member_system_unit_management extends CI_Driver {
    
    private $CI;
    
    public function __construct()
    {
        $this->CI = & get_instance();
        $this->CI->load->model('member_model');
    }
    
    /**
     * 取得全新的Unit類別的類別實體
     *
     * @access public
     * @return Unit
     */
    public function get_empty_unit_instance()
    {
        return new Unit();
    }
    
    /**
     * 以服務單位的主鍵值來尋找並取得服務單位資料
     *
     * @access public
     * @param string $id 服務單位的主鍵值
     * @return Unit|NULL 如果有找到指定主鍵值的服務單位，則回傳填入該服務單位資料的Unit類別實體。
     * 如果未找到，則回傳NULL。
     */
    public function get_unit_by_id($id)
    {
        $unitModelDataArray = $this->CI->member_model->get_unit(array($this->CI->member_model->UNIT_PK => $id));
        if(!$unitModelDataArray) {
            return NULL;
        }
        $unitModelData = $unitModelDataArray[0];
        $unitData = $this->model_to_unit($unitModelData);
        return $unitData;
    }
     
     /**
      * 以服務單位的名稱來尋找並取得服務單位的資料
      *
      * @access public
      * @param string $name 服務單位的名稱
      * @return Unit|NULL 如果有找到指定名稱的服務單位，則回傳填入該服務單位資料的Unit類別實體。
      * 如果未找到，則回傳NULL
      */
    public function get_unit_by_name($name)
    {
        $unitModelDataArray = $this->CI->member_model->get_unit(array($this->CI->member_model->UNIT_NAME => $name));
        if (!$unitModelDataArray) {
            return NULL;
        }
        $unitModelData = $unitModelDataArray[0];
        $unitData = $this->model_to_unit($unitModelData);
        return $unitData;
    }
    
    /**
     * 刪除指定主鍵值的服務單位
     *
     * @access public
     * @param string $id 服務單位的主鍵值
     * @return boolean 如果資料刪除成功，則回傳TRUE，如果沒有任何資料被刪除，則回傳FALSE
     */
    public function delete_unit_by_id($id)
    {
        $affectedUnitNumber = $this->CI->member_model->delete_unit(array($this->CI->member_model->UNIT_PK => $id));
        if ($affectedUnitNumber > 0) {
            return TRUE;
        } else {
            return FALSE;
        }
    }
    
    /**
     * 刪除指定名稱的服務單位
     *
     * @access public
     * @param string $id 服務單位的名稱
     * @return boolean 如果資料刪除成功，則回傳TRUE，如果沒有任何資料被刪除，則回傳FALSE
     */
    public function delete_unit_by_name($name)
    {
        $affectedUnitNumber = $this->CI->member_model->delete_unit(array($this->CI->member_model->UNIT_NAME => $name));
        if ($affectedUnitNumber > 0) {
            return TRUE;
        } else {
            return FALSE;
        }
    }
    
    /**
     * 儲存或更新服務單位資料
     *
     * 如果傳入的Unit類別實體有設定服務單位編號，則此方法會進行更新操作，否則會執行新增資料
     * 動作。
     *
     * @access public
     * @param Unit $unit 要新增或更新的服務單位資料
     * @return boolean 資料新增或更新成功則回傳TRUE，否則回傳FALSE
     */
    public function save_unit($unit)
    {
        $unitModelData = $this->unit_to_array($unit);
        if (is_null($unit->id)) {
            $this->CI->member_model->insert_unit($unitModelData);
        } else {
            $this->CI->member_model->update_unit($unitModelData);
        }
    }
}

/**
 * Unit
 *
 * 存放服務單位的資料
 */
class Unit {

    // 服務單位編號
    private $id;
    // 服務單位名稱
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