<?php
require_once(realpath(dirname(__FILE__)) . '/../Contract/EntityInterface.php');
require_once(realpath(dirname(__FILE__)) . '/../Contract/EntityCollectionInterface.php');

/**
 * @access public
 * @author dhayal
 * @package Collection
 */
class EntityCollection implements EntityCollectionInterface {
	private $entities = array ();

	/**
	 * @access public
	 * @param array entities
	 * @ParamType entities array
	 */
	public function __construct(array_113 $entities = array()) {
		// Not yet implemented
	}

	/**
	 * @access public
	 * @param Contract.EntityInterface entity
	 * @ParamType entity Contract.EntityInterface
	 */
	public function add(EntityInterface $entity) {
		// Not yet implemented
	}

	/**
	 * @access public
	 * @param Contract.EntityInterface entity
	 * @ParamType entity Contract.EntityInterface
	 */
	public function remove(EntityInterface $entity) {
		// Not yet implemented
	}

	/**
	 * @access public
	 * @param key
	 */
	public function get($key) {
		// Not yet implemented
	}

	/**
	 * @access public
	 * @param key
	 */
	public function exists($key) {
		// Not yet implemented
	}

	/**
	 * @access public
	 */
	public function clear() {
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
	 */
	public function count() {
		// Not yet implemented
	}

	/**
	 * @access public
	 * @param key
	 * @param entity
	 */
	public function offsetSet($key, $entity) {
		// Not yet implemented
	}

	/**
	 * @access public
	 * @param key
	 */
	public function offsetUnset($key) {
		// Not yet implemented
	}

	/**
	 * @access public
	 * @param key
	 */
	public function offsetGet($key) {
		// Not yet implemented
	}

	/**
	 * @access public
	 * @param key
	 */
	public function offsetExists($key) {
		// Not yet implemented
	}

	/**
	 * @access public
	 */
	public function getIterator() {
		// Not yet implemented
	}
}
?>