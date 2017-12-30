<?php
require_once(realpath(dirname(__FILE__)) . '/../Entity/SectionEntity.php');
require_once(realpath(dirname(__FILE__)) . '/../Contract/SectionMapperInterface.php');

/**
 * @access public
 * @author dhayal
 * @package Mapper
 */
class SectionDbMapper implements SectionMapperInterface {

	/**
	 * @access public
	 * @param AdapterInterface dbAdapter
	 * @ParamType dbAdapter AdapterInterface
	 */
	public function __construct(AdapterInterface $dbAdapter) {
		// Not yet implemented
	}

	/**
	 * @access public
	 */
	public function findAll() {
		// Not yet implemented
	}

	/**
	 * @access public
	 */
	public function findOne() {
		// Not yet implemented
	}

	/**
	 * @access public
	 */
	public function remove() {
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