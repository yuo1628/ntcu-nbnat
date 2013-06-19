<?php

class Fileerror {
	const ERROR_SIZE = 1;
	const ERROR_TYPE = 2;
	const ERROR_LOAD = 3;
	
	private $error_code;
	
	public function __construct($error_code)
	{
		$this->error_code = $error_code;
	}
	
	/**
	 * 取得錯誤訊息代碼
	 *
	 * @access public
	 * @return int
	 */
	public function get_error_code()
	{
		return $this->error_code;
	}
	
	/**
	 * 取得錯誤訊息
	 *
	 * @access public
	 * @return string
	 */
	public function get_error_message()
	{
		switch ($this->error_code) {
			case (self::ERROR_SIZE):
				return '檔案大小超過限制範圍';
			case (self::ERROR_TYPE):
				return '檔案類型不符合規定';
			case (self::ERROR_LOAD):
				return '檔案讀取發生錯誤';
			default:
				return '發生不知名錯誤';
		}
	}
	
	public function __get($name)
	{
		if (defined("self::$name")) {
			return constant("self::$name");
		}
	}
}
// End of file