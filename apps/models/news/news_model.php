<?php

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

/**
 * News
 *
 * 呈現公告紀錄的資料，定提供公告的新增、更新與刪除功能
 *
 */
class News {
    // 公告主鍵值
    private $id;
    // 公告分類
    private $category;
    // 公告發佈時間
    private $publish_time;
    // 公告修改時間
    private $edit_time;
    // 公告發佈者
    private $author;
    // 公告標題
    private $title;
    // 公告內容
    private $content;
    // 公告附件
    private $files = array();
    
    private $CI;
    
    public function __construct()
    {
        $this->CI = & get_instance();
        $this->CI->load->database();
        $this->CI->load->model('news/author_model');
        $this->CI->load->model('news/category_model');
        $this->CI->load->model('news/file_model');
    }
    
    /**
     * 更新或新增此實體的資料至資料庫
     *
     * edit_time或publish_time設為NULL時，會自動將edit_time或publish_time設為目前
     * 時間。
     *
     * @access public
     * @return boolean 更新或新增成功則回傳TRUE，否則回傳FALSE
     */
    public function save()
    {
        // 儲存關聯
        if (!$this->category->save()) {
            return FALSE;
        }
        // 儲存公告
        $data = array('id' => $this->id,
                      'publish_time' => $this->publish_time,
                      'edit_time' => $this->edit_time,
                      'title' => $this->title,
                      'content' => $this->content,
                      'category_id' => $this->category->id,
                      'author_id' => $this->author->id);
        if (is_null($this->id)) {
            $this->CI->db->insert('news', $data);
            if (!$this->CI->db->_error_message()) {
                $this->id = $this->CI->db->insert_id();
            } else {
                return FALSE;
            }
        } else {
            $this->CI->db->where('id', $this->id);
            $this->CI->db->update('news', $data);
            if ($this->CI->db->_error_message()) {
                return FALSE;
            }
        }
        // 儲存檔案
        $is_insert_files_success = TRUE;
        foreach ($this->files as $file)
        {
            $file->news = $this;
            if (!$file->save()) {
                $is_insert_files_success = FALSE;
            };
        }
        return $is_insert_files_success;
    }
    
    /**
     * 刪除此實體在資料庫的資料
     *
     * @access public
     * @return boolean 成功從資料庫刪除資料則回傳TRUE，否則回傳FALSE
     */
    public function delete()
    {
        if (!is_null($this->id)) 
        {
            $this->CI->db->where('id', $this->id);
            $this->CI->db->delete();
            if ($this->db->affected_rows()) {
                $this->id = NULL;
                return TRUE;
            } else {
                return FALSE;
            }
        }
        return FALSE;
    }
    
    /**
     * 新增檔案關聯至此實體
     *
     * @access public
     * @param File $file
     */
    public function append_files($file)
    {
        $this->files[] = $file;
    }
    
    /**
     *
     */
    public function append_files_by_id($file_id)
    {
        $files = $this->CI->file_model->get($file_id);
        if (!$files) {
            return FALSE;
        }
        $file = $files[0];
        $this->append_files($file);
        return TRUE;
    }
    
    /**
     * 以發佈者的主鍵值來設定此實體的發佈者
     *
     * @access public
     * @return boolean 設定成功回傳TRUE，否則回傳FALSE
     */
    public function set_author_by_id($author_id)
    {
        $authors = $this->CI->author_model->where('id', $author_id)->get();
        if (!$authors) {
            return FALSE;
        }
        $author = $authors[0];
        $this->author = $author;
        return TRUE;
    }
    
    /**
     * 以分類的主鍵值來設定此實體的分類
     *
     * @access public
     * @return boolean 設定成功回傳TRUE，否則回傳FALSE
     */
    public function set_category_by_id($category_id)
    {
        $categories = $this->CI->category_model->where('id', $category_id)->get();
        if (!$categories) {
            return FALSE;
        }
        $category = $categories[0];
        $this->category = $category;
        return TRUE;
    }
    
    public function __set($name, $value)
    {
        $this->$name = $value;
    }
    
    public function __get($name)
    {
        return $this->$name;
    }
}
// End of file