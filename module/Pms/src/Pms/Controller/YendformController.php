<?php

namespace Pms\Controller; 

use Zend\Mvc\Controller\AbstractActionController;
use Zend\Http\PhpEnvironment\Response;
use Pms\Form\ManageFormValidator;
use Pms\Form\YendForm; 
use Pms\Grid\ManageGrid;
//use Pms\Grid\ManageGrid;
use Zend\View\Model\JsonModel;
     
class YendformController extends AbstractActionController {
    
	public function indexAction() { 
		exit; 
	}
    
	public function listAction() { }  
    
	public function ajaxlistAction() { 
		$grid = $this->getGrid(); 
		$grid->setAdapter($this->getDbAdapter())
		     ->setSource($this->getService()->select())
		     ->setParamAdapter($this->getRequest()->getPost());
		return $this->htmlResponse($grid->render()); 
	}
	
	public function yendAction() { 
		$service = $this->getService(); 
		$pmsId = $service->getPmsIdByYear(date('Y'));
		$employeeId = $this->getUser();
		$id = $service->getPmsIdByEmployee($employeeId,$pmsId); 
		$isYendOpened = $this->getService()->isYendOpened($pmsId);  
		if(!$isYendOpened) {
			$this->flashMessenger()
			     ->setNamespace('info')
			     ->addMessage('Year End is not opened at the moment');  
			$this->redirect ()->toRoute('pmsform',array ( 
					'action' => 'status'
			)); 
		} 
		if(!$id) {  
			//$service->prepareNewIpc($employeeId,$pmsId); 
			$this->flashMessenger()
			     ->setNamespace('info')
			     ->addMessage('IPC Form is not available for your ID,please add');
			$this->redirect ()->toRoute('pmsform',array (
					'action' => 'status'
			)); 
		} 
		$isNonEx = $service->isNonExecutive($employeeId); 
		$form = $this->getForm();   
		$output = $service->getYendPmsById($id,$isNonEx);  
		return array(
				'output'    => $output,
				'form'      => $form,
				'isNonEx'   => $isNonEx
		); 
	}
	
	public function updateobjectiveAction() {
		$formValues = $this->params()->fromPost('formVal',0);
		// need objective id (update based on id itself)
		$data = array(
				'id'	             => $formValues['ipcids'],
				'Obj_Desc'           => $formValues['Obj_Desc'],
				'Obj_Weightage'      => $formValues['Obj_Weightage'],
				'Obj_PI'             => $formValues['Obj_PI'],
				'Obj_Base'           => $formValues['Obj_Base'],
				'Obj_Stretch_02'     => $formValues['Obj_Stretch_02'],
				'Obj_Stretch_01'     => $formValues['Obj_Stretch_01'],
				'Rating'             => $formValues['Rating'],
				'Result'             => $formValues['Result'],
				'Impact'             => $formValues['Impact'],
				'Challenges'         => $formValues['Challenges'],
				'Effort'             => $formValues['Effort'],
		);
		$service = $this->getService();
		$service->updateObjective($data);
		exit; 
	}
	
	public function updatesubobjectiveAction() {
		$formValues = $this->params()->fromPost('formVal',0);
		// need sub objective id (update based on id itself) 
		$data = array(
				'id'	               => $formValues['ipcids'],
				'S_Obj_Desc'           => $formValues['Obj_Desc'],
				'S_Obj_Weightage'      => $formValues['Obj_Weightage'],
				'S_Obj_PI'             => $formValues['Obj_PI'],
				'S_Obj_Base'           => $formValues['Obj_Base'],
				'S_Obj_Stretch_02'     => $formValues['Obj_Stretch_02'],
				'S_Obj_Stretch_01'     => $formValues['Obj_Stretch_01'],
				'Rating'               => $formValues['Rating'],
				'Result'               => $formValues['Result'],
				'Impact'               => $formValues['Impact'],
				'Challenges'           => $formValues['Challenges'],
				'Effort'               => $formValues['Effort'],
		);
		$service = $this->getService();
		$service->updateSubObjective($data);
		exit; 
	}
	
