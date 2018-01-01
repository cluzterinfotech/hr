<?php

namespace Employee\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Employee\Form\SalaryGradeForm;

class SalaryGradeController extends AbstractActionController {
	private $salaryGradeTable;
	public function indexAction() {
		$grades = $this->getSalaryGradeTable ()->fetchAll ();
		
		return array (
				'grades' => $grades 
		);
	}
	public function addAction() {
		$form = new SalaryGradeForm ();
		$request = $this->getRequest ();
		if ($request->isPost ()) {
			$form->setData ( $request->getPost () );
			if ($form->isValid ()) {
				$data = $form->getData ();
				if ($this->getSalaryGradeTable ()->saveSalaryGrade ( $data )) {
					$this->redirect ()->toRoute ( 'salaryGrade' );
				}
			}
		}
		return array (
				'form' => $form 
		);
	}
	public function editAction() {
		$id = ( int ) $this->params ()->fromRoute ( 'id', 0 );
		if ($id == 0) {
			$this->redirect ()->toRoute ( 'salaryGrade' );
		}
		
		$grade = $this->getSalaryGradeTable ()->fetchSalaryGrade ( $id );
		$form = new SalaryGradeForm ();
		$form->get ( 'submit' )->setAttribute ( 'value', 'edit' );
		$form->bind ( $grade );
		
		$request = $this->getRequest ();
		if ($request->isPost ()) {
			$form->setData ( $request->getPost () );
			if ($form->isValid ()) {
				$data = $form->getData ();
				if ($this->getSalaryGradeTable ()->saveSalaryGrade ( $data )) {
					$this->redirect ()->toRoute ( 'salaryGrade' );
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
		$options = $this->getSalaryGradeTable ()->fetchAllArray ();
		$response->setContent ( \Zend\Json\Json::encode ( $options ) );
		
		return $response;
	}
	public function deleteAction() {
		$id = ( int ) $this->params ()->fromRoute ( 'id', 0 );
		if ($id == 0) {
			$this->redirect ()->toRoute ( 'salaryGrade' );
		}
		
		$request = $this->getRequest ();
		if ($request->isPost ()) {
			$del = $request->getPost ( 'del', 'No' );
			if ($del == 'Yes') {
				$this->getSalaryGradeTable ()->deleteSalaryGrade ( $id );
			}
			$this->redirect ()->toRoute ( 'salaryGrade' );
		}
		
		return array (
				'id' => $id 
		);
	}
	public function getSalaryGradeTable() {
		if (! $this->salaryGradeTable) {
			$sm = $this->getServiceLocator ();
			$this->salaryGradeTable = $sm->get ( 'Employee\Model\SalaryGradeTable' );
		}
		return $this->salaryGradeTable;
	}
}