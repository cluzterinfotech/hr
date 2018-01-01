<?php

namespace Pms\Model;

use Pms\Mapper\PmsFormMapper;
use Payment\Model\Company;
use Payment\Model\DateRange; 
use Application\Persistence\TransactionDatabase;

class PmsFormService {
    
    private $pmsFormMapper; 
    
    private $service;
    	
	public function __construct(PmsFormMapper $pmsFormMapper,$sm) {
		$this->pmsFormMapper = $pmsFormMapper; 
		$this->service = $sm; 
		$this->transaction = 
		new TransactionDatabase($this->service->get('sqlServerAdapter'));
	} 
	
	public function isNonExecutive($employeeId) {
		//return 1; 
		$posService = $this->service->get('positionService');
		return $posService->isNonExecutive($employeeId); 
	}
	
	public function updateObjectiveWeightage($objId) {
		// get all sub objective 
		$c = 0; 
		$weightage = 0; 
		$dtlsDtls = $this->pmsFormMapper->getDtlsDtlsByDtlsId($objId);
		foreach($dtlsDtls as $subsub) {
			$c++; 
			$weightage += $subsub['S_Obj_Weightage'];  
		} 
		$array = array(
				'id'             => $objId,
				'Obj_Weightage'  => $weightage,
		); 
		if($c) {
		    $this->updateObjTemp($array);
		} 
	}
	
	public function updateObjTemp($data) {
		return $this->pmsFormMapper->updateObjective($data);
	}
	
	public function getObjectiveIdBySubId($subObjId) { 
		return $this->pmsFormMapper->getObjectiveIdBySubId($subObjId);
		//exit; 
	}
	
	public function isIpcOpened($pmsId) {
		return $this->pmsFormMapper->isIpcOpened($pmsId); 
	}
	
	public function isMyrOpened($pmsId) {
		return $this->pmsFormMapper->isMyrOpened($pmsId);
	}
	
	public function isYendOpened($pmsId) {
		return $this->pmsFormMapper->isYendOpened($pmsId);
	}
	
	public function insertNewObjective($data) {
		return $this->pmsFormMapper->insertNewObjective($data); 
	}
	
	public function insertNewSubObjective($data) {
		$id = $this->pmsFormMapper->insertNewSubObjective($data);
		$this->updateObjectiveWeightage($data['Pms_Info_Dtls_id']); 
		return $id; 
	}
	
	public function updateObjective($data) {
		$id = $this->pmsFormMapper->updateObjective($data);
		$this->updateObjectiveWeightage($data['id']);
		return $id;
	}
	
	public function updateSubObjective($data) {
		$id = $this->pmsFormMapper->updateSubObjective($data);
		$objId = $this->getObjectiveIdBySubId($data['id']); 
		$this->updateObjectiveWeightage($objId);
		return $id;
	}
	
	public function deleteObjective($data) {
		return $this->pmsFormMapper->deleteObjective($data);
	}
	
	public function deleteSubObjective($data) { 
		//echo $data['id'];
		//exit; 
		$objId = $this->getObjectiveIdBySubId($data['id']); 
		$id = $this->pmsFormMapper->deleteSubObjective($data);
		$this->updateObjectiveWeightage($objId);
		return $id; 
	}
	
	public function getPmsIdByYear($year) {
		return $this->pmsFormMapper->getPmsIdByYear($year); 
	}
	
	public function getPmsIdByEmployee($employeeId,$pmsId) {
		return $this->pmsFormMapper->getPmsIdByEmployee($employeeId,$pmsId);
	}
	
	public function getFormOutput($id) {
		return $this->getHeader($id); 
	}
	
