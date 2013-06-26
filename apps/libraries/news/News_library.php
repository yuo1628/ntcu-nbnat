<?php
if ( ! defined('BASEPATH')) {
	exit('No direct script access allowed');
}

/**
 * News
 *
 * 提供公告的取得功能
 *
 */
class News_library {

	const DESC = 'desc';
	const ASC = 'asc';
	const NEWS_PUBLISH_TIME = 'publish_time';
	const NEWS_EDIT_TIME = 'edit_time';
	
	private $CI;
	
	public function __construct()
	{
		$this->CI = & get_instance();
		$this->CI->load->model('news/news_model');
	}
	
	/**
	 * 取得公告
	 *
	 * @access public
	 * @param int $row_count 取得公告的最大數量，設定為NULL則代表不設定上限
	 * @param int $offset 設定要跳過幾個公告，設定為NULL則代表不跳過任何紀錄，如果$row_count設為NULL，
	 * 此參數則會失去功效
	 * @param string $order_by 設定排序的依據，可設定為News::NEWS_PUBLISH_TIME、News::NEWS_EDIT_TIME
	 * @param string $order 設定排序的順序，可設定為News::DESC或News::ASC
	 * @return array
	 */
	public function get_news($row_count=NULL, $offset=NULL, $order=News_library::DESC, $order_by=News_library::NEWS_PUBLISH_TIME) 
	{
		// row_count 為 LIMIT 必填資料
		if ( ! is_null($row_count))
		{
			if ( ! is_null($offset))
			{
				$this->CI->news_model->limit($row_count, $offset);
			} else
			{
				$this->CI->news_model->limit($row_count);
			}
		}
		$this->CI->news_model->order_by($order_by, $order);
		return $this->CI->news_model->get();
	}
	
	/**
	 * 取得指定編號的公告
	 *
	 * @access public
	 * @param int $id 公告的編號
	 * @return News|NULL
	 */
	public function get_news_by_id($id)
	{
		$this->CI->news_model->limit(1);
		$this->CI->news_model->where('id', $id);
		$result = $this->CI->news_model->get();
		if ($result)
		{
			return $result[0];
		}
	}
	
	/**
	 * 建立一個新的公告
	 *
	 * @access public
	 * @retrun News
	 */
	public function create()
	{
	    return $this->CI->news_model->create();
	}
	
	public function __get($name)
	{
		if (defined("SELF::$name"))
		{
			return constant("SELF::$name");
		}
	}
}
// End of file
