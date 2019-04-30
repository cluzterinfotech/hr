<?php
/**
 * @access public
 * @author dhayal
 * @package Contract
 */
interface EntityInterface {

	/**
	 * @access public
	 * @param name
	 * @param value
	 */
	public function setField($name, $value);

	/**
	 * @access public
	 * @param name
	 */
	public function getField($name);

	/**
	 * @access public
	 * @param name
	 */
	public function fieldExists($name);

	/**
	 * @access public
	 * @param name
	 */
	public function removeField($name);

	/**
	 * @access public
	 */
	public function toArray();
}
?>