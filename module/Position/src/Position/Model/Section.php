<?php
require_once(realpath(dirname(__FILE__)) . '/Abstraction/AbstractEntity.php');

/**
 * @access public
 * @author dhayal
 */
class Section extends AbstractEntity {
	private $allowedFields = array (
			"id",
			"name",
			"level",
			"sequence",
			"section",
			"reportingPosition",
			"status" 
	);

	/**
	 * @access public
	 * @param id
	 */
	public function setId($id) {
		// Not yet implemented
	}

	/**
	 * @access public
	 * @param name
	 * @return object
	 * 
	 * @ReturnType object
	 */
	public function setName($name) {
		// Not yet implemented
	}

	/**
	 * @access public
	 * @return this
	 * @ReturnType this
	 */
	public function setSectionCode() {
		// Not yet implemented
	}

	/**
	 * @access public
	 * @param name
	 * @param value
	 */
	public function setField($name, $value) {
		// Not yet implemented
	}

	/**
	 * @access public
	 * @param name
	 */
	public function getField($name) {
		// Not yet implemented
	}

	/**
	 * @access public
	 * @param name
	 */
	public function fieldExists($name) {
		// Not yet implemented
	}

	/**
	 * @access public
	 * @param name
	 */
	public function removeField($name) {
		// Not yet implemented
	}

	/**
	 * @access public
	 */
	public function toArray() {
		// Not yet implemented
	}
}
?>