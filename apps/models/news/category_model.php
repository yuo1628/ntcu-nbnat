<?php
/**
 * Category_model
 *
 * 提供分類的篩選與取得功能
 *
 * @author yuo1628 <pors37@gmail.com>
 */
class Category_model extends CI_Model {

    public function __construct()
    {
        $this->load->database();
    }
    
    /**
     * 設定篩選資料
     *
     * 可接受的參數如ActionRecord類別的where方法一樣
     * @link http://ellislab.com/codeigniter/user-guide/database/active_record.html#select
     *
     * @access public
     * @method Category_model where(string $column_name, mixed $column_value)
     * @method Category_model where(array $conditions)
     * @return Category_model 回傳此Category_model類別實體，可供方法串接使用
     */
    public function where()
    {
        call_user_func_array(array($this->db, 'where'), func_get_args());
        return $this;
    }
    
    /**
     * 取得分類資料
     *
     * 如果有設定篩選條件，此方法會取出符合條件的分類資料。
     *
     * @access public
     * @return array 回傳包含符合篩選條件分類的Category類別實體
     */
    public function get()
    {
        $this->db->from('category');
        $result = $this->db->get()->result();
        $result_categories = array();
        foreach ($result as $value)
        {
            $result_categories[] = $this->model_to_category($value);
        }
        return $result_categories;
    }
    
    /**
     * 創造一個Category類別實體
     *
     * 創造出的類別實體並無存入資料庫，需呼叫實體的save方法來
     * 存入資料庫。
     *
     * @access public
     * @return Category
     */
    public function create()
    {
        return new Category();
    }
    
    /**
     * 將從Model取出的分類資料轉換為Category類別實體
     *
     * @access public
     * @param stdClass $model_data
     * @return Category
     */
    public function model_to_category($model_data)
    {
        $category = new Category();
        $category->id = $model_data->id;
        $category->name = $model_data->name;
        return $category;
    }
}

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