<?php 

namespace Application\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Payment\Model\Company;
use Payment\Model\DateRange;
use Application\Form\SubmitButonForm;
use Application\Form\MonthYear;
use Employee\Mapper\EmployeeService;
use Zend\File\Transfer\Adapter\Http;
use Payment\Form\UploadAttendanceForm;
use Application\Form\AttendanceReport;

class AttendanceController extends AbstractActionController {
	
	public function uploadattendanceAction() {
		$form = new UploadAttendanceForm ();
		$request = $this->getRequest ();
		if ($request->isPost()) { 
			try {
				$this->getDbTransaction()->beginTransaction(); 
				$post = array_merge_recursive ( $request->getPost ()->toArray (), $request->getFiles ()->toArray () );
				$form->setData ( $post );
				if ($form->isValid ()) {
					$data = $form->getData ();
					$fileName = $data ['attendanceFile'] ['name'];
					$chkExt = explode ( ".", $fileName );
					if (strtolower ( $chkExt [1] ) == "csv") {
						$tempPath = $data ['attendanceFile'] ['tmp_name'];
						if (($handle = fopen ( $tempPath, "r" )) !== FALSE) {
							$c = 1;
							while ( ($data = fgetcsv ( $handle, 150, "," )) !== FALSE ) {
								$val1 = $data [0];
								if (( int ) $val1) {
									
									\Zend\Debug\Debug::dump($data); 
									exit; 
									
									/*$dtlsArr = array ( 
										'cardId' => $data [0],
										'attendanceDate' => $currDate,
										'startingTime' => $data [3],
										'endingTime' => $data [6],
										'duration' => $workDuration,
										'difference' => $diff,
										'dayStatus' => $dayStatus,
										'noTransaction' => 0 
									);*/
									
									/*if ($data [3] != 'No transaction' && $data [6] != 'No transaction') {
										$startTime = $data [3];
										$endTime = $data [6];
										$workDuration = $this->getTimeDiff ( $startTime, $endTime, ":" );
										$date = explode ( " ", $data [2] );
										// echo Zend_Debug::dump($date);
										// exit;
										$strLow = strtolower ( $date [1] );
										$three = substr ( $strLow, 0, 3 );
										$dateDay = $this->getMonthName ( $three );
										$currDate = $date [0] . "-" . $dateDay . "-" . $date [2];
										// echo $currDate."<br>";
										// exit;
										$day = date ( 'w', strtotime ( $currDate ) );
										$nrWrkHr = $wh [$day] ['Working_Hours'];
										// echo $nrWrkHr."<br>";
										$dayStatus = $wh [$day] ['Status'];
										// echo $dayStatus."<br><br><br><br><br>";
										$diff = $this->getTimeDiff1 ( $nrWrkHr, $workDuration, "." );
										// echo $nrWrkHr." - ".$workDuration." * ". $diff."<br>";
										if (! $this->checkDate ( $currDate, $data [0] )) {
											$this->insertAttendance ( $dtlsArr );
										} elseif ($this->checkDate ( $currDate, $data [0] )) {
											$this->deleteAttendance ( $currDate, $data [0] );
											$this->insertAttendance ( $dtlsArr );
										}
									} elseif ($data [3] == 'No transaction' || $data [6] == 'No transaction') {
										$startTime = $data [3];
										$endTime = $data [6];
										$workDuration = $this->getTimeDiff ( $startTime, $endTime, ":" );
										$date = explode ( " ", $data [2] );
										$strLow = strtolower ( $date [1] );
										$three = substr ( $strLow, 0, 3 );
										$dateDay = $this->getMonthName ( $three );
										if ($dateDay < 9) {
											$dateDay = "0" . $dateDay;
										}
										$currDate = $date [0] . "-" . $dateDay . "-" . $date [2];
										$day = date ( 'w', strtotime ( $currDate ) );
										$nrWrkHr = $wh [$day] ['Working_Hours'];
										$dayStatus = $wh [$day] ['Status'];
										$diff = $this->getTimeDiff1 ( $nrWrkHr, $workDuration, "." );
										$noTransaction = $this->getNoTransactionDetails($currDate,$dayStatus,$data[0]); 
										// echo $noTransaction."<br>";
										// echo $currDate."<br>";
										$dtlsArr['noTransaction'] = $noTransaction;
										if (! $this->checkDate ( $currDate, $data [0] )) {
											$this->insertAttendance($dtlsArr); 
										} elseif ($this->checkDate ( $currDate, $data [0] )) {
											$this->deleteAttendance ( $currDate, $data [0] );
											$this->insertAttendance($dtlsArr); 
										}
									}*/
								}
							}
							$this->getDbTransaction()->commit(); 
							fclose($handle);
							$this->flashMessenger()->setNamespace('success')
							     ->addMessage('Attendance Uploaded Successfully');
							// exit ();
						} else {
							echo "Unable to open file";
						}
						// exit;
					} else {
						echo "File format is not csv";
					}
					// \Zend\Debug\Debug::dump($data);
				}
			} catch ( \Exception $e ) {
				$this->getDbTransaction()->rollBack(); 
				throw $e;
			}
			
			$this->redirect()->toRoute('attendance',array (
					'action' => 'uploadattendance' 
			));
			//exit ();
		}
		return array (
				'form' => $form 
		);
	}
	
