<?php

/**
 * File_model
 *
 * 提供檔案記錄的篩選與取得功能
 *
 * @author yuo1628 <pors37@gmail.com>
 */
class File_model extends CI_Model {

    public function __construct()
    {
        $this->load->database();
        $this->load->model('news/news_model');
    }
    
    /**
     * 設定篩選資料
     *
     * 可傳入的參數與ActionRecord的where方法參數一致。
     * @link http://ellislab.com/codeigniter/user-guide/database/active_record.html#select
     *
     * @access public
     * @return File_model 回傳自身，可供串接篩選條件方法使用
     */
    public function where()
    {
        call_user_func_array(array($this->db, 'where'), func_get_args());
        return $this;
    }
    
    /**
     * 取得檔案紀錄
     *
     * 如果執行此方法前已做篩選動作，則會取出符合篩選題鍵
     * 的檔案。
     *
     * @access public
     * @return array 包含符合篩選條件檔案的File類別實體的陣列
     */
    public function get()
    {
        $this->db->from('file');
        $result = $this->db->get()->result();
        $result_files = array();
        foreach ($result as $value)
        {
            $result_files[] = $this->model_to_file($value);
        }
        return $result_files;
    }
    
    /**
     * 取得一個空白的File類別實體
     *
     * File類別實體的save方法可將資料新增至資料庫。
     *
     * @access public
     * @return File
     */
    public function create()
    {
        return new File();
    }
    
    /**
     * 將從Model中取得的檔案紀錄轉換成File類別實體
     *
     * @access private
     * @param stdClass $model_data
     * @return File
     */
    private function model_to_file($model_data)
    {
        $file = new File();
        $file->id = $model_data->id;
        $file->name = $model_data->name;
        $file->path = $model_data->path;
        $file->news_id = $model_data->news_id;
        return $file;
    }
}

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