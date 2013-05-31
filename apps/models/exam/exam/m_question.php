<?php
/**
 * exam_exam_Question Model
 *
 * @author Shown
 */
class M_Question extends CI_Model {

	private $tablename = "questions";

	/**
	 * Select all Question.
	 *
	 * @return Mixed Array or Null.
	 */
	public function allQuestion() {

		$query = $this -> db -> get_where($this -> tablename);
		return $query -> result();
	}

	/**
	 * Select Question list of the node.
	 *
	 * @param String node id.
	 * @return Mixed Array or Null.
	 */
	public function findQuestionByNodeId($nodeid) {
		$query = $this -> db -> get_where($this -> tablename, array('nodes_id' => $nodeid));
		return $query -> result();
	}

	/**
	 * Select Question by conditions.
	 *
	 * @param Array conditions.
	 * @return Mixed Array or Null.
	 */
	public function findQuestion($conditions) {
		$query = $this -> db -> get_where($this -> tablename, $conditions);
		return $query -> result();
	}
	
	/**
	 * count Questions by node's id.
	 *
	 * @param Array conditions.
	 * @return integer.
	 */
	public function countQuestion($_id)
	{
		$query = $this -> db -> get_where($this -> tablename, array('nodes_id' => $_id));
		return $query -> num_rows();
	}

	/**
	 * Insert Question.
	 *
	 * @param Array Question insert data.
	 * @return Boolean.
	 */
	public function addQuestion($data) {

		if ($this -> db -> insert($this -> tablename, $data)) {
			return $this -> db -> insert_id();
		} else {
			return false;
		}
	}

	/**
	 * Update Question.
	 *
	 * @param Array Question update data.
	 * @param Array conditions.
	 * @return Boolean.
	 */
	public function updQuestion($data, $condition) {
		if ($this -> db -> update($this -> tablename, $data, $condition)) {
			return true;
		} else {
			return false;
		}
	}

	/**
	 * Delete Question one data.
	 *
	 * @param Array conditions.
	 * @return Boolean.
	 */
	public function delQuestion($condition) {
		if ($this -> db -> delete($this -> tablename, $condition)) {
			return true;
		} else {
			return false;
		}
	}

}