	public function getIpcPmsById($id,$isNonEx) {
		$formType = "IPC"; 
		$c= 1; 
		$row = $this->pmsFormMapper->getPmsHeaderId($id); 
		$output = $this->getHeader($row); 
		$employeeId = $row['Pmnt_Emp_Mst_Id'];
		//$isNonEx = 1;//$this->isNonExecutive($employeeId);
		$output .= $this->getTotalWeightage($id); 
		$output .= "<br/>
          <table width='1050px' border='1' font-size='6px' align='center' id='table1' width='100%' 
	      bordercolor='#ccc' cellpadding = '6px'  style='border-collapse: collapse'> ";
		$dtls = $this->pmsFormMapper->getDtlsByMstId($id);
		foreach($dtls as $r) {
			$dtlsId = $r['id']; 
			$objId = $r['Obj_Id']; 
			if($objId != '21' && $objId != '22') {
				//\Zend\Debug\Debug::dump($objId); 
				//exit; 
			    $output .= $this->getFormDtlsMain($r,$c,$isNonEx);
			    $dtlsDtls = $this->pmsFormMapper->getDtlsDtlsByDtlsId($dtlsId);
			    foreach($dtlsDtls as $subsub) {
			    	$output .= $this->getFormDtlsSub($subsub,$formType,$isNonEx);
			    }
			    $output .= $this->addSubObj($dtlsId,$formType);
			} else {
				$output .= $this->getFormDtlsMainWoEditDel($r,$c,$isNonEx);
			}  
			$c++; 
		}   
		$output .= "</table><br/>";
		if($id) {
		    $output .= $this->addMainObj($id);
		} 
		return $output;  
	}
	
	public function getDtlsById($id) {
		return $this->pmsFormMapper->getDtlsById($id);
	}
	
	public function getDtlsDtlsById($id) {
		return $this->pmsFormMapper->getDtlsDtlsById($id);
	}
	
	
	public function getTotalWeightageById($id) { 
		return $this->pmsFormMapper->getTotWeightage($id); 
		// @todo
		return 100; 
	}
	
	public function getTotalWeightage($id) {
		
		$totWeig = $this->getTotalWeightageById($id); 
		
		$output = "<br/>
		    <table border='1' cellpadding='5px' width='30%'
		    		style='border-collapse: collapse'>
		    <tr>
		    <td bgcolor='#ccc' width='15%'><font color='000000'><b>Total Weightage</b></font></td>
		    <td id='weight' width='15%' style='font-weight:bold;'>".$totWeig."</td>
		    </tr>
		    </table>";
		return $output;
	} 
	
	
	public function getFormDtlsMain($row,$c,$isNonEx) {
		$r = array(); 
		if($isNonEx) {
		    $name = "Standard";
		} else {
			$name = "Base";
		} 
		$output = "
		     
		    <tr bgcolor='#ccc' ".$formType." style ='font-weight:bold;'>  
            <td width='9px' align='center' >&nbsp;</td>
            <td width='20px' align='center' >&nbsp;
            <td width='200px' align='center' <b>_______________Objective______________</b></td>
            <td width='20px' align='center' <b>Wei in %</b></td>
            <td width='150px' align='center' <b>_______PI___________</b></td>
            <td width='200px' align='center' <b>________ ".$name."__________</b></td> ";  
            if(!$isNonEx) {
                $output .="<td width='150px' align='center' <b>Stretch 2</b></td>
                           <td width='50px' align='center' <b>Stretch 1</b></td>";
            }		     
           
            
            $output .="</tr>
            		
            <tr >
            <td align='center' class='noBorder'>".$c."</td>
            <td align='left' > 
            <p><b><a href='#' id = '".$row['id']."' class = 'editIpc'>Edit</a></b></p>
            <p><b>Main</b></p>
            <p><b><a href='#' id = '"."d".$row['id']."' class = 'deleteIpc'>Delete</a></b></p>
            </td> 
            <td>".$row['Obj_Desc']."</td>
            <td>".$row['Obj_Weightage']."</td>
            <td>".$row['Obj_PI']."</td>
            <td>".$row['Obj_Base']."</td>";
             if(!$isNonEx) {
                 $output .="<td>".$row['Obj_Stretch_02']."</td>
                            <td>".$row['Obj_Stretch_01']."</td>";
            }
           // $output .="<td>".$row['Obj_Stretch_02']."</td>
            //<td>".$row['Obj_Stretch_01']."</td>
            
            $output .="</tr>
            		
		    ";
		return $output;
	}
	
