<?php
require_once(realpath(dirname(__FILE__)) . '/../Contract/EntityInterface.php');

/**
 * @access public
 * @author dhayal
 * @package Contract
 */
interface DataMapperInterface {

	/**
	 * @access public
	 * @param id
	 */
	public function fetchById($id);

	/**
	 * @access public
	 * @param array conditions
	 * @ParamType conditions array
	 */
	public function fetchAll(array_17 $conditions = array());

	/**
	 * @access public
	 * @param Contract.EntityInterface entity
	 * @ParamType entity Contract.EntityInterface
	 */
	public function insert(EntityInterface $entity);

	/**
	 * @access public
	 * @param Contract.EntityInterface entity
	 * @ParamType entity Contract.EntityInterface
	 */
	public function update(EntityInterface $entity);

	/**
	 * @access public
	 * @param Contract.EntityInterface entity
	 * @ParamType entity Contract.EntityInterface
	 */
	public function save(EntityInterface $entity);

	/**
	 * @access public
	 * @param Contract.EntityInterface entity
	 * @ParamType entity Contract.EntityInterface
	 */
	public function delete(EntityInterface $entity);
}
?>