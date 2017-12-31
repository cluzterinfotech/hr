<?php
/**
 * @access public
 * @author dhayal
 */
class Class_129 {
	private $id;
	private $departmentName;

	/**
	 * @access public
	 */
	public function getId() {
		return $this->id;
	}

	/**
	 * @access public
	 * @param id
	 * @return void
	 * 
	 * @ReturnType void
	 */
	public function setId($id) {
		$this->id = $id;
	}

	/**
	 * @access public
	 */
	public function getDepartmentName() {
		return $this->departmentName;
	}

	/**
	 * @access public
	 * @param departmentName
	 * @return void
	 * 
	 * @ReturnType void
	 */
	public function setDepartmentName($departmentName) {
		$this->departmentName = $departmentName;
	}
}
?>