	public function getFormDtlsMainWoEditDel($row,$c,$isNonEx) {
		$r = array();
	    if($isNonEx) {
		    $name = "Standard";
		} else {
			$name = "Base";
		} 
		$output = "
		  
		    <tr bgcolor='#ccc' ".$formType." style ='font-weight:bold;'>
            <td width='9px' align='center' >&nbsp;</td>
            <td width='20px' align='center' >&nbsp;
            <td width='200px' align='center' <b>_______________Objective______________</b></td>
            <td width='20px' align='center' <b>Wei in %</b></td>
            <td width='150px' align='center' <b>_______PI___________</b></td>
            <td width='200px' align='center' <b>________ ".$name."__________</b></td>";
		    
            if(!$isNonEx) {
                $output .="<td width='150px' align='center' <b>Stretch 2</b></td>
                           <td width='50px' align='center' <b>Stretch 1</b></td>";
            }
            $output .="</tr>
	
            <tr >
            <td align='center' class='noBorder'>".$c."</td>
            <td align='left' >
            <p><b>Main</b></p>
            </td>
            <td>".$row['Obj_Desc']."</td>
            <td>".$row['Obj_Weightage']."</td>
            <td>".$row['Obj_PI']."</td>
            <td>".$row['Obj_Base']."</td>";
            if(!$isNonEx) {
                 $output .="<td>".$row['Obj_Stretch_02']."</td>
                            <td>".$row['Obj_Stretch_01']."</td>";
            }
            
            $output .="</tr>
	
		    ";
		return $output;
	}
	
	public function getFormDtlsSub($row,$formType,$isNonEx) {
		$r = array();
		$name = "";
		$output = " 
            <tr ".$formType.">
	            <td align='center' class='noBorder'>".$i."</td>
	            <td align='left' >
	            <p><b><a href='#' id = '".$row['id']."' class = 'editIpcDtls'>Edit</a></b></p>
	            <p><b>Sub</b></p>
	            <p><b><a href='#' id = '"."d".$row['id']."' class = 'deleteIpcDtls'>Delete</a></b></p>
	            </td>
	            <td>".$row['S_Obj_Desc']."</td>
	            <td>".$row['S_Obj_Weightage']."</td>
	            <td>".$row['S_Obj_PI']."</td>
	            <td>".$row['S_Obj_Base']."</td>";
	            if(!$isNonEx) {
                 $output .="<td>".$row['S_Obj_Stretch_02']."</td>
                            <td>".$row['S_Obj_Stretch_01']."</td>";
                }
          
	            $output .="<td>&nbsp;</td>
            </tr>"; 
		return $output;
	}
	
	public function addSubObj($objId,$formType) { 
		return "
			<tr>
		        <td align='left'  colspan='8'>&nbsp;
				<b><a href='#' id = '".$objId."' class = 'pmsSubNew'>Add New Sub-Objective</a></b>
				</td>
		    </tr>";
	}
	
	public function addSubObjBlank($objId,$formType) {
		return "
		    <tr>
		        <td align='left' colspan='8'>&nbsp;</td>
		    </tr>"; 
	}
	
	public function addMainObj($mstid) {
		$output = "<tr  >
		<td align='left' colspan='8'>&nbsp;
		<p><b><a href='#' id = '".$mstid."' class = 'pmsMainNew'>Add Main Objective</a></b></p>		
		</td>
		</tr>";
		return $output;
	}
	
