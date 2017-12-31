<?php
require_once(realpath(dirname(__FILE__)) . '/../Contract/EntityCollectionInterface.php');
require_once(realpath(dirname(__FILE__)) . '/../Contract/DataMapperInterface.php');
require_once(realpath(dirname(__FILE__)) . '/../Contract/EntityInterface.php');
require_once(realpath(dirname(__FILE__)) . '/../Abstraction/AbstractDataMapper.php');
require_once(realpath(dirname(__FILE__)) . '/../AbstractDataMapper.php');

/**
 * @access public
 * @author dhayal
 * @package Mapper
 */
class PositionMapper extends AbstractDataMapper {
	private $entityTable = "Position";

	/**
	 * @access public
	 * @param zendAdapter adapter
	 * @param Contract.EntityCollectionInterface collection
	 * @param Contract.DataMapperInterface sectionMapper
	 * @param entityTable
	 * @ParamType adapter zendAdapter
	 * @ParamType collection Contract.EntityCollectionInterface
	 * @ParamType sectionMapper Contract.DataMapperInterface
	 */
	public function __construct(zendAdapter $adapter, EntityCollectionInterface $collection, DataMapperInterface $sectionMapper, $entityTable = null) {
		// Not yet implemented
	}

	/**
	 * @access protected
	 * @param array row
	 * @ParamType row array
	 */
	protected function loadEntity(array_104 $row) {
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
	public function fetchAll(array_17 $conditions = array()) {
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
	public function save(EntityInterface $entity) {
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
}
?>