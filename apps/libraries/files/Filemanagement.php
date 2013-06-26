<?php

/**
 * Filemanagement
 *
 * 負責檔案以及其資料庫的紀錄的新增、修改、刪除和取得
 *
 * @author Guanyuo <pors37@gmail.com>
 */
class Filemanagement {

	// 檔案儲存路徑，相對於index.php存在目錄
	const SAVE_PATH = './media/';
	const URL_PATH = 'media/';
	private $CI;
	
	public function __construct()
	{
		$this->CI = & get_instance();
		$this->CI->load->model('files/file_model');
	}
	
	/**
	 * 儲存指定檔案
	 *
	 * @param string $file_name 檔案名稱（包含副檔名）
	 * @param string $file_source_path 檔案的來源路徑
	 * @return int|boolean 如果儲存成功，則回傳檔案的id，新增失敗則回傳FALSE
	 */
	public function save_file($file_name, $file_source_path)
	{
		// 儲存檔案至儲存目錄
		$uniqFileName = uniqid();
		$fileSavePath = self::SAVE_PATH . $uniqFileName;
		$copyResult = copy($file_source_path, $fileSavePath);
		if ($copyResult === FALSE) {
			return FALSE;
		}
		// 儲存檔案紀錄至資料庫
		$newFile = $this->CI->file_model->create();
		$newFile->name = $file_name;
		$newFile->path = basename($fileSavePath);
		if ($newFile->save() === FALSE) {
			return FALSE;
		}
		return $newFile->id;
	}
	
	/**
	 * 刪除指定的檔案
	 *
	 * @param string $id 檔案的id
	 * @return boolean 刪除成功回傳TRUE，否則回傳FALSE
	 */
	public function delete_file($id)
	{
	    // 取得檔案路徑
	    $file_array = $this->CI->file_model->where('id', $id)->get();
	    if (!$file_array) {
	        return false;
	    }
	    $file = $file_array[0];
	    $filepath = $file->path;
		// 刪除檔案紀錄
		if ($file->delete() === FALSE) {
			return FALSE;
		}
	    // 刪除檔案
        if (unlink($filepath) === FALSE) {
			return FALSE;
		}
		return TRUE;
	}
	
	/**
	 * 取得指定的檔案
	 *
	 * @param string $id 檔案的id
	 * @return array|NULL 回傳陣列的格式為(filename, filepath)，如果
	 * 找不到指定的檔案則回傳NULL。
	 */
	public function get_file($id)
	{
	    // 取得檔案
		$this->CI->file_model->where('id', $id);
		$file_array = $this->CI->file_model->get();
		if (!$file_array) {
			return NULL;
		}
		$file = $file_array[0];
	    // 處理檔案路徑格式
		$filePath = $file->path;
		$filePath = $this->CI->config->item('base_url') . self::URL_PATH . basename($filePath);
	    // 回傳檔案名稱與檔案路徑
		return array($file->name, $filePath);
	}
	
	/**
	 * 重新命名檔案
	 *
	 * @param string $id
	 * @param string $new_file_name
	 * @return boolean 重新命名成功則回傳TRUE，否則回傳FALSE
	 */
	public function rename_file($id, $new_file_name)
	{
		$file = $this->CI->file_model->where('id', $id);
		$file_array = $this->CI->file_model->get();
		if (!$file_array) {
			return FALSE;
		}
		$file = $file_array[0];
		$file->name = $new_file_name;
		return $file->save();
	}
}
// End of file