	public function getHeader($row) {
		$output = "
		    <table border='1' cellpadding='5px' width='100%'  style='border-collapse: collapse' >
		        <tr>
				<td bgcolor='#ccc'  width='20%'><font color='000000'><b>Name </b></font></td>
				<td bgcolor='#fff'>".$row['employeeName']."</td>
				<td bgcolor='#ccc' width='20%'><font color='000000'><b>Staff No </b></font></td>
				<td bgcolor='#fff'>".$row['Pmnt_Emp_Mst_Id']."</td>
				</tr>
				<tr>
				<td bgcolor='#ccc' width='20%'><font color='000000'><b>OPU</b></font></td>
				<td  bgcolor='#fff'>".$row['OPU']."</td>
				<td bgcolor='#ccc' width='20%'><font color='000000'><b>Skill Group</b></font></td>
				<td bgcolor='#fff'>&nbsp;</td>
				</tr>
				<tr>
				<td bgcolor='#ccc' width='20%'><font color='000000'><b>Division</b></font></td>
				<td bgcolor='#fff'>".$row['Division']."</td>
				<td bgcolor='#ccc' width='20%'><font color='000000'><b>Discipline</b></font></td>
				<td bgcolor='#fff'>".$row['Discipline']."</td>
				</tr>
				<tr>
				<td bgcolor='#ccc' width='20%'><font color='000000'><b>Department</b></font></td>
				<td bgcolor='#fff'>".$row['departmentName']."</td>
				<td bgcolor='#ccc' width='20%'><font color='000000'><b>Job Grade</b></font></td>
				<td bgcolor='#fff'>".$row['jobGrade']."</td>
				</tr>
				<tr>
				<td bgcolor='#ccc' width='20%'><font color='000000'><b>Position</b></font></td>
				<td bgcolor='#fff'>".$row['positionName']."</td>
				<td bgcolor='#ccc'><font color='000000'><b>Salary Grade</b></font></td>
				<td bgcolor='#fff'>".$row['salaryGrade']."</td>
				</tr>
				<tr>
				<td bgcolor='#ccc'  width='20%'><font color='000000'><b>Business Unit</b></font></td>
				<td bgcolor='#fff'>".$row['Division']."</td>
				<td bgcolor='#ccc' width='20%'><font color='000000'><b>Location</b></font></td>
				<td bgcolor='#fff'>".$row['locationName']."</td>
				</tr>
				</table>";
		return $output;
	}
	
	
	public function prepareNewIpc($employeeId,$pmsId) { 
		try {
			$this->transaction->beginTransaction();
			$posService = $this->service->get('positionService');
			$immSuperior = $posService->getImmediateSupervisorByEmployee($employeeId);
			$hod = $posService->getHodByEmployee($employeeId);
			$mstId = $this->addMainInfo($employeeId,$pmsId,$immSuperior,$hod);
			$isHaveSubordinates = $posService->isHaveSubordinatesByEmployee($employeeId); 
			$this->preparegenerikkpi($mstId,$isHaveSubordinates); 
			$this->transaction->commit();
			return $res;
		} catch(\Exception $e) {
			$this->transaction->rollBack();
			throw $e;
		} 
	} 
	
