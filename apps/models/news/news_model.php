<?php
require_once APPPATH.'models/news/news.php';

/**
 * News_model
 *
 * 提供公告的篩選、取得功能
 *
 */
class News_model extends CI_Model {

    public function __construct()
    {
        $this->load->database();
    }
    
    /**
     * 設定篩選資料
     *
     * 可接受的參數如ActionRecord類別的like方法一樣
     * @link http://ellislab.com/codeigniter/user-guide/database/active_record.html#select
     *
     * @access public
     * @method News_model like(string $column_name, mixed $column_value)
     * @method News_model like(array $conditions)
     * @return News_model 回傳此News_model類別實體，可供方法串接使用
     */
    public function like()
    {
        call_user_func_array(array($this->db, 'like'), func_get_args());
        return $this;
    }
    
    /**
     * 設定排序欄位
     *
     * 此方法傳入的參數格式與ActionRecord的order_by方法相同。
     * @link http://ellislab.com/codeigniter/user-guide/database/active_record.html#select
     *
     * @access public
     * @return News_model
     */ 
    public function order_by()
    {
        call_user_func_array(array($this->db, 'order_by'), func_get_args());
        return $this;
    }
    
    /**
     * 設定篩選資料
     *
     * 可接受的參數如ActionRecord類別的where方法一樣
     * @link http://ellislab.com/codeigniter/user-guide/database/active_record.html#select
     *
     * @access public
     * @method News_model where(string $column_name, mixed $column_value)
     * @method News_model where(array $conditions)
     * @return News_model 回傳此News_model類別實體，可供方法串接使用
     */
    public function where()
    {
        call_user_func_array(array($this->db, 'where'), func_get_args());
        return $this;
    }
    
    /**
     * 取得公告資料
     *
     * @access public
     * @return array 回傳包含符合篩選條件公告的News類別實體陣列
     */
    public function get()
    {
        $this->db->from('news');
        $result = $this->db->get()->result();
        $result_news = array();
        foreach ($result as $value)
        {
            $result_news[] = $this->model_to_news($value);
        }
        return $result_news;
    }
    
    /**
     * 創造一個公告的類別實體
     *
     * @access public
     * @return News
     */
    public function create()
    {
        return new News();
    }
    
    /**
     * 將從Model取出的新聞資料轉換成News類別實體
     *
     * @access private
     * @param stdClass $model_data
     * @return News
     */
    private function model_to_news($model_data)
    {
        $news = new News();
        $news->id = $model_data->id;
        $news->publish_time = $model_data->publish_time;
        $news->edit_time = $model_data->edit_time;
        $news->title = $model_data->title;
        $news->content = $model_data->content;
        // 設定分類
        $news->set_category_by_id($model_data->category_id);
        // 設定發佈者
        $news->set_author_by_id($model_data->author_id);
        // 設定檔案
        $files = $this->file_model->where('news_id', $model_data->id)->get();
        foreach ($files as $file)
        {
            $news->append_files_by_id($file->id);
        }
        return $news;
    }
}
// End of file