<?php 
namespace Payment\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\Http\PhpEnvironment\Response; 
use Payment\Form\DeductionOverpaymentForm;
use Payment\Form\DeductionOverpaymentFormValidator; 
use Application\Model\OverPaymentGrid;

class DeductionoverpaymentController extends AbstractActionController {
	
	public function indexAction() { exit; }
	
	public function listAction() { }
	
	public function ajaxlistAction() {
		$grid = $this->getGrid();
		$grid->setAdapter($this->getDbAdapter())
		     ->setSource($this->getService()->selectOverPayment())
		     ->setParamAdapter($this->getRequest()->getPost()); 
		return $this->htmlResponse($grid->render());
	}
	
	public function getDbService() {
		return $this->serviceLocator->get('transactionDatabase'); 
	}
	
	public function addAction() {
		$form = $this->getForm();
		$prg = $this->prg('/deductionoverpayment/add', true);
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
			$company = $this->getCompanyService();
			$companyId = $company->getId();
			$lastMonth = $this->getPaysheetLastMonth();
			$transaction = $this->getDbService(); 
			$transaction->beginTransaction(); 
			$mst = array(
					'employeeId'       => $data->getEmployeeNumber(),
					'isClosed'         => 1,
					'deuStartingDate'  => $lastMonth,
					'companyId'        => $companyId,
			);
			$mstId = $service->insertOverPaymentMst($mst);
			$noOfMonths = $data->getNumberOfMonthsDed();
			$amt = ($data->getAmount()/$noOfMonths); 
			for($i=1;$i<=$noOfMonths;$i++) {
    			$dtls = array(
    				'mstId'                => $mstId,
    			    'dueAmount'            => $amt,
    				//'deductionDate'        =>
    				'paidStatus'           => 0,
    				//'dueCurrentCalcStatus' =>
    			); 
    			$service->insertOverPaymentDtls($dtls); 
			}
			$transaction->commit();
			$this->flashMessenger()->setNamespace('success')
			     ->addMessage('Overpayment Deduction added successfully');
			$this->redirect ()->toRoute('deductionoverpayment',array (
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
			->addMessage('Overpayment Deduction not found,Please Add');
			$this->redirect()->toRoute('deductionoverpayment', array(
					'action' => 'add'
			));
		}
		//$form = $this->getForm();
		$service = $this->getService();
		$overPay = $service->fetchById($id);
		$form = $this->getForm();
		$form->bind($overPay);
		$form->get('submit')->setAttribute('value','Update Overpayment Deduction');
	
		$prg = $this->prg('/deductionoverpayment/edit/'.$id, true);
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
			     ->addMessage('Overpayment Deduction updated successfully');
			$this->redirect ()->toRoute('deductionoverpayment',array (
					'action' => 'list' 
			)); 
		}
		return array(
				'form' => $form,
				$prg
		);
	}
	
	private function getCompanyService() {
		return $this->serviceLocator->get('company');
	} 
	
	public function htmlResponse($html) {
		$response = $this->getResponse();
		$response->setStatusCode(200);
		$response->setContent($html);
		return $response;
	}
	
	/*private function getLocationService() {
		return $this->getServiceLocator()->get('locationMapper');
	}*/ 
	
	private function getDbAdapter() {
		return $this->getServiceLocator()->get('sqlServerAdapter'); 
	} 
	
	private function getForm() {
		$form = new DeductionOverpaymentForm(); 		
		$company = $this->getServiceLocator()->get('company');
		$companyId = $company->getId();
		$form->get('employeeNumber')
		     ->setOptions(array('value_options' =>
				$this->getEmployeeService()->employeeList($companyId)))
		; 
		/*$form->get('employeeNumber')
		     ->setOptions(array('value_options' => $this->getPositionLkpGroup()))
		//->setAttribute('readOnly', true)
		;*/ 
		return $form;   
	}
	
	public function getPaysheetLastMonth() {
		$dateRange = $this->getDateService();
		$from = $dateRange->getFromDate();
		$lastMon = strtotime('-1 month',strtotime($from));
		return date("Y-m-d",$lastMon);
	} 
	
	private function getDateService() {
		return $this->getServiceLocator()->get('dateRange');
	} 
	 
    private function getEmployeeService() {
		return $this->getServiceLocator()->get('employeeService');
	} 
	
	private function getService() {
		return $this->getServiceLocator()->get('overPaymentMapper'); 
	}
	
	private function getFormValidator() {
		return new DeductionOverpaymentFormValidator();
	}
        
	private function getGrid() {
		return new OverPaymentGrid(); 
	}
	
}