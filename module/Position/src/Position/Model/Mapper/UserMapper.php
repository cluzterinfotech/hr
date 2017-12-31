<?php
require_once(realpath(dirname(__FILE__)) . '/../Contract/EntityInterface.php');
require_once(realpath(dirname(__FILE__)) . '/../Abstraction/AbstractDataMapper.php');
require_once(realpath(dirname(__FILE__)) . '/../AbstractDataMapper.php');

/**
 * @access public
 * @author dhayal
 * @package Mapper
 */
class UserMapper extends AbstractDataMapper {
	private $entityTable = "users";

	/**
	 * @access protected
	 * @param array row
	 * @ParamType row array
	 */
	protected function loadEntity(array_25 $row) {
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