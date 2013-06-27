<?php
require_once APPPATH . 'models/files/file.php';


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
        return $file;
    }
}
// End of file