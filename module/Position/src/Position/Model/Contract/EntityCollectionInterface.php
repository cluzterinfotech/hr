<?php
require_once(realpath(dirname(__FILE__)) . '/../Contract/EntityInterface.php');

/**
 * @access public
 * @author dhayal
 * @package Contract
 */
interface EntityCollectionInterface {

	/**
	 * @access public
	 * @param Contract.EntityInterface entity
	 * @ParamType entity Contract.EntityInterface
	 */
	public function add(EntityInterface $entity);

	/**
	 * @access public
	 * @param Contract.EntityInterface entity
	 * @ParamType entity Contract.EntityInterface
	 */
	public function remove(EntityInterface $entity);

	/**
	 * @access public
	 * @param key
	 */
	public function get($key);

	/**
	 * @access public
	 * @param key
	 */
	public function exists($key);

	/**
	 * @access public
	 */
	public function clear();

	/**
	 * @access public
	 */
	public function toArray();
}
?>