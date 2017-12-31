<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
namespace Position\Controller;

/*use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Position\Form\SectionForm;
use Position\Model\UserInfo;

class SectionController extends AbstractActionController {
	
	protected $sectionTable, $departmentTable;
	
	public function indexAction() {
		return new ViewModel ( array (
				'sections' => $this->getSectionTable ()->fetchAll () 
		) );
	}
	public function approvalAction() {
		return new ViewModel ( array (
				'sections' => $this->getSectionTable ()->getNonApproval () 
		) );
	}
	public function multipleAction() {
		$request = $this->getRequest ();
		if ($request->isPost ()) {
			$multipleId = $request->getPost ( 'multiSelect', 0 );
			$action = $request->getPost ( 'action', 0 );
			if ($action == 'Approve') {
				foreach ( $multipleId as $id ) {
					$section = $this->getSectionTable ()->getSection ( $id, "history" );
					$this->getSectionTable ()->approveSection ( $section, 2, new UserInfo ( 'alkhatim' ) );
				}
			} else if ($action == 'Reject') {
				foreach ( $multipleId as $id ) {
					$section = $this->getSectionTable ()->getSection ( $id, "history" );
					$this->getSectionTable ()->approveSection ( $section, 4, new UserInfo ( 'alkhatim' ) );
				}
			}
		}
		
		$this->redirect ()->toRoute ( 'section', array (
				'action' => 'approval' 
		) );
	}
	public function approveAction() {
		$id = ( int ) $this->params ()->fromRoute ( 'id', 0 );
		if ($id == 0) {
			$this->redirect ()->toRoute ( 'section', array (
					'action' => 'approval' 
			) );
		}
		$section = $this->getSectionTable ()->getsection ( $id, "history" );
		
		$request = $this->getRequest ();
		if ($request->isPost ()) {
			$app = $request->getPost ( 'approved', 'No' );
			if ($app == 'Yes') {
				$this->getSectionTable ()->approveSection ( $section, 2, new UserInfo ( 'alkhatim' ) );
			}
			$this->redirect ()->toRoute ( 'section', array (
					'action' => 'approval' 
			) );
		}
		
		return new ViewModel ( array (
				'approve' => $section 
		) );
	}
	public function rejectAction() {
		$id = ( int ) $this->params ()->fromRoute ( 'id', 0 );
		if ($id == 0) {
			$this->redirect ()->toRoute ( 'section', array (
					'action' => 'approval' 
			) );
		}
		$section = $this->getSectionTable ()->getSection ( $id, "history" );
		
		$request = $this->getRequest ();
		if ($request->isPost ()) {
			$app = $request->getPost ( 'cancelled', 'No' );
			if ($app == 'Yes') {
				$this->getSectionTable ()->approveSection ( $section, 4, new UserInfo ( 'alkhatim' ) );
			}
			$this->redirect ()->toRoute ( 'section', array (
					'action' => 'approval' 
			) );
		}
		
		return new ViewModel ( array (
				'approve' => $section 
		) );
	}
	public function addAction() {
		$addForm = new SectionForm ( "addSectForm" );
		$addForm->get ( 'submit' )->setValue ( 'Save' );
		// fetch last id and increment it.
		$lastId = ( int ) $this->getSectionTable ()->getLastInsertedSectionId () + 1;
		$addForm->get ( 'section_id' )->setValue ( $lastId );
		// set value options of departments select menu
		$addForm->get ( 'department_id' )->setValueOptions ( $this->getDepartmentTable ()->objtoArray () );
		
		$request = $this->getRequest ();
		if ($request->isPost ()) {
			$addForm->setData ( $request->getPost () );
			if ($addForm->isValid ()) {
				$section = $addForm->getData ();
				if ($this->getSectionTable ()->saveSection ( $section, new UserInfo ( 'alkhatim' ) ) == 1234) {
					$this->redirect ()->toRoute ( 'section', array (
							'action' => 'add' 
					) );
				} else {
					return array (
							'addForm' => $addForm,
							'result' => "Something went wrong." 
					);
				}
			}
		}
		
		return array (
				'addForm' => $addForm,
				'result' => false 
		);
	}
	public function editAction() {
		$id = ( int ) $this->params ()->fromRoute ( 'id', 0 );
		if ($id == 0) {
			$this->redirect ()->toRoute ( 'section' );
		}
		
		$section = $this->getSectionTable ()->getSection ( $id, 'history' );
		$editForm = new SectionForm ( "editSectForm" );
		$editForm->get ( 'submit' )->setValue ( 'Save' );
		// set value options of departments select menu
		$editForm->get ( 'department_id' )->setValueOptions ( $this->getDepartmentTable ()->objtoArray () );
		
		$editForm->bind ( $section );
		$request = $this->getRequest ();
		if ($request->isPost ()) {
			$editForm->setData ( $request->getPost () );
			if ($editForm->isValid ()) {
				$section = $editForm->getData ();
				if ($this->getSectionTable ()->saveSection ( $section, new UserInfo ( 'alkhatim' ) ) == 1234) {
					$this->redirect ()->toRoute ( 'section', array (
							'action' => 'approval' 
					) );
				} else {
					return array (
							'editForm' => $editForm,
							'id' => $section->getSectionId (),
							'result' => "Something went wrong." 
					);
				}
			}
		}
		
		return array (
				'editForm' => $editForm,
				'id' => $section->getSectionId (),
				'result' => false 
		);
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
}*/ 