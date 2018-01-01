<?php
/**
 * @access public
 * @author dhayal
 * @package Controller
 */
class IndexController {
	private $positionTable;
	private $resultSet;
	private $customerTable;
	private $dbAdapter;
	private $moduleOptions;
	private $positionService;

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
	 * //return new ViewModel();
	 * $objectManager = $this->getServiceLocator()->get('Doctrine\ORM\EntityManager');
	 * 
	 * $user = new User();
	 * $user->setFullName('test dhayal');
	 * 
	 * $objectManager->persist($user);
	 * $objectManager->flush();
	 * 
	 * //die(var_dump($user->getId()));
	 * @access public
	 */
	public function listAction() {
		// Not yet implemented
	}

	/**
	 * @access public
	 */
	public function sectionAction() {
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
	public function bootstrapAction() {
		// Not yet implemented
	}

	/**
	 * @access public
	 */
	public function ajaxlistAction() {
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

	/**
	 * @access public
	 */
	public function getPositionService() {
		return $this->positionService;
	}
}
?>