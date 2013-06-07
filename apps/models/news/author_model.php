<?php
include APPPATH.'models/news/author.php';

/**
 * Author_model
 *
 * 提供作者資料的篩選與取得
 *
 * @author yuo1628 <pors37@gmail.com>
 */
class Author_model extends CI_Model {

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
     * @method Author_model where(string $column_name, mixed $column_value)
     * @method Author_model where(array $conditions)
     * @return Author_model 回傳此Author_model類別實體，可供方法串接使用
     */
    public function where()
    {
        call_user_func_array(array($this->db, 'where'), func_get_args());
        return $this;
    }
    
    /**
     * 取得作者
     *
     * 如果有指定篩選條件，則會取得所有符合條件的作者
     *
     * @access public
     * @return array 包含符合篩選條件作者的Author類別實體陣列
     */
    public function get()
    {
        $this->db->from('user');
        $result = $this->db->get()->result();
        $result_authors = array();
        foreach ($result as $value)
        {
            $result_authors[] = $this->model_to_author($value);
        }
        return $result_authors;
    }
    
    /**
     * 將從Model取出的資料轉換為Author類別實體
     * 
     * @access private
     * @param stdClass $model_data 從Model取出的作者資料
     * @return Author 存入傳入的Model資料的Author類別實體
     */
    private function model_to_author($model_data)
    {
        $author = new Author();
        $author->id = $model_data->id;
        $author->name = $model_data->name;
        $author->rank = $model_data->rank;
        return $author;
    }
}
// End of file