	public function addMainInfo($employeeId,$pmsId,$immSuperior,$hod) {
		
		$data = array(
			'Pms_Fyear_Id' => $pmsId,
			'Pmnt_Emp_Mst_Id' => $employeeId,
			'OPU' => "Oil Energy",
			'Division' => "Downstream", 
			'Immediate_Supervisor' => $immSuperior,
			'Emp_Edit' => 1,
			'HOD' => $hod,
		);
		
		return $this->pmsFormMapper->insertPmsMst($data);
	}
		
	
	public function preparegenerikkpi($mstId,$isHaveSubordinates) {
		$desc = "Personal development to improve performance and competencies. (Applicable to all staff with or without subordinates)";
		$base="Rating 3: Formal training - Majority of the plans executed / attended as agreed. Non-execution or non-attendance consented by Supervisor and plan amended.";
		$s2="Rating 2: Formal training - All plans executed / attended as agreed and some of the skills / knowledge acquired clearly demonstrated/ applied.";
		$s3 = "Rating 1: Formal training - All plans executed / attended ahead of agreed time-frame and skills / knowledge acquired clearly demonstrated/applied.";
		$data1 = array(
			'Pms_Info_Mst_Id' => $mstId,
			'Obj_Id'          => 21 ,
			'Obj_Desc'        => $desc ,
			'Obj_Weightage'   => 0,
			'Obj_PI'          => 'Development plan executed',
			'Obj_Base'        => $base ,
			'Obj_Stretch_02'  => $s2 ,
			'Obj_Stretch_01'  => $s3 
		);
		
		$this->pmsFormMapper->insertNewObjective($data1);  
		if($isHaveSubordinates) {
			$desc1 = 'PMS Development of people into highly motivated and 
					high performing workforce in line with the Group s people development strategy. 
					(Applicable to all staff with subordinates)';
			$pi = '1.Individual Performance Contract -Submission of Endorsed IPC Form 2.) 
					Mid Year Review -Submission of endorsed MYR form Developing People Result (LBVF)';
			$base1='100% submission by 15 July 08 100% Submission by Oct 08 - Average Score = 2.5 to 3.49';
			
			$data2 = array (
				'Pms_Info_Mst_Id'  => $mstId,
				'Obj_Id'           => '22',
				'Obj_Desc'         => $desc1,
				'Obj_Weightage'    => 0,
				'Obj_PI'           => $pi,
				'Obj_Base'         => $base1,
				'Obj_Stretch_02'   => 'Average Score = 1.5 to 2.49',
				'Obj_Stretch_01'   => 'Average Score = 1 to 1.49', 
			);
			$this->pmsFormMapper->insertNewObjective($data2); 
		}
	}
	
	// ______________MYR_______________ 
	public function getMyrPmsById($id,$isNonEx) {
		$formType = "MYR";
		$c= 1;
		$row = $this->pmsFormMapper->getPmsHeaderId($id);
		$output = $this->getHeader($row);
		$employeeId = $row['Pmnt_Emp_Mst_Id'];
		$output .= $this->getTotalWeightage($id);
		$output .= "<br/>
          <table width='1050px' border='1' font-size='6px' align='center' id='table1' width='100%'
	      bordercolor='#ccc' cellpadding = '6px'  style='border-collapse: collapse'> ";
		$dtls = $this->pmsFormMapper->getDtlsByMstId($id);
		foreach($dtls as $r) {
			$dtlsId = $r['id'];
			$objId = $r['Obj_Id'];
			if($objId != '21' && $objId != '22') { 
				$output .= $this->getFormDtlsMainMyr($r,$c,$isNonEx);
				$dtlsDtls = $this->pmsFormMapper->getDtlsDtlsByDtlsId($dtlsId);
				foreach($dtlsDtls as $subsub) {
					$output .= $this->getFormDtlsSubMyr($subsub,$formType,$isNonEx);
				}
				//$output .= $this->addSubObj($dtlsId,$formType);
			} else {
				$output .= $this->getFormDtlsMainWoEditDelMyr($r,$c,$isNonEx);
			}
			$c++;
		}
		$output .= "</table><br/>";
		/*if($id) {
			$output .= $this->addMainObj($id);
		}*/
		return $output;
	}
	
