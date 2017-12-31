<?php

namespace Pms\Controller; 

use Zend\Mvc\Controller\AbstractActionController;
use Zend\Http\PhpEnvironment\Response;
use Pms\Form\ManageFormValidator;
use Pms\Form\MyrForm; 
use Pms\Grid\ManageGrid;
//use Pms\Grid\ManageGrid;
use Zend\View\Model\JsonModel;
     
class MyrformController extends AbstractActionController {
    
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
	
	public function myrAction() { 
		$service = $this->getService(); 
		$year = date('Y');
		$pmsId = $service->getPmsIdByYear($year);
		$employeeId = $this->getUser();
		$id = $service->getPmsIdByEmployee($employeeId,$pmsId);
		// check if IPC is opened
		$isMyrOpened = $this->getService()->isMyrOpened($pmsId);  
		if(!$isMyrOpened) {
			$this->flashMessenger()
			     ->setNamespace('info')
			     ->addMessage('MYR is not opened at the moment');  
			$this->redirect ()->toRoute('pmsform',array ( 
					'action' => 'status'
			)); 
		} 
		// check is have MYR 
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
		$output = $service->getMyrPmsById($id,$isNonEx);  
		return array(
				'output'    => $output,
				'form'      => $form,
				'isNonEx'   => $isNonEx
		); 
	}
	
	
    
	/*public function addAction() {
		$form = $this->getForm(); 
		$form->get('Curr_Activity')
		     ->setOptions(array('value_options' => $this->getDefaultList())); 
		$prg = $this->prg('/manage/add', true);
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
			//\Zend\Debug\Debug::dump($data); 
			//exit; 
			$service->insert($data);
			$this->flashMessenger()
			     ->setNamespace('success')
			     ->addMessage('PMS Fisical Year added successfully');
			$this->redirect()->toRoute('manage',array (
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
			$this->flashMessenger()
			     ->setNamespace('info')
			     ->addMessage('PMS Fisical Year not found,Please Add');
			$this->redirect()->toRoute('manage', array(
					'action' => 'add'
			)); 
		}
		
		$form = $this->getForm();
		$service = $this->getService();
		$values = $service->fetchById($id);
		$form->get('Curr_Activity')
		     ->setOptions(array('value_options' => $this->getCurrentActivityList($id)));
        //\Zend\Debug\Debug::dump($values);
        //exit; 
		$form->bind($values);
		$form->get('submit')->setAttribute('value','Update PMS Fisical Year');
        
		$prg = $this->prg('/manage/edit/'.$id, true);
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
			$service->updateRow($data);
			$this->flashMessenger()
			     ->setNamespace('success')
			     ->addMessage('PMS Fisical Year updated successfully');
			$this->redirect ()->toRoute('manage',array (
					'action' => 'list'
			));
		}
		return array(
				'form' => $form,
				$prg
		);
	}*/ 
	
