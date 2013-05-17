<?php

/**
 * Member_system_school_management
 *
 * 以使用School類別存放學校單位資料的方式進行學校單位的取得、新增與更新
 */
class Member_system_school_management extends CI_Driver {
	
	/**
	 * 取得空白的School類別實體
	 *
	 * @access public
	 * @return School
	 */
	public function get_empty_school_instance()
	{
		return new School();
	}
	
	/**
	 * 以學校編號來尋找並取得學校資料
	 *
	 * @access public
	 * @param string $id 學校編號
	 * @return School|NULL 如果有找到學校編號為指定編號的學校，則回傳School類別實體。
	 * 否則回傳NULL。
	 */
	public function get_school_by_id($id)
	{
		
	}
	
	/**
	 * 新增或更新傳入的學校資料
	 *
	 * @access public
	 * @param School $school 要新增或更新的學校資料
	 * @return boolean 更新或新增成功則回傳TRUE，否則回傳FALSE
	 */
	public function save_school($school)
	{
		
	}
}
/**
 * School
 *
 * 存放學校資料的類別
 */
class School {
	// 學校編號
	private $id;
	// 學校類型
	private $type;
	// 學校名稱
	private $name;
	// 學校地址
	private $address;
	// 學校電話
	private $phone;
}
/* End of file */