	public function getFormDtlsMainMyr($row,$c,$isNonEx) {
		$r = array();
		if($isNonEx) {
			$name = "Standard";
		} else {
			$name = "Base";
		}
		$output = "
		  
		    <tr bgcolor='#ccc' ".$formType." style ='font-weight:bold;'>
            <td width='9px' align='center' >&nbsp;</td>
            <td width='20px' align='center' >&nbsp;
            <td width='100px' align='center' <b>Objective</b></td>
            <td width='20px' align='center' <b>Wei in %</b></td>
            <td width='50px' align='center' <b>PI</b></td>
            <td width='100px' align='center' <b>".$name."</b></td> ";
		if(!$isNonEx) {
			$output .="<td width='50px' align='center' <b>Stretch 2</b></td>
                           <td width='50px' align='center' <b>Stretch 1</b></td>";
		}
		$output .="<td width='50px' align='center' <b>Result</b></td>
                   <td width='50px' align='center' <b>Gap</b></td>
				   <td width='50px' align='center' <b>Action Plan</b></td>
				";
	
		$output .="</tr>
	
            <tr >
            <td align='center' class='noBorder'>".$c."</td>
            <td align='left' >
            <p><b><a href='#' id = '".$row['id']."' class = 'editMyr'>Edit</a></b></p>
            <p><b>Main</b></p>
            </td>
            <td>".$row['Obj_Desc']."</td>
            <td>".$row['Obj_Weightage']."</td>
            <td>".$row['Obj_PI']."</td>
            <td>".$row['Obj_Base']."</td>";
		if(!$isNonEx) {
			$output .="<td>".$row['Obj_Stretch_02']."</td>
                            <td>".$row['Obj_Stretch_01']."</td>";
		}
		$output .="<td>".$row['Myr_Result']."</td>
                   <td>".$row['Myr_Gap']."</td>
                   <td>".$row['Myr_Action_Plan']."</td>
        ";
	
		$output .="</tr>
	
		    ";
		return $output;
	}
	
	public function getFormDtlsMainWoEditDelMyr($row,$c,$isNonEx) {
		$r = array();
		if($isNonEx) {
			$name = "Standard";
		} else {
			$name = "Base";
		}
		$output = "
	
		    <tr bgcolor='#ccc' ".$formType." style ='font-weight:bold;'>
            <td width='9px' align='center' >&nbsp;</td>
            <td width='20px' align='center' >&nbsp;
            <td width='100px' align='center' <b>_______Objective______</b></td>
            <td width='20px' align='center' <b>Wei in %</b></td>
            <td width='50px' align='center' <b>___PI____</b></td>
            <td width='100px' align='center' <b>_____".$name."____</b></td> ";
	
		if(!$isNonEx) {
			$output .="<td width='150px' align='center' <b>Stretch 2</b></td>
                           <td width='50px' align='center' <b>Stretch 1</b></td>";
		}
		$output .="<td width='50px' align='center' <b>_______Result______</b></td>
                   <td width='50px' align='center' <b>_______Gap_________</b></td>
				   <td width='50px' align='center' <b>____ActionPlan___</b></td>
				";
		$output .="</tr>
	
            <tr >
            <td align='center' class='noBorder'>".$c."</td>
            <td align='left' >
            <p><b>Main</b></p>
            </td>
            <td>".$row['Obj_Desc']."</td>
            <td>".$row['Obj_Weightage']."</td>
            <td>".$row['Obj_PI']."</td>
            <td>".$row['Obj_Base']."</td>";
		if(!$isNonEx) {
			$output .="<td>".$row['Obj_Stretch_02']."</td>
                            <td>".$row['Obj_Stretch_01']."</td>";
		}
		$output .="<td>".$row['Myr_Result']."</td>
                   <td>".$row['Myr_Gap']."</td>
                   <td>".$row['Myr_Action_Plan']."</td>
        ";
		$output .="</tr>
	
		    ";
		return $output;
	}
	
