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
	public function findAnswerById($_id) {
		$query = $this -> db -> get_where($this->tablename, array('id' => $_id));
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
	 * Select Last Answer.
	 *
	 * @param Array conditions.
	 * @return Mixed Array or Null.
	 */
	public function findFirstAnswerId($_uid,$_sort="desc") {
		$this->db->limit(1);
		$this->db->order_by("id", $_sort); 
		$query = $this -> db -> get_where($this->tablename, array('nodes_uuid' => $_uid));
		foreach ($query->result() as $row)
		{
    		return $row->id;
		}		
		
	}
	
	/**
	 * count Questions by node's id.
	 *
	 * @param Array conditions.
	 * @return integer.
	 */
	public function countAnswer($_uuid)
	{
		$query = $this -> db -> get_where($this -> tablename, array('nodes_uuid' => $_uuid,"finish"=>"true"));
		return $query -> num_rows();
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


 