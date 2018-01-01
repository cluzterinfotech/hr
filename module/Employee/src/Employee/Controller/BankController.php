<?php

namespace Employee\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Employee\Form\BankForm;

class BankController extends AbstractActionController {
	private $bankTable;
	public function indexAction() {
		$banks = $this->getBankTable ()->fetchAll ();
		
		return array (
				'banks' => $banks 
		);
	}
	public function addAction() {
		$form = new BankForm ();
		
		$request = $this->getRequest ();
		if ($request->isPost ()) {
			$form->setData ( $request->getPost () );
			if ($form->isValid ()) {
				$data = $form->getData ();
				if ($this->getBankTable ()->saveBank ( $data )) {
					$this->redirect ()->toRoute ( 'bank' );
				}
			} else {
				echo "Invalid";
			}
		}
		
		return array (
				'form' => $form 
		);
	}
	public function editAction() {
		$id = ( int ) $this->params ()->fromRoute ( 'id', 0 );
		if ($id == 0) {
			$this->redirect ()->toRoute ( 'bank' );
		}
		
		$bank = $this->getBankTable ()->fetchBank ( $id );
		$form = new BankForm ();
		$form->get ( 'submit' )->setAttribute ( 'value', 'edit' );
		$form->bind ( $bank );
		
		$request = $this->getRequest ();
		if ($request->isPost ()) {
			$form->setData ( $request->getPost () );
			if ($form->isValid ()) {
				$data = $form->getData ();
				if ($this->getBankTable ()->saveBank ( $data )) {
					$this->redirect ()->toRoute ( 'bank' );
				}
			} else {
				echo "Invalid";
			}
		}
		return array (
				'form' => $form 
		);
	}
	
	
	public function getAction() {
		$response = $this->getResponse ();
		$options = $this->getBankTable ()->fetchAllArray ();
		$response->setContent ( \Zend\Json\Json::encode ( $options ) );
		
		return $response;
	}
	public function deleteAction() {
		$id = ( int ) $this->params ()->fromRoute ( 'id', 0 );
		if ($id == 0) {
			$this->redirect ()->toRoute ( 'bank' );
		}
		
		$request = $this->getRequest ();
		if ($request->isPost ()) {
			$del = $request->getPost ( 'del', 'No' );
			if ($del == 'Yes') {
				$this->getBankTable ()->deleteBank ( $id );
			}
			$this->redirect ()->toRoute ( 'bank' );
		}
		
		return array (
				'id' => $id 
		);
	}
	public function getBankTable() {
		if (! $this->bankTable) {
			$sm = $this->getServiceLocator ();
			$this->bankTable = $sm->get ( 'Employee\Model\BankTable' );
		}
		return $this->bankTable;
	}
}