<?php
require_once(realpath(dirname(__FILE__)) . '/../Entity/SectionEntity.php');
require_once(realpath(dirname(__FILE__)) . '/../Contract/SectionMapperInterface.php');

/**
 * @access public
 * @author dhayal
 * @package Mapper
 */
class SectionInMemoryMapper implements SectionMapperInterface {
	private $section = array ();

	/**
	 * @access public
	 */
	public function findAll() {
		// Not yet implemented
	}

	/**
	 * @access public
	 * @param sectionId
	 */
	public function findOne($sectionId) {
		// Not yet implemented
	}

	/**
	 * @access public
	 * @param sectionId
	 */
	public function remove($sectionId) {
		// Not yet implemented
	}

	/**
	 * @access public
	 * @param Entity.SectionEntity sectionEntity
	 * @ParamType sectionEntity Entity.SectionEntity
	 */
	public function save(SectionEntity $sectionEntity) {
		// Not yet implemented
	}
}
?>