	public function getdtlsbyidAction() {
		$id = (int) $this->params()->fromPost('dtlsid',0);
		
		$res = $this->getService()->getDtlsById($id); 
		
		echo json_encode($res);
		exit; 
	}
	
	public function getdtlsdtlsbyidAction() {
		$id = (int) $this->params()->fromPost('dtlsid',0);
		//$id = '31310'; // @todo get
		$res = $this->getService()->getDtlsDtlsById($id);
		
		$data = array(
				'id'                        => $res['id'],
				'Obj_Id'                    => $res['S_Obj_Id'],
				'Obj_Desc'                  => $res['S_Obj_Desc'],
				'Obj_Weightage'             => (int)$res['S_Obj_Weightage'],
				'Obj_PI'                    => $res['S_Obj_PI'],
				'Obj_Base'                  => $res['S_Obj_Base'],
				'Obj_Stretch_02'            => $res['S_Obj_Stretch_02'],
				'Obj_Stretch_01'            => $res['S_Obj_Stretch_01'],
				'Obj_Target_Date'           => $res['S_Obj_Target_Date'],
				'Rating'                    => $res['Rating'],
				'Result'                    => $res['Result'],
				'Impact'                    => $res['Impact'],
				'Challenges'                => $res['Challenges'],
				'Effort'                    => $res['Effort'],
				//'Obj_Sequence_Id'           => $res['Obj_Sequence_Id'],
				'Myr_Result'                => $res['Myr_Result'],
				'Myr_Gap'                   => $res['Myr_Gap'],
				'Myr_Action_Plan'           => $res['Myr_Action_Plan'],
				'Myr_Superior_Comments'     => $res['Myr_Superior_Comments'],
	
		);
		echo json_encode($data); 
		exit;
	}   
	
	public function reportAction() {
		
	}
	
	public function yendapproveAction() {
	
	} 
	
	public function statusAction() {
		$status = "not available";// $this->getService()->getPmsStatus($this->getUser());
	    return array('status' => $status); 
	}
    
	public function htmlResponse($html) {
		$response = $this->getResponse();
		$response->setStatusCode(200);
		$response->setContent($html);
		return $response;
	}
    
	private function getService() {
		return $this->getServiceLocator()->get('pmsFormService'); 
	}
	
	private function getGrid() {
		return new ManageGrid();
	}
    
	private function getDbAdapter() {
		return $this->getServiceLocator()->get('sqlServerAdapter');
	}
    
	private function getForm() {
		$form = new YendForm(); 
		$form->get('Obj_Desc')->setAttribute('style', 'width: 600px;');
		$form->get('Rating')
		     ->setOptions(array('value_options' => $this->getRating()))
		; 
		return $form; 
	}
    
	private function getFormValidator() { 
		return new ManageFormValidator(); 
	} 
	
	private function getRating() {
		return array( 
			''   =>   '',
		    '1'   =>   '1',
			'2'   =>   '2',
			'3'   =>   '3',
			'4'   =>   '4',
		);
	}
    
	private function getCurrentActivityList($id) {
		return $this->getService()->getCurrentActivityList($id);
	}
	
	private function getOrganisationLevelList() {
		return $this->getLookupService()->getOrganisationLevelList();
	}
	
    private function getPositionList() {
    	return $this->getService()->getPositionList(); 
	} 
	
	private function getEmpTypeList() {
		return $this->getLookupService()->getEmpTypeList();
	} 
	
	
	private function getLookupService() {
		return $this->getServiceLocator()->get('lookupService');
	}
	
	private function getUser() {
		return $this->getUserInfoService()->getEmployeeId();
	}
	
	private function getUserInfoService() {
		return $this->getServiceLocator()->get('userInfoService');
	} 
	
}   