	public function insertAttendance(array $attendanceArray) {
		$this->getAttendanceMapper ()->insertAttendance ( $attendanceArray );
	}
	public function deleteAttendance($currDate, $cardId) {
		//echo $currDate."<br/>";
		//echo $cardId."<br/>";
		//exit; 
		$this->getAttendanceMapper()->deleteAttendance($currDate, $cardId); 
	}
	public function getAttendanceMapper() {
		return $this->serviceLocator->get('attendanceMapper'); 
	}
	public function getNoTransactionDetails($currDate, $dayStatus, $cardId) {
		$dayStatus = trim ( $dayStatus );
		if ($dayStatus === "H") {
			return "Weekend Holidays"; 
		} elseif ($dayStatus === "N") {
			$publicHoliday = 0;
			if ($publicHoliday) {
				return "Public Holiday";
			}
			$empId = $this->getCardEmpId ( $cardId );
			if ($empId) {
				$absReason = $this->getAbscentReason ( $currDate, $empId );
				return $absReason;
			}
			return "Abscent";
		} else {
			return "Abscent";
		}
		return 0;
	}
	public function getAbscentReason($currDate, $empId) {
		// @todo Implementation
		return "NA";
		
		/*
		 * $empId = (int) $empId;
		 * $from = $currDate;
		 * $to = $currDate;
		 * $calculationModel = new Permanent_Model_Calculation();
		 * $levWithoutPayDays = $calculationModel->getLeaveWithoutPayDays($db, $empId, $from, $to);
		 * $sickLeaveDays = $calculationModel->getSickLeaveDays2($db, $empId, $from, $to);
		 * $susDays = $calculationModel->getSuspendDays($db, $empId, $from, $to);
		 * $annualDays = $calculationModel->getAnnualLeaveDays($db, $empId, $from, $to);
		 * $emergencyDays = $calculationModel->getEmergencyLeaveDays($db, $empId, $from, $to); //2
		 * $examDays = $calculationModel->getExamLeaveDays($db, $empId, $from, $to); //3
		 * $hejjDays = $calculationModel->getHejjLeaveDays($db, $empId, $from, $to); //4
		 * $maternityDays = $calculationModel->getMaternityLeaveDays($db, $empId, $from, $to); //6 getMaternityLeaveDays
		 * $travel = $this->isOnTravel($db, $currDate, $empId);
		 * if ($travel) {
		 * return "Is On Travel -" . $travel;
		 * }
		 * if ($levWithoutPayDays) {
		 * return "Leave Without Pay";
		 * }
		 * if ($sickLeaveDays) {
		 * return "Sick Leave ";
		 * }
		 * if ($susDays) {
		 * return "Suspend Days";
		 * }
		 * if ($annualDays) {
		 * return "Annual Leave";
		 * }
		 * if ($emergencyDays) {
		 * return "Emergency Leave ";
		 * }
		 * if ($examDays) {
		 * return "Exam Leave";
		 * }
		 * if ($hejjDays) {
		 * return "Hejj Leave";
		 * }
		 * if ($maternityDays) {
		 * return "Maternity Leave";
		 * }
		 * return "Abscent";
		 */
	}
	public function isOnTravel($db, $currDate, $empId) {
		$empId = ( int ) $empId;
		return 0;
		/*
		 * $select = $db->select()
		 * ->from(array('t' => 'Pmnt_Emp_Travel_Local'), array('Travel_To'))
		 * ->where('Eff_From >= ?', $currDate)
		 * ->where('Eff_To <= ?', $currDate)
		 * ->where('Pmnt_Emp_Mst_Id = ?', $empId)
		 * ->where('Canceled = ?', 0);
		 *
		 * $row = $db->fetchRow($select);
		 *
		 * if (!$row) {
		 * $select1 = $db->select()
		 * ->from(array('t' => 'Pmnt_Emp_Travel_Abroad'), array('Travel_To'))
		 * ->where('Eff_From >= ?', $currDate)
		 * ->where('Eff_To <= ?', $currDate)
		 * ->where('Pmnt_Emp_Mst_Id = ?', $empId)
		 * ->where('Canceled = ?', 0);
		 * $row1 = $db->fetchRow($select1);
		 * if (!$row1) {
		 * return 0;
		 * }
		 * return $row1['Travel_To'];
		 * }
		 * return $row['Travel_To'];
		 * return 0;
		 */
	}
	public function getCardEmpId($cardId) {
		return $this->getAttendanceMapper ()->getCardEmpId ( $cardId );
	}
	public function getTimeDiff($startTime, $endTime, $sep = ":") {
		$start = explode ( $sep, $startTime );
		$end = explode ( $sep, $endTime );
		$hrDiff = $end [0] - $start [0];
		if ($end [1] < $start [1]) {
			$minDiff = $start [1] - $end [1];
			$minDiff = 60 - $minDiff;
			$hrDiff = $hrDiff - 1;
		} else {
			$minDiff = $end [1] - $start [1];
		}
		$diff = 0;
		if ($minDiff < 10) {
			$diff = $hrDiff . ".0" . $minDiff;
		} else {
			$diff = $hrDiff . "." . $minDiff;
		}
		return $diff;
	}
	public function getTimeDiff1($nrWrkHr, $workDuration, $sep = ":") {
		$duration = explode ( ".", $workDuration );
		$nWH = explode ( ".", $nrWrkHr );
		$hdiff = $nWH [0] - $duration [0];
		if ($hdiff > 0) {
			return "-" . $this->getTimeDiff ( $workDuration, $nrWrkHr, "." );
		} elseif ($hdiff == 0) {
			// echo "equal".$workDuration." - ".$nrWrkHr."<br>";
			return number_format ( ($workDuration - $nrWrkHr), 2, '.', '' );
		} else {
			return $this->getTimeDiff ( $nrWrkHr, $workDuration, "." );
		}
	}
	public function checkDate($date, $cardId) {
		return $this->getAttendanceMapper ()->checkDate ( $date, $cardId );
	}
	public function getMonthName($mon) {
		switch ($mon) {
			case "jan" :
				return 1;
				break;
			
			case "feb" :
				return 2;
				break;
			
			case "mar" :
				return 3;
				break;
			
			case "apr" :
				return 4;
				break;
			
			case "may" :
				return 5;
				break;
			
			case "jun" :
				return 6;
				break;
			
			case "jul" :
				return 7;
				break;
			
			case "aug" :
				return 8;
				break;
			
			case "sep" :
				return 9;
				break;
			
			case "oct" :
				return 10;
				break;
			
			case "nov" :
				return 11;
				break;
			
			case "dec" :
				return 12;
				break;
			
			default :
				return 1;
				break;
		}
	}
	public function reportAction() {
		$form = $this->getReportForm ();
		$request = $this->getRequest ();
		if ($request->isPost()) {
			$form->setData ( $request->getPost () );
			if ($form->isValid ()) {
				return $this->redirect()->toRoute('attendance');
			}
		}
		return array (
				'form' => $form 
		);
	}
	public function viewreportAction() {
		$viewmodel = new ViewModel();
		$viewmodel->setTerminal(1);
		$request = $this->getRequest();
		$output = " "; 
		if ($request->isPost ()) {
			$values = $request->getPost();
			$company = $this->getCompanyService();  
			$output = $this->getService()->attendanceReport($company,$values); 
		}
		// \Zend\Debug\Debug::dump($output) ;
		$viewmodel->setVariables ( array (
				'report' => $output 
		)
		// 'name' => array('Employee Name' => 'employeeName'),
		// 'allowance' => $this->getPaysheetAllowanceArray(),
		// 'deduction' => $this->getPaysheetDeductionArray(),
		// 'companyDeduction' => $this->companyDeductionArray()
		); 
		return $viewmodel; 
	}   
	
