<?php
/**
 * exam_map_Subject Model
 *
 * @author Shown
 */
class M_Subject extends CI_Model {

	private $tablename = "subject";

	/**
	 * Select all Subject.
	 *
	 * @return Mixed Array or Null.
	 */
	public function allSubject() {

		$query = $this -> db -> get($this -> tablename);
		return $query -> result();
	}

	/**
	 * Select one Subject.
	 *
	 * @param String Subject id.
	 * @return Mixed Array or Null.
	 */
	public function findSubjectById($id) {
		$query = $this -> db -> get_where($this -> tablename, array('id' => $id));
		return $query -> result();
	}

	/**
	 * Select Subject by conditions.
	 *
	 * @param Array conditions.
	 * @return Mixed Array or Null.
	 */
	public function findSubject($conditions) {
		$query = $this -> db -> get_where($this -> tablename, $conditions);
		return $query -> result();
	}
	
	/**
	 * Insert Subject.
	 *
	 * @param Array Subject insert data.
	 * @return Boolean.
	 */
	public function addSubject($data) {
	
		if ($this -> db -> insert($this -> tablename, $data)) {
			return true;
		} else {
			return false;
		}
	}

	/**
	 * Update Subject.
	 *
	 * @param Array Subject update data.
	 * @param Array conditions.
	 * @return Boolean.
	 */
	public function updSubject($data, $condition) {
		if ($this -> db -> update($this -> tablename, $data, $condition)) {
			return true;
		} else {
			return false;
		}
	}

	/**
	 * Delete Subject one data.
	 *
	 * @param Array conditions.
	 * @return Boolean.
	 */
	public function delSubject($condition) {
		if ($this -> db -> delete($this -> tablename, $condition)) {
			return true;
		} else {
			return false;
		}
	}

}
