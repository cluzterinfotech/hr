<?php 
 
namespace Application\Controller; 

use Zend\Mvc\Controller\AbstractActionController;
use Zend\Http\PhpEnvironment\Response;
use Application\Form\GlassAmountDurationForm;
use Application\Form\GlassAmountDurationFormValidator;
use Application\Model\GlassAmountDurationGrid;
//use Application\Model\Application;

class GlassamountController extends AbstractActionController {
	
	public function indexAction() { exit; }
	
	public function listAction() { }
	
	public function ajaxlistAction() {
		$grid = $this->getGrid();
		$grid->setAdapter($this->getDbAdapter())
		     ->setSource($this->getService()->select())
		     ->setParamAdapter($this->getRequest()->getPost());
		return $this->htmlResponse($grid->render());
	}
	
	/*public function addAction() {
		$form = $this->getForm();
		$prg = $this->prg('/glassamount/add', true);
		if ($prg instanceof Response ) {
			return $prg;
		} elseif ($prg === false) {
			return array ('form' => $form); 
		} 
		$formValidator = $this->getFormValidator();
		$form->setInputFilter($formValidator->getInputFilter());
		$form->setData($prg); 
		if ($form->isValid()) {
			$data = $form->getData(); 
			$service = $this->getService(); 
			$service->insert($data);
			$this->flashMessenger()->setNamespace('success')
			                       ->addMessage('glassamount added successfully'); 
			$this->redirect ()->toRoute('glassamount',array (
					'action' => 'add'
			));
		}
		return array(
				'form' => $form,
				$prg
		);
	}*/ 
	
	public function editAction() {
		
		$id = (int) $this->params()->fromRoute('id', 0);
		if (!$id) {
			$this->flashMessenger()->setNamespace('info')
			                       ->addMessage('glassamount not found,Please Add');
			$this->redirect()->toRoute('glassamount', array(
					'action' => 'add'
			)); 
		}
		$form = $this->getForm();
		$service = $this->getService();
		$glassamount = $service->fetchById($id); 
		$form = $this->getForm();
		$form->bind($glassamount);
		$form->get('submit')->setAttribute('value','Update glassamount');
		
		$prg = $this->prg('/glassamount/edit/'.$id, true);
		if ($prg instanceof Response ) {
			return $prg;
		} elseif ($prg === false) {
			return array ('form' => $form);
		}
		
		$formValidator = $this->getFormValidator();
		$form->setInputFilter($formValidator->getInputFilter());
		$form->setData($prg); 
		
		if ($form->isValid()) {
			$data = $form->getData();
			$service->update($data);
			$this->flashMessenger()->setNamespace('success')
			                       ->addMessage('glassamount updated successfully');
			$this->redirect ()->toRoute('glassamount',array (
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
		return $this->getServiceLocator()->get('glassAmountMapper');
	}
	
	private function getDbAdapter() {
		return $this->getServiceLocator()->get('sqlServerAdapter');
	}
	
	private function getForm() {
		return new GlassAmountDurationForm(); 
	}
	
	private function getFormValidator() {
		return new GlassAmountDurationFormValidator(); 
	}
	 
	private function getGrid() {
		return new GlassAmountDurationGrid(); 
	}
     
}