	public function getFormDtlsSubMyr($row,$formType,$isNonEx) {
		$r = array();
		$name = "";
		$output = "
            <tr ".$formType.">
	            <td align='center' class='noBorder'>".$i."</td>
	            <td align='left' >
	            <p><b><a href='#' id = '".$row['id']."' class = 'editMyrDtls'>Edit</a></b></p>
	            <p><b>Sub</b></p>
	            
	            </td>
	            <td>".$row['S_Obj_Desc']."</td>
	            <td>".$row['S_Obj_Weightage']."</td>
	            <td>".$row['S_Obj_PI']."</td>
	            <td>".$row['S_Obj_Base']."</td>";
		if(!$isNonEx) {
			$output .="<td>".$row['S_Obj_Stretch_02']."</td>
                            <td>".$row['S_Obj_Stretch_01']."</td>";
		}
		$output .="<td>".$row['Myr_Result']."</td>
                   <td>".$row['Myr_Gap']."</td>
                   <td>".$row['Myr_Action_Plan']."</td>
        ";
		$output .="<td>&nbsp;</td>
            </tr>";
		return $output; 
	}
	
	// ___________YEAR END______________
	public function getYendPmsById($id,$isNonEx) {
		$formType = "YEAR END";
		$c= 1;
		$row = $this->pmsFormMapper->getPmsHeaderId($id);
		$output = $this->getHeader($row);
		$employeeId = $row['Pmnt_Emp_Mst_Id'];
		$output .= $this->getTotalWeightage($id);
		$output .= "<br/>
          <table width='1050px' border='1' font-size='6px' align='center' id='table1' width='100%'
	      bordercolor='#ccc' cellpadding = '6px'  style='border-collapse: collapse'> ";
		$dtls = $this->pmsFormMapper->getDtlsByMstId($id);
		foreach($dtls as $r) {
			$dtlsId = $r['id'];
			$objId = $r['Obj_Id'];
			if($objId != '21' && $objId != '22') {
				$output .= $this->getFormDtlsMainYend($r,$c,$isNonEx);
				$dtlsDtls = $this->pmsFormMapper->getDtlsDtlsByDtlsId($dtlsId);
				foreach($dtlsDtls as $subsub) {
					$output .= $this->getFormDtlsSubYend($subsub,$formType,$isNonEx);
				}
				//$output .= $this->addSubObj($dtlsId,$formType);
			} else {
				$output .= $this->getFormDtlsMainWoEditDelYend($r,$c,$isNonEx);
			}
			$c++;
		}
		$output .= "</table><br/>";
		/*if($id) {
		 $output .= $this->addMainObj($id);
			}*/
		return $output;
	}
	
	public function getFormDtlsMainYend($row,$c,$isNonEx) {
		$r = array();
		if($isNonEx) {
			$name = "Standard";
		} else {
			$name = "Base";
		}
		$output = "
	
		    <tr bgcolor='#ccc' ".$formType." style ='font-weight:bold;'>
            <td width='9px' align='center' >&nbsp;</td>
            <td width='20px' align='center' >&nbsp;
            <td width='100px' align='center' <b>Objective</b></td>
            <td width='20px' align='center' <b>Wei in %</b></td>
            <td width='50px' align='center' <b>PI</b></td>
            <td width='100px' align='center' <b>".$name."</b></td> ";
		if(!$isNonEx) {
			$output .="<td width='50px' align='center' <b>Stretch 2</b></td>
                           <td width='50px' align='center' <b>Stretch 1</b></td>";
		}
		$output .="<td width='20px' align='center' <b>Rating</b></td>
				   <td width='50px' align='center' <b>Result</b></td>
                   <td width='50px' align='center' <b>Impact</b></td>
				   <td width='50px' align='center' <b>Challenges</b></td>
				   <td width='50px' align='center' <b>Effort</b></td>
				";
	
		$output .="</tr>
	
            <tr >
            <td align='center' class='noBorder'>".$c."</td>
            <td align='left' >
            <p><b><a href='#' id = '".$row['id']."' class = 'editYend'>Edit</a></b></p>
            <p><b>Main</b></p>
            </td>
            <td>".$row['Obj_Desc']."</td>
            <td>".$row['Obj_Weightage']."</td>
            <td>".$row['Obj_PI']."</td>
            <td>".$row['Obj_Base']."</td>";
		if(!$isNonEx) {
			$output .="<td>".$row['Obj_Stretch_02']."</td>
                            <td>".$row['Obj_Stretch_01']."</td>";
		}
		$output .="<td>".$row['Rating']."</td>
                   <td>".$row['Result']."</td>
                   <td>".$row['Impact']."</td>
                   <td>".$row['Challenges']."</td>
                   <td>".$row['Effort']."</td>
        ";
	
		$output .="</tr>
	
		    ";
		return $output;
	}
	
