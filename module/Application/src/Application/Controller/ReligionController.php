<?php 
 
namespace Application\Controller; 

use Zend\Mvc\Controller\AbstractActionController;
use Zend\Http\PhpEnvironment\Response;
use Application\Form\ReligionForm;
use Application\Form\ReligionFormValidator;
use Application\Model\ReligionGrid;

class ReligionController extends AbstractActionController {
	
	public function indexAction() { exit; }
	
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
		$prg = $this->prg('/religion/add', true);
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
			try {
			    $service->insert($data);
			    $this->flashMessenger()->setNamespace('success')
			    ->addMessage('religion added successfully');
			    $this->redirect ()->toRoute('religion',array (
			        'action' => 'add'
			    ));
			} catch(\Exception $e) {
			    $this->flashMessenger()->setNamespace('error')
			    ->addMessage($e->getMessage()." please check your entries");
			    $this->redirect ()->toRoute('religion',array (
			        'action' => 'add'
			    ));
			}
			
			
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
			                       ->addMessage('religion not found,Please Add');
			$this->redirect()->toRoute('religion', array(
					'action' => 'add'
			)); 
		}
		$form = $this->getForm();
		$service = $this->getService();
		$religion = $service->fetchById($id); 
		$form = $this->getForm();
		$form->bind($religion);
		$form->get('submit')->setAttribute('value','Update religion');
		
		$prg = $this->prg('/religion/edit/'.$id, true);
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
			
			try {
			    $service->update($data);
			    $this->flashMessenger()->setNamespace('success')
			    ->addMessage('religion updated successfully');
			    $this->redirect ()->toRoute('religion',array (
			        'action' => 'list'
			    ));
			} catch(\Exception $e) {
			    $this->flashMessenger()->setNamespace('error')
			    ->addMessage($e->getMessage()." please check your entries");
			    $this->redirect ()->toRoute('religion',array (
			        'action' => 'list'
			    ));
			}
			
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
		return $this->getServiceLocator()->get('religionMapper');
	}
	
	private function getDbAdapter() {
		return $this->getServiceLocator()->get('sqlServerAdapter');
	}
	
	private function getForm() {
		return new ReligionForm();
	}
	
	private function getFormValidator() {
		return new ReligionFormValidator();
	}
	
	private function getGrid() {
		return new ReligionGrid();
	}
    
}