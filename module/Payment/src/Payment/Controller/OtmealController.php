<?php

namespace Payment\Controller;

use Zend\Http\Response;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Payment\Model\Company;
use Payment\Model\DateRange;
use Application\Form\SubmitButonMealForm;
use Application\Form\MonthYear;
use Employee\Mapper\EmployeeService;
use Application\Model\AdvanceHousingGrid;
use Payment\Form\OverTimeMealForm;
use Payment\Form\OverTimeBatchMealForm;
use Application\Model\OtmealGrid;
use Application\Model\OtmealBatchGrid;

class OtmealController extends AbstractActionController {

    public function htmlResponse($html) {
        $response = $this->getResponse();
        $response->setStatusCode(200);
        $response->setContent($html);
        return $response;
    }

    public function listAction() {
        
    }

//************************************AJAX List ***************************************	
    public function ajaxlistAction() {
        $grid = $this->getGrid();
        $grid->setAdapter($this->getDbAdapter())
                ->setSource($this->getOvertimeService()->getOvertimeList())
                ->setParamAdapter($this->getRequest()->getPost());
        //\Zend\Debug\Debug::dump($grid); exit;
        return $this->htmlResponse($grid->render());
    }

//************************************AJAX BATCH ***************************************
    public function ajaxbatchAction() {
           
        $grid = $this->getbatchGrid();
        $grid->setAdapter($this->getDbAdapter())
                ->setSource($this->getOvertimeService()->getOvertimeBatchList())
                ->setParamAdapter($this->getRequest()->getPost());
       // \Zend\Debug\Debug::dump($grid); exit;
        //\Zend\Debug\Debug::dump($this->getOvertimeService()); exit;
        return $this->htmlResponse($grid->render());
    }

    //********************************Open New Batch *******************************************	
    public function openbAction() { 
        $form = new OverTimeBatchMealForm(); 

        return array('form' => $form);
    }

    //********************************************* Save Overtime Batch*****************************************	       
    protected function saveovertimebatchAction() {

        $formValues = $this->params()->fromPost('formVal');
        //\Zend\Debug\Debug::dump($formValues);
        //exit;

        $overtimeService = $this->getOvertimeService();
        $data = array(
            //
            'PreparedBy' => $formValues['preparedBy'],
            'ApprovedBy' => $formValues['approvedBy'],
            'CompanyId' => $formValues['companyId'], /* @@todo get company ID */
            'Status' => '0', //$formValues['Status'],//$formValues['isClosed'],
            'Month' => $formValues['month'],
            'IsPosted' => 'false', //$formValues['IsPosted'],
            //'Approve_Date' => date('Y-m-d'), //$formValues['Approve_Date'],                        
            //'Apply_Date' => date('Y-m-d'), //$formValues['Apply_Date'],
        );
        $overtimeService->saveOverTimeBatch($data);
        exit;
    }

    //*********************************************Remove Batch******************************************************
    public function removebatchAction() {
        // @todo
        $id = (int) $this->params()->fromRoute('id', 0);
        $overtimeService = $this->getOvertimeService();
        $overtimeService->removeOvertimeBatch($id);
        //echo json_encode($id);

        exit;
    }

    //********************************************* ADD Overtime for Employees*****************************************	
    public function addAction() {
   
        $form = new OverTimeMealForm();
        $form->get('empId')
                ->setOptions(array('value_options' => $this->getEmployeeList()))
        //->setAttribute('readOnly', true) 
        ;
        return array('form' => $form);


       
    }

//***********************************Save overtime for Employee***************************************
    protected function saveovertimeAction() {

        $formValues = $this->params()->fromPost('formVal');     
       $overtimeService = $this->getOvertimeService();
        $data = array(
            
         
            'amount' => $formValues['amount'],
            'Status' => '0', 
            'numberOfMeals' => $formValues['employeeNoMeals'], 
            'employeeId' => $formValues['empId'],
            // 'OvertimeMealMstId'   =>$this->getCurrentOvertimeBatch(),
        );
//         \Zend\Debug\Debug::dump($data);
//        exit;
        $overtimeService->saveOverTime($data);
       // \Zend\Debug\Debug::dump($overtimeService);
        exit;
    }

