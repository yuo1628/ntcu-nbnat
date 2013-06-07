<?php
/**
 * File
 *
 * 呈現檔案的資料，同時負責檔案的更新、新增與刪除操作。
 *
 */
class File {
    // 檔案主鍵值
    private $id;
    // 檔案名稱
    private $name;
    // 檔案路徑
    private $path;
    // 連結檔案的新聞主鍵值
    private $news_id;
    
    private $CI;
    
    public function __construct()
    {
        $this->CI = & get_instance();
        $this->CI->load->database();
    }
    
    /**
     * 新增或更新檔案資料
     *
     * 如果有設定檔案主鍵值，則執行新增操作，否則執行更新操作。
     *
     * @access public
     * @return boolean 新增或更新成功則回傳TRUE，否則回傳FALSE
     */
    public function save()
    {
        // 無設定主鍵值，執行新增操作
        $data = array('id' => $this->id,
                      'name' => $this->name,
                      'path' => $this->path,
                      'news_id' => $this->news_id);
        if (is_null($this->id)) {
            $this->CI->db->insert('file', $data);
            if (!$this->CI->db->_error_message()) {
                $this->id = $this->CI->db->insert_id();
                return TRUE;
            } else {
                return FALSE;
            }
        // 已設定主鍵值，執行更新
        } else {
            $this->CI->db->where('id', $this->id);
            $this->CI->db->update('file', $data);
            if (!$this->CI->db->_error_message()) {
                return TRUE;
            } else {
                return FALSE;
            }
        }
    }
    
    /**
     * 從資料庫中刪除此實體的資料
     *
     * @access public
     * @return boolean 從資料庫成功刪除資料則回傳TRUE，否則回傳FALSE
     */
    public function delete()
    {
        if (!is_null($this->id))
        {
            $this->CI->db->from('file');
            $this->CI->db->where('id', $this->id);
            $this->CI->db->delete();
            if (!$this->CI->db->_error_message()) {
                return TRUE;
            } else {
                return FALSE;
            }
        }
    }
    
    public function __set($name, $value)
    {
        $invisible_variables = array('CI');
        if (!in_array($name, $invisible_variables))
        {
            $this->$name = $value;
        }
    }
    
    public function __get($name)
    {
        return $this->$name;
    }
}
// End of file