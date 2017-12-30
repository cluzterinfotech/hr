<?php
require_once(realpath(dirname(__FILE__)) . '/Contract/EntityInterface.php');

/**
 * @access public
 * @author dhayal
 */
abstract class AbstractEntity implements EntityInterface {
	private $fields = array ();
	private $allowedFields = array ();

	/**
	 * @access public
	 * @param array fields
	 * @ParamType fields array
	 */
	public function __construct(array_7 $fields = array()) {
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

	/**
	 * @access public
	 * @param name
	 * @param value
	 */
	public function __set($name, $value) {
		// Not yet implemented
	}

	/**
	 * @access public
	 * @param name
	 */
	public function __get($name) {
		// Not yet implemented
	}

	/**
	 * @access public
	 * @param name
	 */
	public function __isset($name) {
		// Not yet implemented
	}

	/**
	 * @access public
	 * @param name
	 */
	public function __unset($name) {
		// Not yet implemented
	}

	/**
	 * @access protected
	 * @param field
	 */
	protected function checkAllowedFields($field) {
		// Not yet implemented
	}
}
?>