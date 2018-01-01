<?php
/*
namespace Application\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
//use Application\Entity\User;
use Application\Model\PositionGrid;
use Zend\Form\Annotation\AnnotationBuilder;
use Application\Entity\Position;

class SectionController extends AbstractActionController {
	protected $positionTable;
	protected $resultSet;
	protected $customerTable;
	protected $dbAdapter;
	protected $moduleOptions;
	public function form($position) {
		$builder = new AnnotationBuilder ();
		return $builder->createForm ( $position );
	}
	public function indexAction() {
	}
	public function listAction() {
	}
	public function changesAction() {
	}
	public function addAction() {
		$student = new Student ();
		$builder = new AnnotationBuilder ();
		$form = $builder->createForm ( $student );
		
		$request = $this->getRequest ();
		if ($request->isPost ()) {
			$form->bind ( $student );
			$form->setData ( $request->getPost () );
			if ($form->isValid ()) {
				print_r ( $form->getData () );
			}
		}
		
		return array (
				'form' => $form 
		);
	}
	public function htmlResponse($html) {
		$response = $this->getResponse ();
		$response->setStatusCode ( 200 );
		$response->setContent ( $html );
		return $response;
	}
	public function getDbAdapter() {
		if (! $this->dbAdapter) {
			$sm = $this->getServiceLocator ();
			$this->dbAdapter = $sm->get ( 'zfdb_adapter' );
		}
		return $this->dbAdapter;
	}
	public function getPositionTable() {
		if (! $this->positionTable) {
			$sm = $this->getServiceLocator ();
			$this->positionTable = $sm->get ( 'Position\Model\PositionTable' );
		}
		return $this->positionTable;
	}
	public function getSource() {
		return $this->getPositionTable ()->fetchAll ( $this->getDbAdapter () );
	}
}*/
