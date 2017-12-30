<?php

/**
 * Description of LevelController
 *
 * @author AlkhatimVip
 */
namespace Position\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Position\Form\LevelForm;
use Position\Model\UserInfo;

class LevelController extends AbstractActionController {
	protected $levelTable;
	public function indexAction() {
		return new ViewModel ( array (
				'levels' => $this->getLevelTable ()->fetchAll () 
		) );
	}
	public function approvalAction() {
		return new ViewModel ( array (
				'levels' => $this->getLevelTable ()->getNonApproval () 
		) );
	}
	public function multipleAction() {
		$request = $this->getRequest ();
		if ($request->isPost ()) {
			$multipleId = $request->getPost ( 'multiSelect', 0 );
			$action = $request->getPost ( 'action', 0 );
			if ($action == 'Approve') {
				foreach ( $multipleId as $id ) {
					$level = $this->getLevelTable ()->getPositionLevel ( $id, "history" );
					$this->getLevelTable ()->approveLevel ( $level, 2, new UserInfo ( 'alkhatim' ) );
				}
			} else if ($action == 'Reject') {
				foreach ( $multipleId as $id ) {
					$level = $this->getLevelTable ()->getPositionLevel ( $id, "history" );
					$this->getLevelTable ()->approveLevel ( $level, 4, new UserInfo ( 'alkhatim' ) );
				}
			}
		}
		
		$this->redirect ()->toRoute ( 'level', array (
				'action' => 'approval' 
		) );
	}
	public function approveAction() {
		$id = ( int ) $this->params ()->fromRoute ( 'id', 0 );
		if ($id == 0) {
			$this->redirect ()->toRoute ( 'level', array (
					'action' => 'approval' 
			) );
		}
		$level = $this->getLevelTable ()->getPositionLevel ( $id, "history" );
		
		$request = $this->getRequest ();
		if ($request->isPost ()) {
			$app = $request->getPost ( 'approved', 'No' );
			if ($app == 'Yes') {
				$this->getLevelTable ()->approveLevel ( $level, 2, new UserInfo ( 'alkhatim' ) );
			}
			$this->redirect ()->toRoute ( 'level', array (
					'action' => 'approval' 
			) );
		}
		
		return new ViewModel ( array (
				'approve' => $level 
		) );
	}
	public function rejectAction() {
		$id = ( int ) $this->params ()->fromRoute ( 'id', 0 );
		if ($id == 0) {
			$this->redirect ()->toRoute ( 'level', array (
					'action' => 'approval' 
			) );
		}
		$level = $this->getLevelTable ()->getPositionLevel ( $id, "history" );
		
		$request = $this->getRequest ();
		if ($request->isPost ()) {
			$app = $request->getPost ( 'cancelled', 'No' );
			if ($app == 'Yes') {
				$this->getLevelTable ()->approveLevel ( $level, 4, new UserInfo ( 'alkhatim' ) );
			}
			$this->redirect ()->toRoute ( 'level', array (
					'action' => 'approval' 
			) );
		}
		
		return new ViewModel ( array (
				'approve' => $level 
		) );
	}
	public function addAction() {
		$addForm = new LevelForm ( "addLevelForm" );
		$addForm->get ( 'submit' )->setValue ( 'Save' );
		// fetch last id and increment it.
		$lastId = ( int ) $this->getLevelTable ()->getLastInsertedLevelId () + 1;
		$addForm->get ( 'position_level_id' )->setValue ( $lastId );
		
		$request = $this->getRequest ();
		if ($request->isPost ()) {
			$addForm->setData ( $request->getPost () );
			if ($addForm->isValid ()) {
				$level = $addForm->getData ();
				if ($this->getLevelTable ()->saveLevel ( $level, new UserInfo ( 'alkhatim' ) ) == 1234) {
					$this->redirect ()->toRoute ( 'level', array (
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
			$this->redirect ()->toRoute ( 'level' );
		}
		
		$level = $this->getLevelTable ()->getPositionLevel ( $id, 'history' );
		$editForm = new LevelForm ( "editLevelForm" );
		$editForm->get ( 'submit' )->setValue ( 'Save' );
		
		$editForm->bind ( $level );
		$request = $this->getRequest ();
		if ($request->isPost ()) {
			$editForm->setData ( $request->getPost () );
			if ($editForm->isValid ()) {
				$level = $editForm->getData ();
				if ($this->getLevelTable ()->saveLevel ( $level, new UserInfo ( 'alkhatim' ) ) == 1234) {
					$this->redirect ()->toRoute ( 'level', array (
							'action' => 'approval' 
					) );
				} else {
					return array (
							'editForm' => $editForm,
							'id' => $level->getPositionLevelId (),
							'result' => "Something went wrong." 
					);
				}
			}
		}
		
		return array (
				'editForm' => $editForm,
				'id' => $level->getPositionLevelId (),
				'result' => false 
		);
	}
	public function getLevelTable() {
		if (! $this->levelTable) {
			$sm = $this->getServiceLocator ();
			$this->levelTable = $sm->get ( 'Position\Model\PositionLevelTable' );
		}
		return $this->levelTable;
	}
}