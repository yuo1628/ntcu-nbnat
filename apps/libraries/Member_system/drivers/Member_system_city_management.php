<?php

/**
 * Member_system_city_management
 *
 * 以使用City類別存放城市單位資料的方式進行城市單位的取得、新增與更新
 */
class Member_system_city_management extends CI_Driver {

	/**
	 * 取得空白的City類別實體
	 *
	 * @access public
	 * @return City
	 */
	public function get_empty_city_instance()
	{
		return new City();
	}
	
	/**
	 * 以傳入的城市編號來尋找並回傳城市資料
	 *
	 * @access public
	 * @param string $id 城市編號
	 * @return City|NULL 如果有找到指定編號的城市，則回傳已填入資料的City類別實體。
	 * 否則回傳NULL。
	 */
	public function get_city_by_id($id)
	{
		
	}
	
	/**
	 * 以傳入的城市名稱來尋找並回傳城市資料
	 *
	 * @access public
	 * @param string $name 城市名稱
	 * @return City|NULL 如果有找到指定名稱的城市，則回傳已填入資料的City類別實體。
	 * 否則回傳NULL。
	 */
	public function get_city_by_name($name)
	{
		
	}
}

/**
 * City
 * 
 * 存放城市的資料
 */
class City {

	// 城市編號
	private $id;
	// 城市名稱
	private $name;
	
	public function __get($name)
	{
		return $this->$name;
	}
	
	public function __set($name, $value)
	{
		$this->$name = $value;
	}
}
/* End of file */