<?php 
namespace Leave\Mapper; 

use Application\Abstraction\AbstractDataMapper, 
    Leave\Model\LeaveFormEntity;
use Zend\Db\Sql\Expression;
use Zend\Db\Sql\Predicate\Predicate;

class ApprovalLevelMapper extends AbstractDataMapper {
	
	protected $entityTable = "LeaveApprovalLevel";
    	
	protected function loadEntity(array $row) { 
	    $entity = new LeaveFormEntity(); 
		return $this->arrayToEntity($row,$entity); 
	}
	
	public function getLeaveLevelList() { 
	}
	
	public function getLeaveLevelRow($approvedLevel) {
		$sql = $this->getSql();
		$select = $sql->select();
		$select->from(array('l' => 'LeaveApprovalLevel'))
		       ->columns(array('id','ApprovalLevelName','ApprovalSequence'))
		       //->join(array('p' => 'Position'),'p.id = pe.positionId',
				      //array('organisationLevel'))
			   ->where(array('id' => $approvedLevel))
		; 
		$sqlString = $sql->getSqlStringForSqlObject($select);
		$results = $this->adapter->query($sqlString)->execute()->current();
		return $results; 
	} 
	
	public function getTravelLocalLevelRow($approvedLevel) {  
		$sql = $this->getSql();
		$select = $sql->select();
		$select->from(array('l' => 'TravelApprovalLevel'))
		       ->columns(array('id','ApprovalLevelName','ApprovalSequence'))
		     //->join(array('p' => 'Position'),'p.id = pe.positionId',
		            //array('organisationLevel'))
		       ->where(array('id' => $approvedLevel))
		; 
		$sqlString = $sql->getSqlStringForSqlObject($select);
		$results = $this->adapter->query($sqlString)->execute()->current();
		return $results; 
	}     
    
	public function getTravelAbroadLevelRow($approvedLevel) {
		$sql = $this->getSql();
		$select = $sql->select();
		$select->from(array('l' => 'TravelAbroadApprovalLevel'))
		       ->columns(array('id','ApprovalLevelName','ApprovalSequence'))
		     //->join(array('p' => 'Position'),'p.id = pe.positionId',
		            //array('organisationLevel'))
		       ->where(array('id' => $approvedLevel))
		;      
		$sqlString = $sql->getSqlStringForSqlObject($select);
		$results = $this->adapter->query($sqlString)->execute()->current();
		return $results;
	}
	
	public function getOvertimeLevelRow($approvedLevel) {
		$sql = $this->getSql();
		$select = $sql->select();
		$select->from(array('l' => 'OvertimeApprovalLevel'))
		       ->columns(array('id','ApprovalLevelName','ApprovalSequence'))
		     //->join(array('p' => 'Position'),'p.id = pe.positionId',
		      //array('organisationLevel'))
		       ->where(array('id' => $approvedLevel))
		;
		$sqlString = $sql->getSqlStringForSqlObject($select);
		//echo $sqlString;
		//exit; 
		$results = $this->adapter->query($sqlString)->execute()->current();
		return $results;
	}
	
	public function getTravelLocalLevelList() {
		
	}
	
}