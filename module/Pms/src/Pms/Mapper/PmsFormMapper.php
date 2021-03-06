<?php

namespace Pms\Mapper;

use Pms\Model\Manage, 
Application\Abstraction\AbstractDataMapper, 
Application\Contract\EntityCollectionInterface, 
Application\Contract\DataMapperInterface, 
Zend\Db\Adapter\Adapter as zendAdapter;
use Zend\Db\Sql\Expression;
use Zend\Db\Sql\Predicate\Predicate;

class PmsFormMapper extends AbstractDataMapper {
	
	protected $entityTable = "Pms_Info_Mst";
	
	protected $dtlsTable = "Pms_Info_Dtls";
	
	protected $dtlsDtlsTable = "Pms_Info_Dtls_Dtls";
	
	protected $pmsFyear = "Pms_Fyear";
	
	protected function loadEntity(array $row) {
		$entity = new Manage();
		return $this->arrayToEntity ( $row, $entity );
	}
	
	public function insertNewObjective($data) {
		$this->setEntityTable($this->dtlsTable); 
		return $this->insert($data);  
	}
	
	public function insertNewSubObjective($data) {
		$this->setEntityTable($this->dtlsDtlsTable);
		return $this->insert($data);
	}
	
	public function insertPmsMst($data) {
		$this->setEntityTable($this->entityTable); 
		return $this->insert($data);
	}
	
	public function updateObjective($data) {
		$this->setEntityTable($this->dtlsTable);
		return $this->update($data);
	}
	
	public function updateSubObjective($data) {
		$this->setEntityTable($this->dtlsDtlsTable);
		return $this->update($data);
	}
	
	public function deleteObjective($data) {
		$this->setEntityTable($this->dtlsTable);
		return $this->delete($data);
	}
	
	public function deleteSubObjective($data) {
		$this->setEntityTable($this->dtlsDtlsTable);
		return $this->delete($data);
	}
	
	// main master row 
	public function getPmsById($id) {
		$sql = $this->getSql();
		$select = $sql->select();
		$select->from(array('e' => $this->entityTable))
		       ->columns(array ('*'))
		       ->where(array('id' => $id ));
		$sqlString = $sql->getSqlStringForSqlObject($select);
		$results = $this->adapter->query($sqlString)->execute()->current();
		if($results) {
		    return $results; 	
		}
		return array(); 
	}
	
	public function getPmsHeaderId($id) {
		$sql = $this->getSql();
		$select = $sql->select();
		$select->from(array('et' => $this->entityTable))
		       ->columns(array ('*'))
		       ->join(array('e' => 'EmpEmployeeInfoMain'),'e.employeeNumber = et.Pmnt_Emp_Mst_Id',
		              array('id','employeeNumber','empLocation','employeeName'))
		       ->join(array('l' => 'Location'),'l.id = e.empLocation',
		       		  array('locationName'),'left')
		       ->join(array('p' => 'Position'),'P.id = e.empPosition',
		       		  array('positionName' =>
		       		new Expression("positionName + ' ' +shortDescription"))
		       	     ,'left')
		       ->join(array('se' => 'section'),'se.id = p.section',
		       		  array('sectionName'),'left')
		       ->join(array('d' => 'Department'),'d.id = se.department',
		       	      array('departmentName'),'left')
		       ->join(array('s' => 'lkpSalaryGrade'),'s.id = e.empSalaryGrade',
		       		  array('salaryGrade'),'left')
		       ->join(array('j' => 'lkpJobGrade'),'j.id = e.empJobGrade',
		        	  array('jobGrade'),'left')
		       ->where(array('et.id' => $id ));
		$sqlString = $sql->getSqlStringForSqlObject($select);
		//echo $sqlString;
		//exit; 
		$results = $this->adapter->query($sqlString)->execute()->current();
		if($results) {
			return $results;
		}
		return array();
	}
	
	public function isIpcOpened($pmsId) {
	return true; 
		$sql = $this->getSql();
		$select = $sql->select();
		$select->from(array('e' => $this->pmsFyear))
		       ->columns(array ('IPC_Open_Close'))
		       ->where(array('id' => $pmsId ));
		$sqlString = $sql->getSqlStringForSqlObject($select);
		//echo $sqlString;
		//exit; 
		$results = $this->adapter->query($sqlString)->execute()->current();
		if($results['IPC_Open_Close'] == 1) {
			return true;
		}
		return false; 
	}
	
	public function isMyrOpened($pmsId) {
		return true;
		$sql = $this->getSql();
		$select = $sql->select();
		$select->from(array('e' => $this->pmsFyear))
		       ->columns(array ('MYR_Open_Close'))
		       ->where(array('id' => $pmsId ));
		$sqlString = $sql->getSqlStringForSqlObject($select);
		//echo $sqlString;
		//exit; 
		$results = $this->adapter->query($sqlString)->execute()->current();
		if($results['MYR_Open_Close'] == 1) {
			return true;
		}
		return false; 
	}
    
