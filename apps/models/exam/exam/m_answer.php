<?php
/**
 * exam_exam_Answer Model
 *
 * @author Shown
 */
class M_Answer extends CI_Model {

	private $tablename= "answer";	

	/**
	 * Select all Answer.
	 *
	 * @return Mixed Array or Null.
	 */
	public function allAnswer() {

		$query = $this -> db -> get_where($this->tablename);
		return $query -> result();
	}

	/**
	 * Select one Answer.
	 *
	 * @param String Answer id.
	 * @return Mixed Array or Null.
	 */
	public function findAnswerByNId($n_id) {
		$query = $this -> db -> get_where($this->tablename, array('nodes_id' => $q_id));
		return $query -> result();
	}

	/**
	 * Select Answer by conditions.
	 *
	 * @param Array conditions.
	 * @return Mixed Array or Null.
	 */
	public function findAnswer($conditions) {
		$query = $this -> db -> get_where($this->tablename, $conditions);
		return $query -> result();
	}
	
	/**
	 * Insert Answer.
	 *
	 * @param Array Answer insert data.
	 * @return Boolean.
	 */
	public function addAnswer($data) {

		if ($this -> db -> insert($this->tablename, $data)) {
			return true;
		} else {
			return false;
		}
	}

	/**
	 * Update Answer.
	 *
	 * @param Array Answer update data.
	 * @param Array conditions.
	 * @return Boolean.
	 */
	public function updAnswer($data, $condition) {
		if ($this -> db -> update($this->tablename, $data, $condition)) {
			return true;
		} else {
			return false;
		}
	}

	/**
	 * Delete Answer one data.
	 *
	 * @param Array conditions.
	 * @return Boolean.
	 */
	public function delAnswer($condition) {
		if ($this -> db -> delete($this->tablename, $condition)) {
			return true;
		} else {
			return false;
		}
	}
	
}


 