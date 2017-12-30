<?php
/**
 * @access public
 * @author dhayal
 * @package Controller
 */
class SectionController {
	private $positionTable;
	private $resultSet;
	private $customerTable;
	private $dbAdapter;
	private $moduleOptions;

	/**
	 * @access public
	 * @param position
	 */
	public function form($position) {
		// Not yet implemented
	}

	/**
	 * @access public
	 */
	public function indexAction() {
		// Not yet implemented
	}

	/**
	 * @access public
	 */
	public function listAction() {
		// Not yet implemented
	}

	/**
	 * @access public
	 */
	public function changesAction() {
		// Not yet implemented
	}

	/**
	 * @access public
	 */
	public function addAction() {
		// Not yet implemented
	}

	/**
	 * @access public
	 * @param html
	 */
	public function htmlResponse($html) {
		// Not yet implemented
	}

	/**
	 * @access public
	 */
	public function getDbAdapter() {
		return $this->dbAdapter;
	}

	/**
	 * @access public
	 */
	public function getPositionTable() {
		return $this->positionTable;
	}

	/**
	 * @access public
	 */
	public function getSource() {
		// Not yet implemented
	}
}
?>