<?php 

namespace Pms\Model; 

use Pms\Mapper\PmsFormMapper;
//use Payment\Model\Company;
//use Payment\Model\DateRange; 
use Application\Persistence\TransactionDatabase;
//use Leave\Model\ApprovalService;
use Leave\Model\Approvals; 

class PmsFormService extends Approvals {
    
    //private $pmsFormMapper; 
    
   // private $service;
    	
	/*public function __construct(PmsFormMapper $pmsFormMapper,$sm) {
		$this->pmsFormMapper = $pmsFormMapper; 
		$this->service = $sm; 
		$this->transaction = 
		new TransactionDatabase($this->service->get('sqlServerAdapter'));
	} */
	
	public function isNonExecutive($employeeId) {
		//return 1; 
		$posService = $this->services->get('positionService');
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
	
	public function isIpcSubmitted($employeeId,$id) {
	    return $this->pmsFormMapper->isIpcSubmitted($employeeId,$id);
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
	
	 
	
	public function getIpcReport($id) {
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
	        } else {
	            $output .= $this->getFormDtlsMainWoEditDel($r,$c,$isNonEx);
	        }
	        $c++;
	    }
	    $output .= "</table><br/>"; 
	    return $output;
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
	
	public function selectStatus($employeeId) {
	    //return array(); 
	    return $this->pmsFormMapper->selectReport($employeeId); 
	} 
	
	public function selectAppList($employeeId) {
	    //return array();
	    return $this->pmsFormMapper->selectAppList($employeeId);
	}
	
	public function selectReport($employeeId) {
	    return $this->pmsFormMapper->selectReport($employeeId);  
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
	
	
	public function getFormDtlsMain($row,$c,$isNonEx,$disp = 'class = "noDisp"') {
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
            <p $disp><b><a href='#' id = '".$row['id']."' class = 'editIpc'>Edit</a></b></p>
            <p><b>Main</b></p>
            <p $disp><b><a href='#' id = '"."d".$row['id']."' class = 'deleteIpc'>Delete</a></b></p>
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
	
	public function getFormDtlsSub($row,$formType,$isNonEx,$disp = 'class = "noDisp"') {
		$r = array();
		$name = "";
		$output = " 
            <tr ".$formType.">
	            <td align='center' class='noBorder'>".$i."</td>
	            <td align='left' >
	            <p $disp><b><a href='#' id = '".$row['id']."' class = 'editIpcDtls'>Edit</a></b></p>
	            <p><b>Sub</b></p>
	            <p $disp><b><a href='#' id = '"."d".$row['id']."' class = 'deleteIpcDtls'>Delete</a></b></p>
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
			$this->databaseTransaction->beginTransaction();
			$posService = $this->services->get('positionService');
			$immSuperior = $posService->getImmediateSupervisorByEmployee($employeeId);
			$hod = $posService->getHodByEmployee($employeeId);
			$mstId = $this->addMainInfo($employeeId,$pmsId,$immSuperior,$hod);
			$isHaveSubordinates = $posService->isHaveSubordinatesByEmployee($employeeId); 
			$this->preparegenerikkpi($mstId,$isHaveSubordinates); 
			$this->databaseTransaction->commit();
			return $res;
		} catch(\Exception $e) {
		    $this->databaseTransaction->rollBack(); 
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
	
	public function getApprovalService() {
	    return $this->services->get('');     
	}
	
	
	public function getPmsStatus($empId) { 
	    $currentFyYear = date('Y');
	    $pmsId = $this->getPmsIdByYear($currentFyYear); 
	    $empName = $this->pmsFormMapper->getUserName($empId);   
	    $r = $this->pmsFormMapper->getPmsRowByYear($currentFyYear);
	    $output = "<table width='700px' border='0'cellspacing='0px' cellpadding='5px'>
					  <tr>
					  	<th><b>Employee Name</b></th>
					    <th><b>PMS Year</b></th>
					    <th><b>Status</b></th>
					  </tr>"; 	    
	    if ($r) {
	        $fyId = $r['id']; 
	        $fyYear = $r['Year']; 
	        $currActivity = $r['Curr_Activity']; 
	        $status = "";
	        $rEmp = $this->pmsFormMapper->getPmsRowByEmployee($empId,$pmsId); 
	        if ($r['Close_Year'] == 1) { 
	            $status = "PMS Closed";
	        } elseif ($r['Close_Year'] == 0) { 
	            $status = "PMS Open"; 
	            $openIpc = $r['IPC_Open_Close']; 
	            if ($openIpc == 1) { 
	                $status = "IPC Open";
	                if ($rEmp) {
	                    //echo"------->".$rEmp['Emp_Edit'];
	                    if ($rEmp['Emp_Edit'] == 1) {
	                        $status = "Your IPC to be Amend and Submit to your Immediate Supervisor";
	                    } elseif ($rEmp['Emp_Edit'] == 0) {
	                        if (($rEmp['Sup_Approval'] == 0)) {
	                            //$supName = "x";//$empModel->getEmpName($db, $rEmp['Immediate_Supervisor']);
	                            $status = "Your IPC is Waiting For Supervisor Approval";
	                        } elseif (($rEmp['Sup_Approval'] == 1) && ($rEmp['Hod_Approval'] == 0)) {
	                            //$hodName = "x";//$empModel->getEmpName($db, $rEmp['HOD']);
	                            $status = "Your IPC is Waiting For HOD Approval";
	                        } elseif (($rEmp['Sup_Approval'] == 1) && ($rEmp['Hod_Approval'] == 1)) {  
	                            $status = "Your IPC is Approved";
	                        }
	                    }
	                } elseif (!$rEmp) {
	                    $status = "You Didn't Add your IPC yet for current year";
	                }
	            } elseif ($openIpc == 0) {
	                $status = "IPC Closed";
	                if ($r['MYR_Open_Close'] == 1) {
	                    $status = "MYR Open";
	                    if ($rEmp) {
	                        if ($rEmp['Emp_Edit'] == 1) {
	                            $status = "Your MYR to be Amend and Submit to your Immediate Supervisor";
	                        } elseif ($rEmp['Emp_Edit'] == 0) { 
	                            if (($rEmp['M_Imm_Sup_App'] == 0)) {
	                                //$supName = "x";//$empModel->getEmpName($db, $rEmp['M_Imm_Sup_Id']);
	                                $status = "Your MYR is Witing For Supervisor Approval";
	                            } elseif (($rEmp['M_Imm_Sup_App'] == 1) && ($rEmp['M_Hod_App'] == 0)) { 
	                                //$hodName = "x";//$empModel->getEmpName($db, $rEmp['M_Hod_Id']);
	                                $status = "Your MYR is  Witing For HOD Approval";
	                            } elseif (($rEmp['M_Imm_Sup_App'] == 1) && ($rEmp['M_Hod_App'] == 1)) { 
	                                $status = "Your MYR is Approved";
	                            }
	                        }
	                    } elseif (!$rEmp) {
	                        $status = "You Didn't Add your IPC yet for current year";
	                    }
	                } elseif ($r['MYR_Open_Close'] == 0) {
	                    $status = "MYR is Closed";
	                    if ($r['YED_Open_Close'] == 1) {
	                        $status = "PPA Open";
	                        if ($rEmp) {
	                            if ($rEmp['Emp_Edit'] == 1) {   
	                                $status = "Your PPA to be Amend and Submit to your Immediate Supervisor";
	                            } elseif ($rEmp['Emp_Edit'] == 0) {
	                                if (($rEmp['Sup_Approval'] == 0)) {
	                                    //$supName = "x";//$empModel->getEmpName($db, $rEmp['Immediate_Supervisor']);   
	                                    $status = "Your PPA is Waiting For Supervisor Approval ";
	                                } elseif (($rEmp['Sup_Approval'] == 1) && ($rEmp['Hod_Approval'] == 0)) {
	                                    //$hodName = "x";//$empModel->getEmpName($db, $rEmp['Y_Hod_Id']);
	                                    $status = "Your PPA is Waiting For HOD Approval";
	                                } elseif (($rEmp['Sup_Approval'] == 1) && ($rEmp['Hod_Approval'] == 1)) {
	                                    $status = "Your PPA is Approved";
	                                }
	                            }
	                        } elseif (!$rEmp) {
	                            $status = "You Didn't Add your IPC yet for current year";
	                        }
	                    } elseif ($r['YED_Open_Close'] == 0) {
	                        $currActivity = $r['Curr_Activity'];
	                        if ($currActivity == 0) {
	                            $status = "Nothing Open Yet in Pms wait for HR Announcement";
	                        } elseif ($currActivity == 1 && $r['IPC_Open_Close'] == 0) {
	                            $status = "IPC In Progress but temporarily closed by admin ";
	                        } elseif ($currActivity == 2 && $r['MYR_Open_Close'] == 0) {
	                            $status = "MYR In Progress but temporarily closed by admin ";
	                        } elseif ($currActivity == 3) {
	                            $status = "Year End In Progress but temporarily closed by admin ";
	                        } elseif ($currActivity == 4) {
	                            $status = "Everything was Closed";
	                        }
	                    }
	                }
	            }
	        }   
	        $output .= "<tr>
                            <td>" . $empName . "</td>
                            <td>" . $fyYear . "</td>
                            <td><b>" . $status . "</b></td>
                        </tr>";
	    } else { 
	        $status = "PMS Not Available Yet for This Year";
	        $output .= "<tr>
                            <td>" . $empName . "</td>
                            <td>" . $currentFyYear . "</td>
                            <td><b>" . $status . "</b></td>
                        </tr>";
	    } 
	    return $output;
	}
	
	public function isIpcValid($userId) { 
	    $v = 0; 
	    $year = date('Y'); 
	    $pmsId = $this->pmsFormMapper->getPmsIdByYear($year); 
	    $pmsMstId = $this->pmsFormMapper->getPmsIdByEmployee($userId,$pmsId); 
	    $wei = $this->pmsFormMapper->getTotWeightage($pmsMstId); 
	    $resultDtls = $this->pmsFormMapper->getDtlsByMstId($pmsMstId);
	    $emptyField = array(); 
	    $myFieds = ""; 
	    foreach ($resultDtls as $dtls) { 
	        $name = '';
	        $dtlsId = $dtls['id'];
	        $dtlsDesc = $dtls['Obj_Desc'];
	        $dtlsWeig = $dtls['Obj_Weightage'];
	        $dtlsPi = $dtls['Obj_PI'];
	        $dtlsBase = $dtls['Obj_Base'];
	        $result = $dtls['Myr_Result'];
	        $resultDtlsDtls = $this->pmsFormMapper->getDtlsDtlsByDtlsId($dtlsId); 
	        if ($dtlsDesc == Null || $dtlsDesc == null) {
	            $v = 1; 
	            $name = $dtlsId . "mdesc"; 
	            $myFieds .= "Main Obj Description "; 
	        }//if 
	        if ($resultDtlsDtls) { 
	            $totalSubWeig = 0; 
	            $weigList = ''; 
	            foreach ($resultDtlsDtls as $dtlsdtls) { 
	                $ddtlsId = $dtlsdtls['id']; 
	                $ddtlsDesc = $dtlsdtls['S_Obj_Desc']; 
	                $ddtlsWeig = $dtlsdtls['S_Obj_Weightage'];  
	                $ddtlsPi = $dtlsdtls['S_Obj_PI']; 
	                $ddtlsBase = $dtlsdtls['S_Obj_Base']; 
	                $dtlsresult = $dtlsdtls['Myr_Result']; 
	                $totalSubWeig+=$ddtlsWeig;
	                if ($ddtlsWeig == null || $ddtlsWeig == Null) {
	                    $v = 1; 
	                    $myFieds .= ", objective weightage ";
	                }//if
	                if ($ddtlsPi == null || $ddtlsPi == Null) {
	                    $v = 1; 
	                    $myFieds .= ", performance indicator ";
	                }//if
	                if ($ddtlsBase == null || $ddtlsBase == Null) {
	                    $v = 1; 
	                    $myFieds .= ", base ";
	                }
	               // if ($dtlsresult == null || $dtlsresult == Null) {
	                    //$v = 1; 
	                    //$name = $ddtlsId . "result";
	                    //array_push($emptyField, $name);
	                   // $myFieds .= "result ,";
	                //}
	            }//foreach
	        }//if The Main objective have Sub-Objective no need to fill base / PI/Desc
	        elseif (!$resultDtlsDtls) {
	            if ($dtlsPi == null || $dtlsPi == Null || $dtlsPi == ' ') {
	                $v = 1; 
	                //$name = $dtlsId . "mperi";
	                array_push($emptyField, $name);
	                $myFieds .= ", performance indicator ";
	            }//if
	            //Zend_Debug::dump($dtlsBase);
	            if ($dtlsBase == null || $dtlsBase == Null || $dtlsBase == ' ') {
	                $v = 1; 
	                //$name = $dtlsId . "mbase";
	                array_push($emptyField, $name);
	                $myFieds .= ", base";
	            }
	            //if ($result == null || $result == Null || $result == ' ') {
	                //$v = 1; 
	                //$name = $dtlsId . "mresult";
	                //array_push($emptyField, $name);
	                //$myFieds .= "result ,";
	            //}
	        }
	    } 
	    if($wei != 100) {
	        $v = 1; 
	    }
	    if($v == 0) { 
	        $udt = array(
	           'id'           => $pmsMstId,
	           'Emp_Edit'     => 0,
	           'Sup_Approval' => 0,
	           'Hod_Approval' => 0,
	        ); 
	        $this->pmsFormMapper->update($udt); 
	        // Emp_Edit = 0
	        // submit to supervisor 
	    }
	    return array($v,$myFieds);
	}   
	
	
	public function approveIpc($data,$type = 1) { 
	    $isSupervisor = 0;
	    $isHod = 0; 
	    $id = $data->getId(); 
	    $approvalType = $data->getApprovalType();
	    $approver = $this->userInfoService->getEmployeeId();
	    $approval = $approvalType;  
	    $udt = array(); 
	    $udt['id'] = $id; 
	    $row = $this->pmsFormMapper->getPmsById($id); 
	    $employeeId = $row['Pmnt_Emp_Mst_Id']; 
	    $immSup = $this->positionService->getImmediateSupervisorByEmployee($employeeId); 
	    $hod = $this->positionService->getHodByEmployee($employeeId); 
	    if($immSup == $approver) {
	        $isSupervisor = 1;
	    } 
	    if($hod == $approver) {
	        $isHod = 1;
	    } 
	    if($row['Sup_Approval'] == 1 && $row['Hod_Approval'] == 1) {
	        return "Form Already Approved!"; 
	    } 
	    if(!$row) {
	        return "This form is not valid for approval!";
	    } 
	    if($approvalType == 1) {
	        if(($row['Sup_Approval'] == 0) && $isSupervisor) {
    	        $udt['Sup_Approval'] = 1; 
    	        $udt['Immediate_Supervisor']  = $approver; 
	        } else {
	            return "Not valid approver"; 
	        }
    	    if(($row['Hod_Approval'] == 0) && $isHod) {
    	        $udt['Hod_Approval'] = 1; 
    	        $udt['HOD']  = $approver; 
    	    } else {
    	        return "Not Valid Approver"; 
    	    }
	    } else {
	        $udt['Emp_Edit'] = 1;
	        $udt['Sup_Approval'] = 0; 
	        $udt['Hod_Approval'] = 0; 
	    } 
	    $this->pmsFormMapper->update($udt);         
	    return "approved successfully";   
	} 
	
	public function getIpcFormApprovalList($employeeId) { 
	    $ipcList = $this->pmsFormMapper->getIpcFormApprovalList();
	    if($ipcList) {
	        $totId = array();
	        //$i = 1;
	        foreach($ipcList as $lst) { 
	            $applicant = $lst['Pmnt_Emp_Mst_Id'];
	            $isImmSupApproved = $lst['Sup_Approval'];
	            $isHodApproved = $lst['Hod_Approval'];
	            $immSup = $this->positionService->getImmediateSupervisorByEmployee($applicant); 
	            $hod = $this->positionService->getHodByEmployee($applicant); 
	            if(($immSup == $employeeId) && ($isImmSupApproved == 0)) {
	                $totId[] = $lst['id'];
	            } elseif(($hod == $employeeId) && ($isHodApproved == 0 && $isImmSupApproved == 1)) {
	                $totId[] = $lst['id']; 
	            } 
	            //$isApprover = 1;//$this->checkIsApprover($applicant,$approver,$approvedLevel);
	            //if($isApprover) {
	                //$totId[] = $lst['id'];
	            //}
	            //$i++;
	        }
	        if(!$totId) {
	            $totId[] = 0; 
	        }
	    }
	    return $this->pmsFormMapper->getIpcAppFormSelect($totId); 
	} 
	
}   