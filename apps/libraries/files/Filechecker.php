<?php
require_once APPPATH . 'libraries/files/fileerror.php';

/**
 * Filechecker
 *
 * 提供確認檔案的類型和大小的功能
 *
 * @author Guanyuo <pors37@gmail.com>
 */
class Filechecker {
	private $constraint_max_size;
	private $constraint_min_size = 0;
	private $allow_types;
	
	/**
	 * 設定最大檔案大小限制
	 *
	 * @access public
	 * @param int $size_bytes 最大檔案大小限制，以bytes為單位
	 */
	public function set_file_max_size($size_bytes)
	{
		$this->constraint_max_size = $size_bytes;
	}
	
	/**
	 * 設定最小檔案大小限制
	 *
	 * @access public
	 * @param int @size_bytes 最小檔案大小限制，以bytes為單位
	 */
	public function set_file_min_size($size_bytes)
	{
		$this->constraint_min_size = $size_bytes;
	}
	
	/**
	 * 取得檔案最大大小限制
	 *
	 * @access public
	 * @return int|NULL 檔案最大大小限制，以bytes為單位，如果沒有最大限制，
	 * 則回傳NULL。
	 */
	public function get_file_max_size()
	{
		return $this->contraint_max_size;
	}
	
	/**
	 * 取得檔案最小大小限制
	 *
	 * @access public
	 * @return int|NULL 檔案最大大小限制，以bytes為單位，如果沒有最大限制，
	 * 則回傳NULL。
	 */
	public function get_file_min_size()
	{
		return $this->constraint_min_size;
	}
	
	/**
	 * 新增檔案種類限制
	 *
	 * @access public
	 * @param string $mime_type 要新增的檔案種類限制，使用MimeType格式
	 */
	public function append_allow_type($mime_type)
	{
		if (is_null($this->allow_types)) {
			$this->allow_types = array();
		}
		
		// 以陣列的keys來儲存資料
		$this->allow_types[$mime_type] = NULL;
	}
	
	/**
	 * 移除檔案種類限制
	 *
	 * @access public
	 * @param string $mime_type 要移除的檔案種類限制，使用MimeType格式
	 */
	public function remove_allow_type($mime_type)
	{
		unset($this->allow_types[$mime_type]);
	}
	
	/**
	 * 重設檔案種類限制
	 *
	 * 等於不限制任何檔案種類
	 *
	 * @access public
	 */
	public function reset_allow_types()
	{
		$this->allow_types = NULL;
	}
	
	/**
	 * 取得檔案種類限制
	 *
	 * @access public
	 * @return array|NULL 取得包含所有檔案限制的MimeType訊息的陣列，如果
	 * 沒有任何檔案種類限制，則回傳NULL。
	 */
	public function get_allow_types()
	{
		return array_keys($this->allow_types);
	}
	
	/**
	 * 檢查指定的檔案是否符合限制條件
	 *
	 * @access public
	 * @param string $file_path 指定要檢查的檔案路徑
	 * @return array 包含Fileerror類別實體的陣列，如果檔案符合限制條件，
	 * 則回傳空陣列。
	 */
	public function check_file($file_path)
	{
		$errors = array();
		$filesize = filesize($file_path);
		if ($filesize === FALSE) {
			$errors[] = new Fileerror(Fileerror::ERROR_LOAD);
		}
		// 檢查檔案大小
		if (!is_null($this->constraint_max_size) && 
			$filesize > $this->constraint_max_size ||
			$filesize < $this->constraint_min_size) {
			$errors[] = new Fileerror(Fileerror::ERROR_SIZE);
		}
		
		// 檢查檔案類型
		$finfo = finfo_open(FILEINFO_MIME_TYPE);
		$file_mimetype = finfo_file($finfo, $file_path);
		finfo_close($finfo);
		if ($file_mimetype === FALSE) {
			$errors[] = new Fileerror(Fileerror::ERROR_LOAD);
		} else {
			if (!is_null($this->allow_types) && !in_array($file_mimetype, $this->get_allow_types())) {
				$errors[] = new Fileerror(Fileerror::ERROR_TYPE);
			}
		}
		
		//array_unique($errors);
		return $errors;
	}
}
// End of file