<?php
require_once(realpath(dirname(__FILE__)) . '/../Contract/EntityInterface.php');

/**
 * @access public
 * @author dhayal
 * @package Contract
 */
interface UnitOfWorkInterface {

	/**
	 * @access public
	 * @param id
	 */
	public function fetchById($id);

	/**
	 * @access public
	 * @param Contract.EntityInterface entity
	 * @ParamType entity Contract.EntityInterface
	 */
	public function registerNew(EntityInterface $entity);

	/**
	 * @access public
	 * @param Contract.EntityInterface entity
	 * @ParamType entity Contract.EntityInterface
	 */
	public function registerClean(EntityInterface $entity);

	/**
	 * @access public
	 * @param Contract.EntityInterface entity
	 * @ParamType entity Contract.EntityInterface
	 */
	public function registerDirty(EntityInterface $entity);

	/**
	 * @access public
	 * @param Contract.EntityInterface entity
	 * @ParamType entity Contract.EntityInterface
	 */
	public function registerDeleted(EntityInterface $entity);

	/**
	 * @access public
	 */
	public function commit();

	/**
	 * @access public
	 */
	public function rollback();

	/**
	 * @access public
	 */
	public function clear();
}
?>