<?php
require_once(realpath(dirname(__FILE__)) . '/../Storage/ObjectStorageInterface.php');

/**
 * @access public
 * @author dhayal
 * @package Storage
 */
class ObjectStorage implements ObjectStorageInterface {

	/**
	 * @access public
	 */
	public function clear() {
		// Not yet implemented
	}

	/**
	 * @access public
	 * @param object
	 * @param data
	 */
	public function attach($object, $data = null) {
		// Not yet implemented
	}

	/**
	 * @access public
	 * @param object
	 */
	public function detach($object) {
		// Not yet implemented
	}
}
?>