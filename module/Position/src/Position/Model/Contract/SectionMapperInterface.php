<?php
require_once(realpath(dirname(__FILE__)) . '/../Entity/SectionEntity.php');

/**
 * @access public
 * @author dhayal
 * @package Contract
 */
interface SectionMapperInterface {

	/**
	 * @access public
	 * @param sectionId
	 */
	public function findOne($sectionId);

	/**
	 * @access public
	 */
	public function findAll();

	/**
	 * @access public
	 * @param Entity.SectionEntity sectionEntity
	 * @ParamType sectionEntity Entity.SectionEntity
	 */
	public function save(SectionEntity $sectionEntity);

	/**
	 * @access public
	 * @param sectionId
	 */
	public function remove($sectionId);
}
?>