	public function getReportForm() {
		$form = new AttendanceReport();  
		$form->get('empIdAttendance')
		     ->setOptions(array('value_options' => $this->getEmployeeList()))
		;
		$form->get('departmentAttendance')
		     ->setOptions(array('value_options' => $this->getDepartmentList()))
		;
		$form->get('noAttendanceReason')
		     ->setOptions(array('value_options' => $this->getNoAttendanceReason()))
		;
		$form->get('locationAttendance')
		     ->setOptions(array('value_options' => $this->getLocationList()))
		;
		return $form;   
	}     
	
	private function getEmployeeService() {
		return $this->getServiceLocator()->get('employeeService');
	}
	
	private function getDepartmentList() {
		return $this->getLookupService()->getDepartmentList();
	}
	
	private function getNoAttendanceReason() {
		return $this->getLookupService()->getNoAttendanceReason(); 
	} 
	
	private function getLookupService() {
		return $this->getServiceLocator()->get('lookupService');
	} 
	
	private function getService() {
		return $this->getServiceLocator()->get('overtimeService');
	} 
	
	private function getLocationList() {
		return $this->getLocationService()->locationList();
	}
	
	private function getLocationService() {
		return $this->getServiceLocator()->get('locationMapper');
	}
	
	private function getEmployeeList() {
		$company = $this->getCompanyService(); 
		$companyId = $company->getId();
		return $this->getEmployeeService()->employeeList($companyId); 
	}
	
	public function getCompanyService() {
		return $this->serviceLocator->get('company');
	} 
	
	public function getDbTransaction() {
		return $this->serviceLocator->get ( 'transactionDatabase' );
	}
}   