	public function getFormDtlsSubYend($row,$formType,$isNonEx) {
		$r = array();
		$name = "";
		$output = "
            <tr ".$formType.">
	            <td align='center' class='noBorder'>".$i."</td>
	            <td align='left' >
	            <p><b><a href='#' id = '".$row['id']."' class = 'editYendDtls'>Edit</a></b></p>
	            <p><b>Sub</b></p>
	      
	            </td>
	            <td>".$row['S_Obj_Desc']."</td>
	            <td>".$row['S_Obj_Weightage']."</td>
	            <td>".$row['S_Obj_PI']."</td>
	            <td>".$row['S_Obj_Base']."</td>";
		if(!$isNonEx) {
			$output .="<td>".$row['S_Obj_Stretch_02']."</td>
                            <td>".$row['S_Obj_Stretch_01']."</td>";
		}
		$output .="<td>".$row['Rating']."</td>
                   <td>".$row['Result']."</td>
                   <td>".$row['Impact']."</td>
                   <td>".$row['Challenges']."</td>
                   <td>".$row['Effort']."</td>
        "; 
		$output .="<td>&nbsp;</td>
            </tr>";
		return $output;
	}
	
	public function getFormDtlsMainWoEditDelYend($row,$c,$isNonEx) {
		$r = array();
		if($isNonEx) {
			$name = "Standard";
		} else {
			$name = "Base";
		}
		$output = "
	
		    <tr bgcolor='#ccc' ".$formType." style ='font-weight:bold;'>
            <td width='9px' align='center' >&nbsp;</td>
            <td width='20px' align='center' >&nbsp;
            <td width='100px' align='center' <b>_____Objective____</b></td>
            <td width='20px' align='center' <b>Wei in %</b></td>
            <td width='50px' align='center' <b>___PI___</b></td>
            <td width='100px' align='center' <b>__".$name."__</b></td> ";
	
		if(!$isNonEx) {
			$output .="<td width='150px' align='center' <b>Stretch 2</b></td>
                           <td width='50px' align='center' <b>Stretch 1</b></td>";
		}
		$output .="<td width='50px' align='center' <b>Rating</b></td>
				   <td width='50px' align='center' <b>_______Result______</b></td>
                   <td width='50px' align='center' <b>_______Impact______</b></td>
				   <td width='50px' align='center' <b>____Challenges___</b></td>
				   <td width='50px' align='center' <b>____Effort___</b></td>
				";
		$output .="</tr>
	
            <tr >
            <td align='center' class='noBorder'>".$c."</td>
            <td align='left' >
            <p><b>Main</b></p>
            </td>
            <td>".$row['Obj_Desc']."</td>
            <td>".$row['Obj_Weightage']."</td>
            <td>".$row['Obj_PI']."</td>
            <td>".$row['Obj_Base']."</td>";
		if(!$isNonEx) {
			$output .="<td>".$row['Obj_Stretch_02']."</td>
                            <td>".$row['Obj_Stretch_01']."</td>";
		}
		$output .="<td>".$row['Rating']."</td>
                   <td>".$row['Result']."</td>
                   <td>".$row['Impact']."</td>
                   <td>".$row['Challenges']."</td>
                   <td>".$row['Effort']."</td>
        "; 
		$output .="</tr>
	
		    ";
		return $output;
	} 
}   