	// save new Objective
	/*public function saveobjectiveAction() {
		$formValues = $this->params()->fromPost('formVal',0);
		$data = array(
		    'Pms_Info_Mst_Id'	 => $formValues['ipcids'],
			'Obj_Desc'           => $formValues['Obj_Desc'],
			'Obj_Weightage'      => $formValues['Obj_Weightage'],
			'Obj_PI'             => $formValues['Obj_PI'],
			'Obj_Base'           => $formValues['Obj_Base'],
			'Obj_Stretch_02'     => $formValues['Obj_Stretch_02'],
			'Obj_Stretch_01'     => $formValues['Obj_Stretch_01']
		); 
		$service = $this->getService(); 
		$service->insertNewObjective($data);   
		exit;
	}
	
	public function savenewsubobjectiveAction() {
		$formValues = $this->params()->fromPost('formVal',0);
		
		$data = array(
				'Pms_Info_Dtls_id'	   => $formValues['ipcids'], 
				'S_Obj_Desc'           => $formValues['Obj_Desc'],
				'S_Obj_Weightage'      => $formValues['Obj_Weightage'],
				'S_Obj_PI'             => $formValues['Obj_PI'],
				'S_Obj_Base'           => $formValues['Obj_Base'],
				'S_Obj_Stretch_02'     => $formValues['Obj_Stretch_02'],
				'S_Obj_Stretch_01'     => $formValues['Obj_Stretch_01']
		);
		// need objective id 
		$service = $this->getService();
		$service->insertNewSubObjective($data);  
		exit;  
	}*/
	
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
				'Myr_Result'         => $formValues['Myr_Result'],
				'Myr_Gap'            => $formValues['Myr_Gap'],
				'Myr_Action_Plan'    => $formValues['Myr_Action_Plan'],
				'Myr_Superior_Comments'     => $formValues['Myr_Superior_Comments'],
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
				'Myr_Result'         => $formValues['Myr_Result'],
				'Myr_Gap'            => $formValues['Myr_Gap'],
				'Myr_Action_Plan'    => $formValues['Myr_Action_Plan'],
				'Myr_Superior_Comments'     => $formValues['Myr_Superior_Comments'],
		);
		$service = $this->getService();
		$service->updateSubObjective($data);
		exit; 
	}
	
	/*public function deleteobjectiveAction() {
		$formValues = $this->params()->fromPost('formVal',0);
		// need objective id (delete based on id itself)
		$data = array(
				'id'	 => $formValues['ipcids']
		);
		$service = $this->getService();
		$service->deleteObjective($data);
		exit;
	}
	
	public function deletesubobjectiveAction() {
		//exit;
		$formValues = $this->params()->fromPost('formVal',0);
		// need sub objective id (update based on id itself)
		$data = array(
				'id'	 => $formValues['ipcids']
		);
		//\Zend\Debug\Debug::dump($data);
		//exit;
		$service = $this->getService();
		$service->deleteSubObjective($data);
		exit;
	}*/
	
	public function getdtlsbyidAction() {
		$id = (int) $this->params()->fromPost('dtlsid',0);
		
		$res = $this->getService()->getDtlsById($id); 
		/*$data = array(
				'id'                        => $res['id'],
				'Obj_Id'                    => $res['Obj_Id'],
				'Obj_Desc'                  => $res['Obj_Desc'],
				'Obj_Weightage'             => (int)$res['Obj_Weightage'], 
				'Obj_PI'                    => $res['Obj_PI'],
				'Obj_Base'                  => $res['Obj_Base'],
				'Obj_Stretch_02'            => $res['Obj_Stretch_02'],
				'Obj_Stretch_01'            => $res['Obj_Stretch_01'],
				'Obj_Target_Date'           => $res['Obj_Target_Date'],
				'Rating'                    => $res['Rating'],
				'Result'                    => $res['Result'],
				'Impact'                    => $res['Impact'],
				'Challenges'                => $res['Challenges'],
				'Effort'                    => $res['Effort'],
				'Obj_Sequence_Id'           => $res['Obj_Sequence_Id'],
				'Myr_Result'                => $res['Myr_Result'],
				'Myr_Gap'                   => $res['Myr_Gap'],
				'Myr_Action_Plan'           => $res['Myr_Action_Plan'],
				'Myr_Superior_Comments'     => $res['Myr_Superior_Comments'],
				
		); */
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
	
	public function myrapproveAction() {
	
	} 
	
	public function statusAction() {
		$status = "not opened";// $this->getService()->getPmsStatus($this->getUser());
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
		$form = new MyrForm(); 
		$form->get('Obj_Desc')->setAttribute('style', 'width: 600px;');
		//$form->get('Curr_Activity')
		    // ->setOptions(array('value_options' => $this->getSectionList())) 
		return $form; 
	}
    
	private function getFormValidator() { 
		return new ManageFormValidator(); 
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