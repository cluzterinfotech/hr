<?php

namespace Position\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Position\Form\DepartmentForm;
use Position\Model\UserInfo;

class DepartmentController extends AbstractActionController {

	protected $departmentTable, $positionTable;
	public function indexAction() {
		//$deptTable = $this->getServiceLocator()->get('departmenttable');
		return new ViewModel ( array (
				'departments' => $this->getDepartmentTable ()->fetchAll () 
		) );
	}
	public function approvalAction() {
		return new ViewModel ( array (
				'departments' => $this->getDepartmentTable ()->getNonApproval () 
		) );
	}
	public function multipleAction() {
		$request = $this->getRequest ();
		if ($request->isPost ()) {
			$multipleId = $request->getPost ( 'multiSelect', 0 );
			$action = $request->getPost ( 'action', 0 );
			if ($action == 'Approve') {
				foreach ( $multipleId as $id ) {
					$department = $this->getDepartmentTable ()->getDepartment ( $id, "history" );
					$this->getDepartmentTable ()->approveDepartment ( $department, 2, new UserInfo ( 'alkhatim' ) );
				}
			} else if ($action == 'Reject') {
				foreach ( $multipleId as $id ) {
					$department = $this->getDepartmentTable ()->getDepartment ( $id, "history" );
					$this->getDepartmentTable ()->approveDepartment ( $department, 4, new UserInfo ( 'alkhatim' ) );
				}
			}
		}
		
		$this->redirect ()->toRoute ( 'department', array (
				'action' => 'approval' 
		));
	}
	public function approveAction() {
		$id = ( int ) $this->params ()->fromRoute ( 'id', 0 );
		if ($id == 0) {
			$this->redirect ()->toRoute ( 'department', array (
					'action' => 'approval' 
			) );
		}
		$department = $this->getDepartmentTable ()->getDepartment ( $id, "history" );
		
		$request = $this->getRequest ();
		if ($request->isPost ()) {
			$app = $request->getPost ( 'approved', 'No' );
			if ($app == 'Yes') {
				echo $this->getDepartmentTable ()->approveDepartment ( $department, 2, new UserInfo ( 'alkhatim' ) );
			}
			$this->redirect ()->toRoute ( 'department', array (
					'action' => 'approval' 
			) );
		}
		
		return new ViewModel ( array (
				'approve' => $department 
		) );
	}
	public function rejectAction() {
		$id = ( int ) $this->params ()->fromRoute ( 'id', 0 );
		if ($id == 0) {
			$this->redirect ()->toRoute ( 'department', array (
					'action' => 'approval' 
			) );
		}
		$department = $this->getDepartmentTable ()->getDepartment ( $id, "history" );
		
		$request = $this->getRequest ();
		if ($request->isPost ()) {
			$app = $request->getPost ( 'cancelled', 'No' );
			if ($app == 'Yes') {
				$this->getDepartmentTable ()->approveDepartment ( $department, 4, new UserInfo ( 'alkhatim' ) );
			}
			$this->redirect ()->toRoute ( 'department', array (
					'action' => 'approval' 
			) );
		}
		
		return new ViewModel ( array (
				'approve' => $department 
		) );
	}
	public function addAction() {
		$addForm = new DepartmentForm ( "addDeptForm" );
		$addForm->get ( 'submit' )->setValue ( 'Save' );
		// fetch last id and increment it.
		$lastId = ( int ) $this->getDepartmentTable ()->getLastInsertedDepartmentId () + 1;
		$addForm->get ( 'department_id' )->setValue ( $lastId );
		// set value options of positions select menu
		$addForm->get ( 'dept_assistant_position_id' )->setValueOptions ( $this->getPositionTable ()->objtoArray () );
		
		$request = $this->getRequest ();
		if ($request->isPost ()) {
			$addForm->setData ( $request->getPost () );
			if ($addForm->isValid ()) {
				$department = $addForm->getData ();
				if ($this->getDepartmentTable ()->saveDepartment ( $department, new UserInfo ( 'alkhatim' ) ) == 1234) {
					$this->redirect ()->toRoute ( 'department', array (
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
			$this->redirect ()->toRoute ( 'department' );
		}
		
		// get the previous route then extract the last Action either Index(null) or Approval
		/*
		 * $prev = $this->getRequest()->getHeader('Referer')->getUri();
		 * $prev = explode("/", $prev);
		 * $lastRoute = $prev[count($prev)-1];
		 *
		 * if($lastRoute != "approval")
		 * $table = "main";
		 * else
		 * $table = "history";
		 */
		
		$department = $this->getDepartmentTable ()->getDepartment ( $id, 'history' );
		$editForm = new DepartmentForm ( "editDeptForm" );
		$editForm->get ( 'submit' )->setValue ( 'Save' );
		// set value options of positions select menu
		$editForm->get ( 'dept_assistant_position_id' )->setValueOptions ( $this->getPositionTable ()->objtoArray () );
		
		$editForm->bind ( $department );
		$request = $this->getRequest ();
		if ($request->isPost ()) {
			$editForm->setData ( $request->getPost () );
			if ($editForm->isValid ()) {
				$department = $editForm->getData ();
				if ($this->getDepartmentTable ()->saveDepartment ( $department, new UserInfo ( 'alkhatim' ) ) == 1234) {
					$this->redirect ()->toRoute ( 'department', array (
							'action' => 'approval' 
					) );
				} else {
					return array (
							'editForm' => $editForm,
							'id' => $department->getDepartmentId (),
							'result' => "Something went wrong." 
					);
				}
			}
		}
		
		return array (
				'editForm' => $editForm,
				'id' => $department->getDepartmentId (),
				'result' => false 
		);
	}
	public function getDepartmentTable() {
		if (! $this->departmentTable) {
			$sm = $this->getServiceLocator ();
			$this->departmentTable = $sm->get('Position\Model\DepartmentTable' );
		}
		return $this->departmentTable;
	}
	public function getPositionTable() {
		if (! $this->positionTable) {
			$sm = $this->getServiceLocator ();
			$this->positionTable = $sm->get ( 'Position\Model\PositionTable' );
		}
		return $this->positionTable;
	}
}