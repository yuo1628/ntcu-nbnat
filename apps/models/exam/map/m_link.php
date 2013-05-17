<?php
/**
 * exam_map_Link Model
 *
 * @author Shown
 */
class M_Link extends CI_Model {

	private $tablename= "links";	

	/**
	 * Select all Link.
	 *
	 * @return Mixed Array or Null.
	 */
	public function allLink() {

		$query = $this -> db -> get($this->tablename);
		return $query -> result();
	}

	/**
	 * Select one Link.
	 *
	 * @param String Link id.
	 * @return Mixed Array or Null.
	 */
	public function findLinkById($id) {
		$query = $this -> db -> get_where($this->tablename, array('id' => $id));
		return $query -> result();
	}

	/**
	 * Select Link by conditions.
	 *
	 * @param Array conditions.
	 * @return Mixed Array or Null.
	 */
	public function findLink($conditions) {
		$query = $this -> db -> get_where($this->tablename, $conditions);
		return $query -> result();
	}

	/**
	 * Insert Link.
	 *
	 * @param Array Link insert data.
	 * @return Boolean.
	 */
	public function addLink($data) {

		if ($this -> db -> insert($this->tablename, $data)) {
			return true;
		} else {
			return false;
		}
	}

	/**
	 * Update Link.
	 *
	 * @param Array Link update data.
	 * @param Array conditions.
	 * @return Boolean.
	 */
	public function updLink($data, $condition) {
		if ($this -> db -> update($this->tablename, $data, $condition)) {
			return true;
		} else {
			return false;
		}
	}

	/**
	 * Delete Link one data.
	 *
	 * @param Array conditions.
	 * @return Boolean.
	 */
	public function delLink($condition) {
		if ($this -> db -> delete($this->tablename, $condition)) {
			return true;
		} else {
			return false;
		}
	}

}


 