<?php
/**
 * exam_exam_Option Model
 *
 * @author Shown
 */
class M_Option extends CI_Model {

	private $tablename= "options";	

	/**
	 * Select all Option.
	 *
	 * @return Mixed Array or Null.
	 */
	public function allOption() {

		$query = $this -> db -> get_where($this->tablename);
		return $query -> result();
	}

	/**
	 * Select one Option.
	 *
	 * @param String Option id.
	 * @return Mixed Array or Null.
	 */
	public function findOptionByQId($q_id) {
		$query = $this -> db -> get_where($this->tablename, array('questions_id' => $q_id));
		return $query -> result();
	}

	/**
	 * Select Option by conditions.
	 *
	 * @param Array conditions.
	 * @return Mixed Array or Null.
	 */
	public function findOption($conditions) {
		$query = $this -> db -> get_where($this->tablename, $conditions);
		return $query -> result();
	}
	
	/**
	 * Insert Option.
	 *
	 * @param Array Option insert data.
	 * @return Boolean.
	 */
	public function addOption($data) {

		if ($this -> db -> insert($this->tablename, $data)) {
			return true;
		} else {
			return false;
		}
	}

	/**
	 * Update Option.
	 *
	 * @param Array Option update data.
	 * @param Array conditions.
	 * @return Boolean.
	 */
	public function updOption($data, $condition) {
		if ($this -> db -> update($this->tablename, $data, $condition)) {
			return true;
		} else {
			return false;
		}
	}

	/**
	 * Delete Option one data.
	 *
	 * @param Array conditions.
	 * @return Boolean.
	 */
	public function delOption($condition) {
		if ($this -> db -> delete($this->tablename, $condition)) {
			return true;
		} else {
			return false;
		}
	}
	
}


 