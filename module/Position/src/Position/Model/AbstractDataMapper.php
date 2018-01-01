<?php
require_once(realpath(dirname(__FILE__)) . '/Contract/EntityCollectionInterface.php');
require_once(realpath(dirname(__FILE__)) . '/Contract/EntityInterface.php');
require_once(realpath(dirname(__FILE__)) . '/Contract/DataMapperInterface.php');

/**
 * @access public
 * @author dhayal
 */
abstract class AbstractDataMapper implements DataMapperInterface {
	private $adapter;
	private $collection;
	private $entityTable;
	private $identityMap;
	private $sql;

	/**
	 * @access public
	 * @param zendAdapter adapter
	 * @param Contract.EntityCollectionInterface collection
	 * @param entityTable
	 * @ParamType adapter zendAdapter
	 * @ParamType collection Contract.EntityCollectionInterface
	 */
	public function __construct(zendAdapter $adapter, EntityCollectionInterface $collection, $entityTable = null) {
		// Not yet implemented
	}

	/**
	 * @access public
	 * @param entityTable
	 */
	public function setEntityTable($entityTable) {
		// Not yet implemented
	}

	/**
	 * @access public
	 * @param Contract.EntityInterface entity
	 * @ParamType entity Contract.EntityInterface
	 */
	public function save(EntityInterface $entity) {
		// Not yet implemented
	}

	/**
	 * @access public
	 */
	public function getSql() {
		return $this->sql;
	}

	/**
	 * @access public
	 */
	public function select() {
		// Not yet implemented
	}

	/**
	 * @access public
	 * @param where
	 */
	public function fetch($where) {
		// Not yet implemented
	}

	/**
	 * @access public
	 * @param id
	 */
	public function fetchById($id) {
		// Not yet implemented
	}

	/**
	 * @access public
	 * @param array conditions
	 * @ParamType conditions array
	 */
	public function fetchAll(array_20 $conditions = array()) {
		// Not yet implemented
	}

	/**
	 * @access public
	 * @param Contract.EntityInterface entity
	 * @ParamType entity Contract.EntityInterface
	 */
	public function insert(EntityInterface $entity) {
		// Not yet implemented
	}

	/**
	 * @access public
	 * @param Contract.EntityInterface entity
	 * @ParamType entity Contract.EntityInterface
	 */
	public function update(EntityInterface $entity) {
		// Not yet implemented
	}

	/**
	 * @access public
	 * @param Contract.EntityInterface entity
	 * @ParamType entity Contract.EntityInterface
	 */
	public function delete(EntityInterface $entity) {
		// Not yet implemented
	}

	/**
	 * @access protected
	 * @param results
	 */
	protected function loadEntityCollection($results) {
		// Not yet implemented
	}

	/**
	 * @access protected
	 * @param array row
	 * @ParamType row array
	 */
	protected abstract function loadEntity(array_21 $row);
}
?>