    //********************************************* Remove Employees* Overtime  ****************************************      
    public function removeAction() {
        // @todo
        $id = (int) $this->params()->fromRoute('id', 0);
        $overtimeService = $this->getOvertimeService();
        $overtimeService->removeOverTime($id);
        //echo json_encode($id);

        exit;
    }

//****************************************Apply Overtime for Lsit of Employee*****************************************************
    /* -----------------------------MANDETORY FOR REDIRECT TO APPLY OVERTIME ACTION BUT HOW??? ----------------------- */
    public function applyAction() {

        $form = $this->getForm();
        $prg = $this->prg('/otmeal/apply', true);
        if ($prg instanceof Response) {
            return $prg;
        } elseif ($prg === false) {
            
            return array('form' => $form);
        }
           
        $form->setData($prg);
        
        $isAlreadyClosed = 1; //$paysheet->isPaysheetClosed($company,$dateRange);
        if ($isAlreadyClosed) {
            $reason = "No Batch found  mismatch";
            $this->flashMessenger()->setNamespace('error')
                    ->addMessage('Unable to apply Over Time Meal Batch! ' . $reason);
            $this->redirect()->toRoute('otmeal', array(
                'action' => 'apply'
            ));
        } else {
            $this->flashMessenger()->setNamespace('success')
                    ->addMessage('OT Meal Applied Successfully');
            $this->redirect()->toRoute('otmeal', array(
                'action' => 'add'
            ));
        }

        return array(
            'form' => $form,
            $prg
        );
    }

    /* ************************************APPLY OVERTIME BATCH *******************************************/

    protected function applyovertimeAction() {
        $overtimeService = $this->getOvertimeService();
        
        $data1 = array(
            'OvertimeMealMstId' => $this->getCurrentOvertimeBatch(), 
            'Approve_Date'=> date('Y-m-d'),
            'Apply_Date' => date('Y-m-d'),  
            'IsPosted' => 'true',   
            'Status' => '1', 
        );
        
     //   \Zend\Debug\Debug::dump($data1);exit;
       $data2 = array(
            'OvertimeMealMstId' => $this->getCurrentOvertimeBatch(),
             'Status' => '1',       );
        $overtimeService->applyOverTime($data1 ,$data2);
        
       
        exit;
    }

//**********************************HELPERS HELPERS HELPERS HELPERS HELPERS HELPERS ************************************* 

    private function getForm() {
        $form = new SubmitButonMealForm();
        $form->get('submit')->setValue('Apply Overtime Meal');
        
        return $form;
    }

//****************************** Employee service  **********************************		        
    private function getEmployeeService() {
        return $this->getServiceLocator()->get('employeeMapper');
    }

//****************************** Employee list  **********************************			
    private function getEmployeeList() {
         return $this->getEmployeeService()->employeeList();
        
        //((( return $this->getServiceLocator()->get('overtimeService')->getEmployeeList();
    }

//****************************** Overtime service  **********************************		
    private function getOvertimeService() {
        return $this->getServiceLocator()->get('otmealService');
        //\Zend\Debug\Debug::dump($allowancefac);
    }
  private function getCurrentOvertimeBatch() {
        return $this->getServiceLocator()->get('otmealService')->getCurrentOvertimeBatch();
        //\Zend\Debug\Debug::dump($allowancefac);
    }
//****************************** Used on applying form  **********************************		
    public function successAction() {
        return new ViewModel();
    }

//*******************************Data base Adapter*********************************************
    private function getDbAdapter() {
        return $this->getServiceLocator()->get('sqlServerAdapter');
    }

//******************************Overtime GRID  **********************************		
    private function getGrid() {
        return new OtmealGrid();
    }

//****************************** BATCH GRID  **********************************	
    private function getbatchGrid() {
        return new OtmealBatchGrid();
    }
}
