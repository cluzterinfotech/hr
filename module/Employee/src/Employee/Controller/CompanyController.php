<?php

namespace Employee\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Employee\Form\CompanyForm;

class CompanyController extends AbstractActionController {
	private $companyTable;
	public function indexAction() {
		$companies = $this->getCompanyTable ()->fetchAll ();
		
		return array (
				'companies' => $companies 
		);
	}
	public function addAction() {
		$form = new CompanyForm ();
		
		$request = $this->getRequest ();
		if ($request->isPost ()) {
			$form->setData ( $request->getPost () );
			if ($form->isValid ()) {
				$data = $form->getData ();
				if ($this->getCompanyTable ()->saveCompany ( $data )) {
					$this->redirect ()->toRoute ( 'company' );
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
			$this->redirect ()->toRoute ( 'company' );
		}
		
		$company = $this->getCompanyTable ()->fetchCompany ( $id );
		$form = new CompanyForm ();
		$form->get ( 'submit' )->setAttribute ( 'value', 'edit' );
		$form->bind ( $company );
		
		$request = $this->getRequest ();
		if ($request->isPost ()) {
			$form->setData ( $request->getPost () );
			if ($form->isValid ()) {
				$data = $form->getData ();
				if ($this->getCompanyTable ()->saveCompany ( $data )) {
					$this->redirect ()->toRoute ( 'company' );
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
		$options = $this->getCompanyTable ()->fetchAllArray ();
		$response->setContent ( \Zend\Json\Json::encode ( $options ) );
		
		return $response;
	}
	public function getCompanyInfoAction() {
		$request = $this->getRequest ();
		if ($request->isPost ()) {
			$id = ( int ) $request->getPost ( 'id', false );
			if (! $id) {
				return false;
			}
			$response = $this->getResponse ();
			$company = $this->getCompanyTable ()->fetchCompanyArray ( $id );
			$response->setContent ( \Zend\Json\Json::encode ( $company ) );
			return $response;
		} else {
			return false;
		}
	}
	public function deleteAction() {
		$id = ( int ) $this->params ()->fromRoute ( 'id', 0 );
		if ($id == 0) {
			$this->redirect ()->toRoute ( 'company' );
		}
		
		$request = $this->getRequest ();
		if ($request->isPost ()) {
			$del = $request->getPost ( 'del', 'No' );
			if ($del == 'Yes') {
				$this->getCompanyTable ()->deleteCompany ( $id );
			}
			$this->redirect ()->toRoute ( 'company' );
		}
		
		return array (
				'id' => $id 
		);
	}
	public function getCompanyTable() {
		if (! $this->companyTable) {
			$sm = $this->getServiceLocator ();
			$this->companyTable = $sm->get ( 'Employee\Model\CompanyTable' );
		}
		return $this->companyTable;
	}
}