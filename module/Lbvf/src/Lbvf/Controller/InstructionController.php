<?php

namespace Lbvf\Controller;

use Zend\Mvc\Controller\AbstractActionController; 
use Zend\Http\PhpEnvironment\Response; 
use Lbvf\Form\InstructionForm;
use Lbvf\Form\InstructionFormValidator;
use Application\Model\InstructionGrid;

class InstructionController extends AbstractActionController {
	
	public function indexAction() { }
	
	public function listAction() { }
	
	public function ajaxlistAction() {
		$grid = $this->getGrid();
		$grid->setAdapter($this->getDbAdapter())
		     ->setSource($this->getService()->select())
		     ->setParamAdapter($this->getRequest()->getPost());
		return $this->htmlResponse($grid->render());
	}
	
	public function addAction() {
		$form = $this->getForm();
		$prg = $this->prg('/instruction/add', true);
		if ($prg instanceof Response ) {
			return $prg;
		} elseif ($prg === false) {
			return array ('form' => $form);
		}
		$formValidator = $this->getLocationFormValidator();
		$form->setInputFilter($formValidator->getInputFilter());
		$form->setData($prg);
		if ($form->isValid()) {
			$data = $form->getData();
			$service = $this->getService();
			$service->insert($data);
			$this->flashMessenger()->setNamespace('success')
			->addMessage('LBVF Instruction added successfully');
			$this->redirect ()->toRoute('instruction',array (
					'action' => 'add'
			));
		}
		return array(
				'form' => $form,
				$prg
		);
	}
	
	public function editAction() {
	
		$id = (int) $this->params()->fromRoute('id', 0);
		if (!$id) {
			$this->flashMessenger()->setNamespace('info')
			->addMessage('LBVF Instruction not found,Please Add');
			$this->redirect()->toRoute('instruction', array(
					'action' => 'add'
			));
		}
		$form = $this->getForm();
		$service = $this->getService();
		$instruction = $service->fetchById($id);
		$form = $this->getForm();
		$form->bind($instruction);
		$form->get('submit')->setAttribute('value','Update LBVF Instruction');
	
		$prg = $this->prg('/instruction/edit/'.$id, true);
		if ($prg instanceof Response ) {
			return $prg;
		} elseif ($prg === false) {
			return array ('form' => $form);
		}
	
		$formValidator = $this->getLocationFormValidator();
		$form->setInputFilter($formValidator->getInputFilter());
		$form->setData($prg);
	
		if ($form->isValid()) {
			$data = $form->getData();
			$service->update($data);
			$this->flashMessenger()->setNamespace('success')
			->addMessage('LBVF Instruction updated successfully');
			$this->redirect ()->toRoute('instruction',array (
					'action' => 'list'
			));
		}
		return array(
				'form' => $form,
				$prg
		); 
	}
	
	public function htmlResponse($html) {
		$response = $this->getResponse();
		$response->setStatusCode(200);
		$response->setContent($html);
		return $response;
	}
	
	private function getService() {
		return $this->getServiceLocator()->get('instructionMapper');
	}
	
	private function getDbAdapter() {
		return $this->getServiceLocator()->get('sqlServerAdapter');
	}
	
	private function getForm() {
		return new InstructionForm(); 
	}
	
	private function getLocationFormValidator() {
		return new InstructionFormValidator(); 
	}
	
	private function getGrid() {
		return new InstructionGrid(); 
	}
}
