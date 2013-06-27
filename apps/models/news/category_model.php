<?php
require_once APPPATH.'models/news/category.php';

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
// End of file