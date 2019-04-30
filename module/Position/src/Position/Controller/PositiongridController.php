<?php

namespace Position\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Position\Grid\PositionGrid;
use Position\Grid\SectionGrid;
use Position\Grid\DepartmentGrid;
//use Application\Service\TestService;

class PositiongridController extends AbstractActionController {
	protected $positionTable;
	protected $sectionTable;
	protected $departmentTable;
	protected $dbAdapter;
	protected $positionService;
	
	
	public function gridAction() {
	}
	public function ajaxgridAction() {
		return $this->htmlResponse ( 
				$this->getPositionService ()->positionGrid ( 
						$this->getRequest ()->getPost () ) 
				);
	}
	
	
	
	
	
	
	public function departmentgridAction() {
	}
	public function ajaxdepartmentgridAction() {
		$table = new DepartmentGrid ();
		$table->setAdapter ( $this->getDbAdapter () )->setSource ( $this->getDepartmentTable ()->fetchAll ( $this->getDbAdapter () ) )->setParamAdapter ( $this->getRequest ()->getPost () );
		return $this->htmlResponse ( $table->render () );
	}
	
	
	
	
	
	public function sectiongridAction() {
	}
	public function ajaxsectiongridAction() {
		$table = new SectionGrid ();
		$table->setAdapter ( $this->getDbAdapter () )->setSource ( $this->getSectionTable ()->fetchAll ( $this->getDbAdapter () ) )->setParamAdapter ( $this->getRequest ()->getPost () );
		return $this->htmlResponse ( $table->render () );
	}
	public function htmlResponse($html) {
		$response = $this->getResponse ();
		$response->setStatusCode ( 200 );
		$response->setContent ( $html );
		return $response;
	}
	public function getPositionService() {
		if (! $this->positionService) {
			$sm = $this->getServiceLocator ();
			$this->positionService = $sm->get ( 'positionService' );
		}
		return $this->positionService;
	}
	public function getPositionTable() {
		if (! $this->positionTable) {
			$sm = $this->getServiceLocator ();
			$this->positionTable = $sm->get ( 'Position\Model\PositionTable' );
		}
		return $this->positionTable;
	}
	public function getSectionTable() {
		if (! $this->sectionTable) {
			$sm = $this->getServiceLocator ();
			$this->sectionTable = $sm->get ( 'Position\Model\SectionTable' );
		}
		return $this->sectionTable;
	}
	public function getDepartmentTable() {
		if (! $this->departmentTable) {
			$sm = $this->getServiceLocator ();
			$this->departmentTable = $sm->get ( 'Position\Model\DepartmentTable' );
		}
		return $this->departmentTable;
	}
	public function getDbAdapter() {
		if (! $this->dbAdapter) {
			$sm = $this->getServiceLocator ();
			$this->dbAdapter = $sm->get ( 'sqlServerAdapter' );
		}
		return $this->dbAdapter;
	}
}
