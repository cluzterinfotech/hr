<?php  

namespace Allowance\Controller; 

use Zend\Mvc\Controller\AbstractActionController; 
use Zend\Http\PhpEnvironment\Response; 
use Allowance\Form\QuartileRatingForm; 
use Employee\Form\LocationFormValidator; 
use Application\Model\QuartileRatingGrid;  
use Allowance\Form\QuartileRatingFormValidator;

class QuartileratingController extends AbstractActionController {
	
	public function indexAction() { exit; }
	
	public function listAction() { }
	
	public function ajaxlistAction() {
		
		$grid = $this->getGrid();
		$company = $this->getServiceLocator()->get('company'); 
		$grid->setAdapter($this->getDbAdapter())
		     ->setSource($this->getService()->selectQuartileRating($company))
		     ->setParamAdapter($this->getRequest()->getPost());
		return $this->htmlResponse($grid->render());
		
	} 
	
	public function addAction() {
		$form = $this->getForm();
		$prg = $this->prg('/quartilerating/add', true);
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
			                       ->addMessage('Quartile value added successfully'); 
			$this->redirect ()->toRoute('quartilerating',array (
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
			                       ->addMessage('Value not found,Please Add');
			$this->redirect()->toRoute('quartilerating', array(
					'action' => 'add'
			)); 
		}
		$form = $this->getForm();
		$service = $this->getService();
		$quartile = $service->fetchQuartileRatingById($id);
		//\Zend\Debug\Debug::dump($quartile);
		//exit; 
		$form = $this->getForm();
		$form->bind($quartile);
		$form->get('submit')->setAttribute('value','Update Value');
		
		$prg = $this->prg('/quartilerating/edit/'.$id, true);
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
			//\Zend\Debug\Debug::dump($data);
			//exit; 
			$service->updateQuartile($data);
			$this->flashMessenger()->setNamespace('success')
			                       ->addMessage('Value updated successfully');
			$this->redirect ()->toRoute('quartilerating',array (
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
		return $this->getServiceLocator()->get('incrementService');
	}
	
	private function getDbAdapter() {
		return $this->getServiceLocator()->get('sqlServerAdapter');
	}
	
	private function getForm() {
		return new QuartileRatingForm(); 
	}
	
	private function getFormValidator() {
		return new QuartileRatingFormValidator(); 
	}
	
	private function getGrid() {
		return new QuartileRatingGrid();
	}
    
	
}