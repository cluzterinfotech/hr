<?php
/**
 * @access public
 * @author dhayal
 * @package Storage
 */
interface ObjectStorageInterface {

	/**
	 * @access public
	 * @param object
	 * @param data
	 */
	public function attach($object, $data = null);

	/**
	 * @access public
	 * @param object
	 */
	public function detach($object);

	/**
	 * @access public
	 */
	public function clear();
}
?>