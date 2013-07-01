<?php
/**
 * Category
 *
 * 呈現分類的資料，並提供新增、更新與刪除分類資料的功能。
 *
 */
class Category {
    // 分類主鍵值
    private $id;
    // 分類名稱
    private $name;
    
    private $CI;
    
    public function __construct()
    {
        $this->CI = & get_instance();
        $this->CI->load->database();
    }
    
    /**
     * 儲存或更新此實體的資料至資料庫
     * 
     * 如果主鍵值為NULL，則執行新增操作，否則執行更新操作。
     *
     * @access public
     * @return boolean 儲存或更新成功則回傳TRUE，否則回傳FALSE
     */
    public function save()
    {
        $data = array('id' => $this->id,
                      'name' => $this->name);
        if (is_null($this->id)) {
            $this->CI->db->insert('category', $data);
            if (!$this->CI->db->_error_message()) {
                $this->id = $this->CI->db->insert_id();
                return TRUE;
            } else {
                return FALSE;
            }
        } else {
            $this->CI->db->where('id', $this->id);
            $this->CI->db->update('category', $data);
            if (!$this->CI->db->_error_message()) {
                return TRUE;
            } else {
                return FALSE;
            }
        }
    }
    
    /**
     * 刪除此實體在資料庫的資料
     *
     * 實體資料成功從資料庫刪除時會將實體的主鍵值設為NULL。
     * 
     * @access public
     * @return boolean 成功從資料庫刪除資料回傳TRUE，否則回傳FALSE。
     */
    public function delete()
    {
        if (!is_null($this->id)) {
            $this->CI->db->from('category');
            $this->CI->db->where('id', $this->id);
            $this->CI->db->delete();
            if (!$this->CI->db->_error_message()) {
                $this->id = NULL;
                return TRUE;
            } else {
                return FALSE;
            }
        }
        return FALSE;
    }
    
    public function __get($name)
    {
        return $this->$name;
    }
    
    public function __set($name, $value)
    {
        $invisible_variables = array('CI');
        if (!in_array($name, $invisible_variables))
        {
            $this->$name = $value;
        }
    }
}
// End of file