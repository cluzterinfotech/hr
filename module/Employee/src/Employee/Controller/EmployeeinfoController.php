<?php 

namespace Employee\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\Http\PhpEnvironment\Response; 
use Employee\Form\EmployeeInfoForm; 
use Employee\Form\EmployeeInfoFormValidator;
 
class EmployeeinfoController extends AbstractActionController {
	
	public function indexAction() { exit; }
	
	public function updateinfoAction() {  
		$employeeNumber = $this->getUserService()->getEmployeeId(); 
		if (!$employeeNumber) { 
			$this->flashMessenger()->setNamespace('info') 
			     ->addMessage('Employee info not found,Please Add'); 
			$this->redirect()->toRoute('newemployee', array( 
					'action' => 'add' 
			));   
		}     
		$form = $this->getForm();   
		$service = $this->getEmployeeService(); 
		$id = $service->getIdByEmployeeNumber($employeeNumber); 
		$emp = $service->fetchExistingEmployeeById($id);    
		$employeeNumber = $emp->getEmployeeNumber();   
		$form->bind($emp);  
		$form->get('submit')->setAttribute('value','Update Employee');
		$prg = $this->prg('/employeeinfo/updateinfo/'.$id,true);
		if ($prg instanceof Response) { 
			return $prg; 
		} elseif ($prg === false) {
		    return array ('form' => $form,'empNum' => $employeeNumber);
		} 
		$formValidator = $this->getFormValidator(); 
		$form->setInputFilter($formValidator->getInputFilter()); 
		$form->setData($prg); 
		if ($form->isValid()) {
			$data = $form->getData(); 
			$service->updateExistingEmployeeInfoMain($data); 
			$this->flashMessenger()->setNamespace('success')
			     ->addMessage('Employee Information updated successfully'); 
			$this->redirect ()->toRoute('employeeinfo',array (
					'action' => 'updateinfo'
			)); 
		} else {
			echo "invalid"; 
		}   
		return array(
				'form' => $form,
		        'empNum' => $employeeNumber,
				$prg
		); 
	} 
	
	public function htmlResponse($html) { 
		$response = $this->getResponse();
		$response->setStatusCode(200);
		$response->setContent($html);
		return $response;
	}  
	
	private function getInitialService() { 
		return $this->getServiceLocator()->get('Initial');
	}
    
	private function getEmployeeService() {
		return $this->getServiceLocator()->get('employeeService');    
	} 
	
	private function getDbAdapter() { 
		return $this->getServiceLocator()->get('sqlServerAdapter');  
	} 
	
	private function getFormValidator() { 
		return new EmployeeInfoFormValidator(); 
	} 
	
	private function getForm() { 
		$form = new EmployeeInfoForm(); 
		$form->get('maritalStatus')
		     ->setOptions(array('value_options' => array(
		     	''  => '', 
		     	'1' => 'Married',
		     	'2' => 'Single', 
		     	'3' => 'Divorced',
		     	'4' => 'Widow',
		     	'5' => 'Widower', 
		))); 
		$form->get('religion')
		     ->setOptions(array('value_options' => $this->getReligion() 
		)); 
		
		$form->get('nationality')
		     ->setOptions(array('value_options' => $this->getNationality()
		));    
		$form->get('state')
		     ->setOptions(array('value_options' => $this->getState() 
		));  
		$form->get('skillGroup')
		     ->setOptions(array('value_options' => $this->getSkillGroup()
		));
		return $form; 
	} 
	
	public function reportAction() {
	
		$form = $this->getReportForm();
		$request = $this->getRequest();
		if ($request->isPost()) {
			$form->setData($request->getPost());
			if ($form->isValid()) {
				return $this->redirect()->toRoute('paysheet');
			}
		}
		return array(
				'form' => $form,
		);
	}
	
	private function getCompanyService() {
		return $this->getServiceLocator()->get('company');
	}
	
	private function getReligion() {
		return $this->getLookupService()->getReligionList(); 
	}  
	
	private function getNationality() { 
		return $this->getLookupService()->getNationalityList();
	}
	
	private function getState() {
		return $this->getLookupService()->getStateList();  
	} 
	
	private function getIsPreviousContractor() {
		return $this->getLookupService()->getYesNoList();  
	} 
	
	private function getEmpLocation() {
		return $this->getLookupService()->getLocationList();  
	} 
	
	private function getSkillGroup() { 
		return $this->getLookupService()->getSkillGroupList();  
	} 
	
	private function getCompany() {
		return $this->getLookupService()->getCompanyList();
	}
	
	private function getLookupService() {
		return $this->getServiceLocator()->get('lookupService');  
	} 
	
	private function getPositionService() {
		return $this->getServiceLocator()->get('positionService'); 
	} 
	
	private function getUserService() {
		return $this->getServiceLocator()->get('userInfoService'); 
	}
	
}