<?php

namespace Payment\Controller;

use Zend\Http\Response;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Payment\Model\Company;
use Payment\Model\DateRange;
use Application\Form\SubmitButonForm;
use Application\Form\MonthYear;
use Employee\Mapper\EmployeeService;
use Application\Model\AdvanceHousingGrid;
use Payment\Form\OverTimeForm;
use Payment\Form\OverTimeBatchForm;
use Application\Model\OvertimeGrid;
use Application\Model\OvertimeBatchGrid;
use Payment\Form\UploadOvertimeForm;

class OvertimeController extends AbstractActionController {

    public function htmlResponse($html) {
        $response = $this->getResponse();
        $response->setStatusCode(200);
        $response->setContent($html);
        return $response;
    }
    
    public function listAction() { }
    
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
        //\Zend\Debug\Debug::dump($grid); exit;
        return $this->htmlResponse($grid->render());
    }

    //********************************Open New Batch *******************************************	
    public function openbAction() {
        // @todo
        // $id = (int) $this->params()->fromRoute('id',0); 
        // echo json_encode($id);
        // exit;
        // var_dump($this->getEmployeeList()); 
        $form = new OverTimeBatchForm();
        /* $form->get('empId') 
          ->setOptions(array('value_options' => $this->getEmployeeList()))
          //->setAttribute('readOnly', true)
          ; */

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
        // @todo
        // $id = (int) $this->params()->fromRoute('id',0); 
        // echo json_encode($id);
        // exit;
        // var_dump($this->getEmployeeList()); 
//        $form->get('empId') 
//          ->setOptions(array('value_options' => $this->getEmployeeList()))
//          //->setAttribute('readOnly', true)
        $form = new OverTimeForm();
        $form->get('empId')
                ->setOptions(array('value_options' => $this->getEmployeeList()))
        //->setAttribute('readOnly', true) 
        ;
//$form->get('overtimeMstId')
//                ->setOptions(array('value_options' => $this->getCurrentOvertimeBatch()))
//        ->setAttribute('hidden', true) ;
        /* $form->get('employeeNoNOHours')
          ->setOptions(array('value_options' => $this->getPositionList()))
          //->setAttribute('readOnly', true)
          ; */
        /* $form->get('employeeNoHOHours')
          ->setOptions(array('value_options' => $this->getPositionList()))
          //->setAttribute('readOnly', true)
          ; */

        return array('form' => $form); 
        //exit;
    }
    
    public function uploadovertimeAction() { 
    	 
    	$form = new UploadOvertimeForm(); 
    	
    	$request = $this->getRequest(); 
    	if ($request->isPost()) {
    		// Make certain to merge the files info!
    		$post = array_merge_recursive(
    				$request->getPost()->toArray(),
    				$request->getFiles()->toArray()
    		); 
    	    
    		$form->setData($post);
    		if ($form->isValid()) {
    			$data = $form->getData();
    			$fileName = $data['otFile']['name'];  
    			$chkExt = explode(".", $fileName); 
    			//\Zend\Debug\Debug::dump($chkExt);
    			//\Zend\Debug\Debug::dump($fileName);
    			if (strtolower($chkExt[1]) == "csv") { 
    				$tempPath = $data['otFile']['tmp_name']; 
    				if (($handle = fopen($tempPath, "r")) !== FALSE) { 
	    				//$handle = fopen($fileName, "r"); 
	    				// \Zend\Debug\Debug::dump($handle); 
	    				// exit; 
	    				$c= 1; 
	    				while (($dataCsv = fgetcsv($handle, 150, ",")) !== FALSE) { 
	    					echo $dataCsv[0]." - "; 
	    					echo $dataCsv[1]." - ";
	    					echo $dataCsv[2]." - ";
	    					echo $dataCsv[3]."<br/>";  
	    				}  
	    				
	    				fclose($handle);   
	    			} else { 
	    				echo "Unable to open file";   
	    			}
    			    //exit;
    			}  else { 
	    		    echo "File format is not csv";  
	    		} 
    			
    			// \Zend\Debug\Debug::dump($data);   
    			exit;  
    			
    			// Form is valid, save the form!
    			//return $this->redirect()->toRoute('upload-form/success');
    		}
    	} 
    	return array('form' => $form); 
    }
    
    public function downloadotsheetAction() {
        $employeeservice = $this->getEmployeeService()
                                ->employeeNameNumber();
        //\Zend\Debug\Debug::dump($employeeservice);
        $list = array(); 
        $list[] = array('Employee Number','Employee Name','Normal Hour','Holiday Hour'); 
        foreach($employeeservice as $emp) {
        	$list[] = array($emp['employeeNumber'],$emp['employeeName']);  
        }
        header('Content-Type: text/csv; charset=utf-8');
        header('Content-Disposition: attachment; filename=employeelist.csv');
        $output = fopen('php://output', 'w');
        foreach ($list as $fields) fputcsv($output, $fields);
        fclose ($output);
        exit;
        //\Zend\Debug\Debug::dump($list);
          
    	/*$list = array (
	    	array('Employee Name','Employee Number','Normal Hour','Holiday Hour'),
	    	array('Ahmed Taha','	1075'),
	    	array('Hussam','	1111'),
	    	array('Ahmed Salah','	1205',),
	    	array('sdsdfsdf','	234'),
    	);   */
        
    	/*$name = "Overtime"."Permanent".date('F')."".date('Y').".csv";   
    	//$response->setContent($list);
    	$fp= fopen('php://output', 'w');
    	foreach ($list as $fields)
    	{
    		// \Zend\Debug\Debug::dump($fields); 
    		fputcsv($fp, $fields); 
    	} 
    	fclose($fp);
    	//echo filesize($name);
    	//exit; 
    	$response = $this->getResponse();
    	$headers = $response->getHeaders();
    	$headers->addHeaderLine('Content-Type','text/csv');
    	$headers->addHeaderLine('Content-Disposition',"attachment; filename=$name");
    	$headers->addHeaderLine('Accept-Ranges','bytes');
    	$headers->addHeaderLine('Content-Length',filesize($name));  
    	//return $response; 
    	exit; */
    	//echo $shtml;
    	
    	 
    	//echo $shtml; 
    	 
    } 
    
    
    
    //***********************************Save overtime for Employee***************************************
    protected function saveovertimeAction() {
        
        $formValues = $this->params()->fromPost('formVal');     
        $overtimeService = $this->getOvertimeService();
        $data = array( 
          //  'overtimeMstId'   =>'83',//$overtimeService->getCurrentOvertimeBatch()
          // 'overtimeDate' => date('Y-m-d'), // $formValues['overtimeDate'],
            'No_Of_Normal_Hours' => $formValues['employeeNoNOHours'],
            'No_Of_Holiday_Hours' => $formValues['employeeNoHOHours'],
            'Status' => '0', //$formValues['companyId'],/* @@todo get company ID*/
            'Total_Normal_Hours' => $formValues['employeeNoNOHours']*1.5, //$formValues['isClosed'],
            'Total_Holiday_Hours' => $formValues['employeeNoHOHours']*2.0,
            'Emp_Mst_Id' => $formValues['empId'],
            'Overtime_Mst_Id'   =>$this->getCurrentOvertimeBatch(),
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
        $prg = $this->prg('/overtime/apply', true);
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
                    ->addMessage('Unable to apply Over Time! ' . $reason);
            $this->redirect()->toRoute('overtime', array(
                'action' => 'apply'
            ));
        } else {
            $this->flashMessenger()->setNamespace('success')
                    ->addMessage('Overtime Applied Successfully');
            $this->redirect()->toRoute('overtime', array(
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
            'ID' => $this->getCurrentOvertimeBatch(),
            //'overtimeDate'   => date('Y-m-d'),// $formValues['overtimeDate'],
           // 'overtimeNormalHour' => '40', //'overtimeNormalHourVaule',//   => $formValues['employeeNoNOHours'],
            'Approve_Date'=> date('Y-m-d'),
            'Apply_Date' => date('Y-m-d'), //'overtimeHolidayHourValue',//   =>  $formValues['employeeNoHOHours'],
            'IsPosted' => 'true', //('overtimeHolidayHour'+'overtimeNormalHour'),  //$formValues['companyId'],
            //'isClosed'   => '0',//$formValues['isClosed'],
            'Status' => '1', //'empId',//  => $formValues['empId'],
        );
       $data2 = array(
            'Overtime_Mst_Id' => $this->getCurrentOvertimeBatch(),
            
            'Status' => '1', //'empId',//  => $formValues['empId'],
        );
        $overtimeService->applyOverTime($data1,$data2);
        exit;
    } 

//**********************************HELPERS HELPERS HELPERS HELPERS HELPERS HELPERS ************************************* 
    
    private function getForm() {
        $form = new SubmitButonForm();
        $form->get('submit')->setValue('Apply Overtime');
        return $form;
    }
    
    //****************************** Employee service  **********************************		        
    private function getEmployeeService() {
        return $this->getServiceLocator()->get('employeeService');
    }
    
    //****************************** Employee list  **********************************			
    private function getEmployeeList() {
         return $this->getEmployeeService()->employeeList(); 
        //((( return $this->getServiceLocator()->get('overtimeService')->getEmployeeList();
    }
    
    //****************************** Overtime service  **********************************		
    private function getOvertimeService() {
        return $this->getServiceLocator()->get('overtimeService');
        //\Zend\Debug\Debug::dump($allowancefac);
    }
    
    private function getCurrentOvertimeBatch() {
        return $this->getServiceLocator()->get('overtimeService')->getCurrentOvertimeBatch();
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
        return new OvertimeGrid(); 
    }

//****************************** BATCH GRID  **********************************	
    private function getbatchGrid() {
        return new OvertimeBatchGrid();
    }

//	public function calcAction()
//	{   
//		$form = $this->getForm();
//		$prg = $this->prg('/paysheet/calculate', true);
//		if ($prg instanceof Response ) {
//			return $prg;
//		} elseif ($prg === false) {
//			return array ('form' => $form);
//		}
//		$company = $this->getServiceLocator()->get('company');
//		$form->setData($prg);
//		$dateRange = $this->getServiceLocator()->get('dateRange');
//		$paysheet = $this->getServiceLocator()->get('Paysheet'); 
//		$isAlreadyClosed = $paysheet->isPaysheetClosed($company,$dateRange);
//		if($isAlreadyClosed) {
//		    $this->flashMessenger()->setNamespace('info')
//			     ->addMessage('Paysheet Already closed for current month');
//		} else {
//			$employeeMapper = $this->getServiceLocator()->get('CompanyEmployeeMapper');
//			$employeeList = $employeeMapper->fetchAll(); 
//			$paysheet->calculate($employeeList,$company,$dateRange); 
//		    $this->flashMessenger()->setNamespace('success') 
//		         ->addMessage('Paysheet Calculated Successfully'); 
//		}
//		$this->redirect()->toRoute('paysheet',array(
//				'action' => 'calculate'
//		)); 
//		return array(
//			'form' => $form,
//			$prg
//		);  
//	} 
//***************************************************************************************************///////	
//	public function reportAction() {
//		
//		$form = $this->getReportForm();
//		
//		$request = $this->getRequest();
//		if ($request->isPost()) {
//            
//			$form->setData($request->getPost());
//			if ($form->isValid()) {
//				return $this->redirect()->toRoute('paysheet');
//			}
//		}
//		return array(
//				'form' => $form,
//		);
//	}
//	
//	public function viewreportAction() { 
//                                                                                
//        $viewmodel = new ViewModel();
//        $viewmodel->setTerminal(1);       
//        $request = $this->getRequest();
//        $output = " ";
//        
//        if($request->isPost()) {
//            
//            $values = $request->getPost(); 
//            $month = $values['month']; 
//            $year = $values['year']; 
//            $type = 1;
//            
//            $param = array('month' => $month,'year' => $year);
//            
//            //$results = $this->getPaysheetService()->getPaysheetReport($param); 
//            $output = $this->getPaysheetService()->getPaysheetReport($param); 
//            /* if($results) {
//            	foreach($results as $result) {
//            		$output .= $result['employeeNumber']."<br/>";
//            	}
//            } else {
//            	$output = "Sorry! no results found";
//            }  */
//            
//            /* if ($type == 1) {
//                $output = $this->getPaysheetService()->getPaysheetReport($param); 
//            } else if ($type == 2) {
//                $output = $this->getReportTable()->summary($values);
//            } else if ($type == 3) {
//                $output = $this->getReportTable()->byorder($values);
//            } else if ($type == 4) {
//                $output = $this->getReportTable()->bystatus($values);
//            } else if ($type == 5) {
//                $output = $this->getReportTable()->report($values,'2'); 
//            } else if ($type == 6) {
//                $output = $this->getReportTable()->duplicateobr($values); 
//            } */
//            
//        }
//                   
//        $viewmodel->setVariables(array(
//            'report' => $output,
//        	'paysheetArray'  => $this->getPaysheetAllowanceArray()
//        ));
//        return $viewmodel;
//    
//	}
//	    
//	public function getadvancehousingdetailsAction() {
//		$employeeNumber = $this->params()->fromPost('empNumber');
//		$noOfMonths = $this->params()->fromPost('noOfMonth');
//		$advanceService = $this->getAdvanceHousingService();
//		$housingInfo = $advanceService->getadvancehousingdetails($employeeNumber,$noOfMonths);
//		echo json_encode($housingInfo); 
//		exit; 
//	} 
//	protected function getAdvanceHousingService() {
//		return $this->serviceLocator->get('advancePaymentService');
//	}


    /*

      public function getTaxService() {

      }

      public function getReportForm() {
      $form = new MonthYear();
      $form->get('submit')->setValue('View Paysheet Report');
      return $form;
      }

      private function getPaysheetService() {
      return $this->getServiceLocator()->get('paysheetMapper');
      }
     */

//	private function getPositionList() {
//		return array(
//				''  => '',
//				'1' => 'Admin Assistant',
//				'2' => 'Section Head ICT',
//				'3' => 'Manager, HR Planning & Development sdfsd'
//		);
//	}
}