	public function isYendOpened($pmsId) {
		return true;
		$sql = $this->getSql();
		$select = $sql->select();
		$select->from(array('e' => $this->pmsFyear))
		       ->columns(array ('YED_Open_Close'))
		       ->where(array('id' => $pmsId ));
		$sqlString = $sql->getSqlStringForSqlObject($select);
		//echo $sqlString;
		//exit;
		$results = $this->adapter->query($sqlString)->execute()->current();
		if($results['YED_Open_Close'] == 1) {
			return true;
		}
		return false;
	}
	
	public function getObjectiveIdBySubId($subObjId) {
		$sql = $this->getSql();
		$select = $sql->select();
		$select->from(array('e' => $this->dtlsDtlsTable))
		       ->columns(array ('Pms_Info_Dtls_id'))
		       ->where(array('id' => $subObjId ));
		$sqlString = $sql->getSqlStringForSqlObject($select);
		$results = $this->adapter->query($sqlString)->execute()->current();
		if($results['Pms_Info_Dtls_id']) {
			return $results['Pms_Info_Dtls_id'];
		}
		return 0;
	}
	
	// main Objective row 
	public function getDtlsByMstId($mstId) {
		$sql = $this->getSql();
		$select = $sql->select();
		$select->from(array('e' => $this->dtlsTable))
		       ->columns(array ('*'))
		       ->where(array('Pms_Info_Mst_Id' => $mstId ));
		$sqlString = $sql->getSqlStringForSqlObject($select);
		$results = $this->adapter->query($sqlString)->execute();
		if($results) {
			return $results;
		}
		return array();
	}
	
	public function getDtlsById($id) {
		$sql = $this->getSql();
		$select = $sql->select();
		$select->from(array('e' => $this->dtlsTable))
		       ->columns(array ('*'))
		       ->where(array('id' => $id ));
		$sqlString = $sql->getSqlStringForSqlObject($select);
		$results = $this->adapter->query($sqlString)->execute()->current();
		if($results) {
			return $results;
		}
		return array();
	}
	
	public function getTotWeightage($id) {
		$sql = $this->getSql();
		$select = $sql->select();
		$select->from(array('e' => $this->dtlsTable))
		       ->columns(array ('totWeight' => new Expression('SUM(Obj_Weightage)')))
		       ->where(array('Pms_Info_Mst_Id' => $id ))
		       //->group('Pms_Info_Mst_Id')    
		;
		$sqlString = $sql->getSqlStringForSqlObject($select);
		//echo $sqlString;
		//exit; 
		$results = $this->adapter->query($sqlString)->execute()->current();
		if($results['totWeight']) {
			return $results['totWeight'];
		}
		return 0;
	}
	
	public function getDtlsDtlsById($id) {
		$sql = $this->getSql();
		$select = $sql->select();
		$select->from(array('e' => $this->dtlsDtlsTable))
		       ->columns(array ('*'))
		       ->where(array('id' => $id ));
		$sqlString = $sql->getSqlStringForSqlObject($select);
		$results = $this->adapter->query($sqlString)->execute()->current();
		if($results) {
			return $results;
		}
		return array();
	}
	
	// Sub-objective row
	public function getDtlsDtlsByDtlsId($dtlsId) {
		$sql = $this->getSql();
		$select = $sql->select();
		$select->from(array('e' => $this->dtlsDtlsTable))
		       ->columns(array ('*'))
		       ->where(array('Pms_Info_Dtls_id' => $dtlsId ));
		$sqlString = $sql->getSqlStringForSqlObject($select);
		$results = $this->adapter->query($sqlString)->execute();
		if($results) {
			return $results;
		}
		return array();
	}
	
	public function getPmsIdByYear($year) {
		$sql = $this->getSql();
		$select = $sql->select();
		$select->from(array('e' => 'Pms_Fyear'))
		       ->columns(array ('id'))
		       ->where(array('Year' => $year ));
		$sqlString = $sql->getSqlStringForSqlObject($select);
		$results = $this->adapter->query($sqlString)->execute()->current();
		if($results['id']) {
			return $results['id'];
		}
		return 0;
	}
	
	public function getPmsIdByEmployee($employeeId,$pmsId) {
		$this->setEntityTable($this->entityTable);  
		$sql = $this->getSql();
		$select = $sql->select();
		$select->from(array('e' => $this->entityTable))
		       ->columns(array ('id'))
		       ->where(array('Pmnt_Emp_Mst_Id' => $employeeId ))
		       ->where(array('Pms_Fyear_Id' => $pmsId ))
		;
		$sqlString = $sql->getSqlStringForSqlObject($select);
		$results = $this->adapter->query($sqlString)->execute()->current();
		if($results['id']) {
			return $results['id'];
		}
		return 0;
	} 
	
}