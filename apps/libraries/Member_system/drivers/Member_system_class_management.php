<?php

/**
 * Member_system_class_management
 *
 * 以使用Member_class類別儲存服務單位資料的方式進行服務單位的取得、新增與更新
 */
class Member_system_class_management extends CI_Driver {

	/**
	 * 取得空白的Member_class類別實體
	 *
	 * @access public
	 * @return Member_class
	 */
	public function get_empty_class_instance()
	{
		return new Member_class();
	}
	
	/**
	 * 以班級編號來尋找並取得班級資料
	 *
	 * @access public
	 * @param string $id 班級編號
	 * @return Member_class 班級編號為指定編號的班級資料
	 */
	public function get_class_by_id($id)
	{
		
	}
	
	/**
	 * 新增或更新傳入的班級資料
	 *
	 * @access public
	 * @param Member_class $member_class 要新增或更新的班級資料
	 * @return boolean 新增或更新成功則回傳TRUE，否則回傳FALSE
	 */
	public function save_class($member_class)
	{
		
	}
}

/**
 * MemberClass
 *
 * 存放班級的資料。
 * class為保留字，所以類別名稱改為Member_class
 */
class Member_class {
	// 班級編號
	private $id;
	// 班級學制
	private $type;
	// 班級年級
	private $grade;
	// 班級名稱
	private $name;
}
/* End of file */