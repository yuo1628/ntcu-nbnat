<?php
/**
 * exam_map_Km Model
 *
 * @author Shown
 */
class M_Km extends CI_Model {

	private $tablename = "km";

	/**
	 * Select all Km.
	 *
	 * @return Mixed Array or Null.
	 */
	public function allKm() {

		$query = $this -> db -> get($this -> tablename);
		return $query -> result();
	}

	/**
	 * Select one Km.
	 *
	 * @param String Km id.
	 * @return Mixed Array or Null.
	 */
	public function findKmById($id) {
		$query = $this -> db -> get_where($this -> tablename, array('id' => $id));
		return $query -> result();
	}

	/**
	 * Select Km by conditions.
	 *
	 * @param Array conditions.
	 * @return Mixed Array or Null.
	 */
	public function findKm($conditions) 
	{
		$query = $this -> db -> get_where($this -> tablename, $conditions);
		if ($query->num_rows() > 0)
		{
			return $query -> result();
		}		
	}
	
	 /**
     * 取得學制資料
     *
     * @access public     * 
     * @return array
     */
    public function get_kmGroupBy($field) {    	
    	$this->db->select($field);
    	$this->db->group_by($field); 
		$this->db->order_by($field, "asc"); 		
        $query = $this -> db -> get($this -> tablename);
		return $query -> result();      
    } 
	/**
	 * Insert Km.
	 *
	 * @param Array Km insert data.
	 * @return Boolean.
	 */
	public function addKm($data) {
	
		if ($this -> db -> insert($this -> tablename, $data)) {
			return $this -> db -> insert_id();
		} else {
			return false;
		}
	}

	/**
	 * Update Km.
	 *
	 * @param Array Km update data.
	 * @param Array conditions.
	 * @return Boolean.
	 */
	public function updKm($data, $condition) {
		if ($this -> db -> update($this -> tablename, $data, $condition)) {
			return true;
		} else {
			return false;
		}
	}

	/**
	 * Delete Km one data.
	 *
	 * @param Array conditions.
	 * @return Boolean.
	 */
	public function delKm($condition) {
		if ($this -> db -> delete($this -> tablename, $condition)) {
			return true;
		} else {
			return false;
		}
	}

}
