<?php 

namespace Application\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\Http\PhpEnvironment\Response;
use Application\Form\CompanyPositionForm;
use Application\Form\CompanyPositionFormValidator;
use Application\Model\UserCompanyPositionGrid; 

class UsercompanypositionController extends AbstractActionController {
	
	public function indexAction() { exit; }
	
	public function listAction() { }
	
	public function ajaxlistAction() {
		$grid = $this->getGrid();
		$grid->setAdapter($this->getDbAdapter())
		     ->setSource($this->getService()->selectCompanyUser())
		     ->setParamAdapter($this->getRequest()->getPost());
		return $this->htmlResponse($grid->render());
	}
	
	public function addAction() {
		$form = $this->getForm();
		$prg = $this->prg('/usercompanyposition/add', true);
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
    			$service = $this->getService(); 
    			$service->insertCompPosition($data);
    			$this->flashMessenger()->setNamespace('success')
    			     ->addMessage('User Company Position added successfully');
    			$this->redirect ()->toRoute('usercompanyposition',array (
    			    'action' => 'add'
    			));
			} catch(\Exception $e) {
			    $this->flashMessenger()->setNamespace('error')
			          ->addMessage($e->getMessage()." please check your entries");
			    $this->redirect ()->toRoute('usercompanyposition',array (
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
			                       ->addMessage('User Company Position not found,Please Add');
			$this->redirect()->toRoute('usercompanyposition', array(
					'action' => 'add'
			)); 
		}
		$form = $this->getForm();
		$service = $this->getService();
		$usercompanyposition = $service->fetchCompPositionById($id); 
		$form = $this->getForm();
		$form->bind($usercompanyposition);
		$form->get('submit')->setAttribute('value','Update User Company Position');
		
		$prg = $this->prg('/usercompanyposition/edit/'.$id, true);
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
			    //$service = $this->getService();
			    $service->updateCompPosition($data);
			    $this->flashMessenger()->setNamespace('success')
			         ->addMessage('User Company Position updated successfully');
			    $this->redirect ()->toRoute('usercompanyposition',array (
			        'action' => 'list'
			    ));
			} catch(\Exception $e) {
			    $this->flashMessenger()->setNamespace('error')
			    ->addMessage($e->getMessage()." please check your entries");
			    $this->redirect ()->toRoute('usercompanyposition',array (
			        'action' => 'add'
			    ));
			}
			
		} 
		return array(
				'form' => $form,
				$prg
		);  
	} 
	
	public function deleteAction() {
	    
	    $id = (int) $this->params()->fromRoute('id', 0);
	    if (!$id) {
	        $this->flashMessenger()->setNamespace('info')
	        ->addMessage('User Company Position not found,Please Add');
	        $this->redirect()->toRoute('usercompanyposition', array(
	            'action' => 'list'
	        ));
	    }
	    $form = $this->getForm();
	    $service = $this->getService();
	    $usercompanyposition = $service->fetchCompPositionById($id);
	    $form = $this->getForm();
	    $form->bind($usercompanyposition);
	    $form->get('submit')->setAttribute('value','Delete User Company Position');
	    
	    $prg = $this->prg('/usercompanyposition/delete/'.$id, true);
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
	            //$service = $this->getService();
	            $service->delete($data);
	            $this->flashMessenger()->setNamespace('success')
	            ->addMessage('User Company Position delete successfully');
	            $this->redirect ()->toRoute('usercompanyposition',array (
	                'action' => 'list'
	            ));
	        } catch(\Exception $e) {
	            $this->flashMessenger()->setNamespace('error')
	            ->addMessage($e->getMessage()." please check your entries");
	            $this->redirect ()->toRoute('usercompanyposition',array (
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
	
	private function getEmpPosition() {
		return $this->getPositionService()->getPositionList();
	} 
	
	private function getPositionService() {
		return $this->getServiceLocator()->get('positionService');
	} 
    
	private function getService() {
		return $this->getServiceLocator()->get('companyService'); 
	}
	
	private function getDbAdapter() {
		return $this->getServiceLocator()->get('sqlServerAdapter');
	}
	
	private function getForm() {
		$form = new CompanyPositionForm();
		$form->get('positionId')
		     ->setOptions(array('value_options' => $this->getEmpPosition()
		));
		$form->get('companyId')
		     ->setOptions(array('value_options' => $this->getCompany()
		));
		return $form;  
	}
	
	private function getFormValidator() {
		return new CompanyPositionFormValidator();
	}
	
	private function getGrid() {
		return new UserCompanyPositionGrid();
	}
	
	private function getCompany() {
		return $this->getLookupService()->getCompanyList();
	}
	
	private function getLookupService() {
		return $this->getServiceLocator()->get('lookupService');
	}
    
}