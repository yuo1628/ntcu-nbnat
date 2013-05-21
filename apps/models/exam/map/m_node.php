<?php
/**
 * exam_map_Node Model
 *
 * @author Shown
 */
class M_Node extends CI_Model {

	private $tablename= "nodes";	

	/**
	 * Select all Node.
	 *
	 * @return Mixed Array or Null.
	 */
	public function allNode() {

		$query = $this -> db -> get_where($this->tablename,array("level"=>"1"));
		return $query -> result();
	}

	/**
	 * Select one Node.
	 *
	 * @param String Node id.
	 * @return Mixed Array or Null.
	 */
	public function findNodeById($id) {
		$query = $this -> db -> get_where($this->tablename, array('id' => $id));
		return $query -> result();
	}

	/**
	 * Select Node by conditions.
	 *
	 * @param Array conditions.
	 * @return Mixed Array or Null.
	 */
	public function findNode($conditions) {
		$query = $this -> db -> get_where($this->tablename, $conditions);
		return $query -> result();
	}
	
	/**
	 * Select Node it is not linking to anyone.
	 * 
	 * @return Mixed Array or Null.
	 */
	public function findFirstNode($_id) {
		$SqlInfo="SELECT * FROM nodes where parent_node='".$_id."' and first_child = '0' and not exists (Select * from links where nodes.id=links.node_from)";
		$query = $this->db->query($SqlInfo);
	
		return $query -> result();
	}

	/**
	 * Insert Node.
	 *
	 * @param Array Node insert data.
	 * @return Boolean.
	 */
	public function addNode($data) {

		if ($this -> db -> insert($this->tablename, $data)) {
			return $this->db->insert_id();
		} else {
			return false;
		}
	}

	/**
	 * Update Node.
	 *
	 * @param Array Node update data.
	 * @param Array conditions.
	 * @return Boolean.
	 */
	public function updNode($data, $condition) {
		if ($this -> db -> update($this->tablename, $data, $condition)) {
			return true;
		} else {
			return false;
		}
	}

	/**
	 * Delete Node one data.
	 *
	 * @param Array conditions.
	 * @return Boolean.
	 */
	public function delNode($condition) {
		if ($this -> db -> delete($this->tablename, $condition)) {
			return true;
		} else {
			return false;
		}
	}
	
}


 