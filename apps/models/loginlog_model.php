<?php

/**
 * LoginLog_model
 * 
 * 使用者登入紀錄
 *
 * @author Yuo <pors37@gmail.com>
 */
class Loginlog_model extends CI_Model {
	// 與資料庫欄位名稱對應的常數
	public $ID = 'id';
	public $IP = 'ip';
	public $LOGINTIME = 'time';
	public $USER_ID = 'user_id';
	
	public function __construct()
	{
		parent::__construct();
		$this->load->database();
	}
	
	/**
	 * 插入登入紀錄
	 *
     * 如果登入時間設為NULL，則會自動設為現在時間
     *
	 * @access public
	 * @param array $data array('資料欄位名稱', '資料欄位值')
	 */
	public function insert($data)
	{
		$this->db->insert('login_log', $data);
	}
	
	/**
	 * 刪除指定的登入紀錄
	 *
	 * @access public
	 * @param int $id
	 */
	public function delete($id)
	{
		$this->db->where($this->ID, $id);
		$this->db->delete('login_log');
	}
	
	/**
	 * 刪除指定會員的登入資料
	 *
	 * @access public
	 * @param int $memberId
	 */
	public function deleteByMemberId($memberId)
	{
		$this->db->where($this->USER_ID, $memberId);
		$this->db->delete('login_log');
	}
	
	/**
	 * 取得指定會員的上次登入時間
	 *
	 * @access public
	 * @param int $memberId
	 * @return DateTime|NULL
	 */
	public function getLastLoginTime($memberId)
	{
		$this->db->select($this->LOGINTIME);
		$this->db->order_by($this->LOGINTIME, 'desc');
		$this->db->limit(1);
		$query = $this->db->get('login_log');
		if ($query->num_rows() > 0) {
			return $query->row_array()[$this->LOGINTIME];
		}
		return NULL;
	}
	
	/**
	 * 取得指定會員上次登入的IP
	 *
     * 此方法回傳的結果會依照登入時間降冪排序
     *
	 * @access public
	 * @param int $memberId
	 * @return string|NULL
	 */
	public function getLastLoginIp($memberId)
	{
		$this->db->select($this->IP);
		$this->db->order_by($this->LOGINTIME, 'desc');
		$query = $this->db->get('login_log', 1);
		if ($query->num_rows() > 0) {
			return $query->row_array()[$this->IP];
		}
		return NULL;
	}
	
	/**
	 * 取得指定會員的所有登入紀錄
	 *
	 * @access public
	 * @param int $memberId
	 * @return array
	 */
	public function getLoginLog($memberId)
	{
		$this->db->where($this->USER_ID, $memberId);
		return $this->db->get('login_log')->result();
	}
	
	/**
	 * 取得所有會員的登入紀錄
	 *
	 * @access public
	 * @return array
	 */
	public function getAllLoginLog()
	{
		return $this->db->get('login_log')->result();
	}
	
	/**
	 * 取得指定會員的登入次數
	 *
	 * @access public
	 * @param int $memberId
	 * @return int
	 */
	public function getLoginCount($memberId)
	{
		$this->db->where($this->USER_ID, $memberId);
		return $this->db->count_all_results('login_log');
	}
}
// End of file