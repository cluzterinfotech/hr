<?php
require_once(realpath(dirname(__FILE__)) . '/../Contract/DataMapperInterface.php');
require_once(realpath(dirname(__FILE__)) . '/../Storage/ObjectStorageInterface.php');
require_once(realpath(dirname(__FILE__)) . '/../Contract/EntityInterface.php');
require_once(realpath(dirname(__FILE__)) . '/../Contract/UnitOfWorkInterface.php');

/**
 * @access public
 * @author dhayal
 * @package Model
 */
class UnitOfWork implements UnitOfWorkInterface {
	const STATE_NEW = "NEW";
	const STATE_CLEAN = "CLEAN";
	const STATE_DIRTY = "DIRTY";
	const STATE_REMOVED = "REMOVED";
	private $dataMapper;
	private $storage;

	/**
	 * @access public
	 * @param Contract.DataMapperInterface dataMapper
	 * @param Storage.ObjectStorageInterface storage
	 * @ParamType dataMapper Contract.DataMapperInterface
	 * @ParamType storage Storage.ObjectStorageInterface
	 */
	public function __construct(DataMapperInterface $dataMapper, ObjectStorageInterface $storage) {
		// Not yet implemented
	}

	/**
	 * @access public
	 */
	public function getDataMapper() {
		return $this->dataMapper;
	}

	/**
	 * @access public
	 */
	public function getObjectStorage() {
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
	 * @param Contract.EntityInterface entity
	 * @ParamType entity Contract.EntityInterface
	 */
	public function registerNew(EntityInterface $entity) {
		// Not yet implemented
	}

	/**
	 * @access public
	 * @param Contract.EntityInterface entity
	 * @ParamType entity Contract.EntityInterface
	 */
	public function registerClean(EntityInterface $entity) {
		// Not yet implemented
	}

	/**
	 * @access public
	 * @param Contract.EntityInterface entity
	 * @ParamType entity Contract.EntityInterface
	 */
	public function registerDirty(EntityInterface $entity) {
		// Not yet implemented
	}

	/**
	 * @access public
	 * @param Contract.EntityInterface entity
	 * @ParamType entity Contract.EntityInterface
	 */
	public function registerDeleted(EntityInterface $entity) {
		// Not yet implemented
	}

	/**
	 * @access protected
	 * @param entity
	 * @param state
	 */
	protected function registerEntity($entity, $state = self::STATE_CLEAN) {
		// Not yet implemented
	}

	/**
	 * @access public
	 */
	public function commit() {
		// Not yet implemented
	}

	/**
	 * @access public
	 */
	public function rollback() {
		// Not yet implemented
	}

	/**
	 * @access public
	 */
	public function clear() {
		// Not yet implemented
	}
}
?>