<?php
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
        $this->CI->load->model('files/file_model');
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
        foreach ($this->files as $file)
        {
            if (!$file->save()) {
                return FALSE;
            };
			// 儲存公告與檔案的關聯
			$relationData = array('news_id' => $this->id,
								  'file_id' => $file->id);
			$this->CI->db->insert('news_has_file', $relationData);
			if ($this->CI->db->_error_message()) {
				return FALSE;
			}
        }
        return TRUE;
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
            $this->CI->db->delete('news');
            if ($this->CI->db->affected_rows()) {
                $this->id = NULL;
                return TRUE;
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
     * 新增檔案關聯至此實體
	 *
	 * @access public
	 * @param string $file_id 檔案的主鍵值
	 * @return boolean
     */
    public function append_files_by_id($file_id)
    {
        $files = $this->CI->file_model->where('id', $file_id)->get();
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