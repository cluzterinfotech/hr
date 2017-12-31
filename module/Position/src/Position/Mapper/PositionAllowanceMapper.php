<?php 

namespace Position\Mapper; 

use Position\Model\Position,
    Application\Abstraction\AbstractDataMapper, 
    Application\Contract\EntityCollectionInterface, 
    Application\Contract\DataMapperInterface, 
    Zend\Db\Adapter\Adapter as zendAdapter;
use Zend\Db\Sql\Expression;
use Payment\Model\Company;
use Application\Entity\PositionAllowanceEntity;

class PositionAllowanceMapper extends AbstractDataMapper {
	
	protected $entityTable = "PositionAllowanceBufferNew"; 
    	
	protected function loadEntity(array $row) {
		 $entity = new Position();
		 return $this->arrayToEntity($row,$entity);
	}
	
	public function selectPositionAllowance() {
		$sql = $this->getSql();
		$select = $sql->select();
		$select->from(array('s' => 'PositionAllowance'))
		       ->columns(array('id'))
		       ->join(array('p' => 'position'),'s.positionId = p.id', 
		           array('positionName' => new Expression(" levelName+ ' ' +positionName")))
		           ->join(array('pl' => 'PositionLevel'),'pl.levelSequence = p.organisationLevel',
		               array('levelName'),'left')
			   ->join(array('c' => 'Company'), 'c.id = s.companyId',
					  array('companyName'))
			   ->join(array('a' => 'Allowance'), 'a.id = s.allowanceId',
					  array('allowanceName'))
		;
		 //echo $select->getSqlString(); 
		 //exit; 
		return $select; 
	} 
	
	public function selectPositionAllowanceHist() {
		$sql = $this->getSql();
		$select = $sql->select();
		$select->from(array('s' => 'PositionAllowanceBufferExisting'))
		       ->columns(array('id'))
		       ->join(array('p' => 'position'),'s.positionId = p.id', 
		           array('positionName' => new Expression(" levelName+ ' ' +positionName"))) 
			          ->join(array('pl' => 'PositionLevel'),'pl.levelSequence = p.organisationLevel',
			              array('levelName'),'left')
			   ->join(array('c' => 'Company'), 'c.id = s.companyId',
					  array('companyName'))
			   ->join(array('a' => 'Allowance'), 'a.id = s.allowanceId',
					  array('allowanceName'))
		;
		// echo $select->getSqlString(); 
		// exit; 
		return $select; 
	} 
	
	public function selectPositionAllowanceNew() {
		$sql = $this->getSql();
		$select = $sql->select();
		$select->from(array('s' => 'PositionAllowanceBufferNew'))
		       ->columns(array('id'))
		       ->join(array('p' => 'position'),'s.positionId = p.id',
		           array('positionName' => new Expression(" levelName+ ' ' +positionName")))
				      ->join(array('pl' => 'PositionLevel'),'pl.levelSequence = p.organisationLevel',
				          array('levelName'),'left')
			   ->join(array('c' => 'Company'), 'c.id = s.companyId',
					  array('companyName'))
			   ->join(array('a' => 'Allowance'), 'a.id = s.allowanceId',
					  array('allowanceName'))
		;
        // echo $select->getSqlString();
		// exit;
	    return $select; 
	} 
	
	public function removePositionAllowanceBuffer($id) {
		$sql = $this->getSql();
		$delete = $sql->delete($this->entityTable);
		$delete->where(array(
				'id' => $id
		));
		//$sqlString = $delete->getSqlString();
		$sqlString = $sql->getSqlStringForSqlObject($delete);
		return $this->adapter->query($sqlString)->execute()->count();
	}
	
	public function removePositionAllowanceMain($position) {
		$sql = $this->getSql();
		$delete = $sql->delete('PositionAllowance');
		//$positionId = $position['positionId'];
		//$allowanceId = $position['allowanceId'];
		//$companyId = $position['companyId'];
		$delete->where(array(
				'positionId'   => $position['positionId'],
				'allowanceId'  => $position['allowanceId'],
				'companyId'    => $position['companyId']
		)); 
		//$sqlString = $delete->getSqlString(); 
		$sqlString = $sql->getSqlStringForSqlObject($delete); 
		return $this->adapter->query($sqlString)->execute()->count(); 
	}
	 
	public function selectPositionAllowanceById($id) { 
		$entity = new PositionAllowanceEntity(); 
		$this->setEntityTable('PositionAllowance');   
		$statement = $this->fetch(array('id' => $id)); 
		//\Zend\Debug\Debug::dump($statement);  
		
		if (!$results = $statement->execute()->current()) { 
			return null;
		}
		//\Zend\Debug\Debug::dump($statement);
		//exit; 
		$entity->setId($results['id']);
		$entity->setPositionAllowanceName($results['allowanceId']);
		$entity->setPositionName($results['positionId']);
		//$entity->setCompanyId($results['id']); 
		
		return $entity;  
	}
	
	public function savePositionAllowanceBuffer($positionAllowanceInfo) {
		$sql = $this->getSql();
		$insert = $sql->Insert($this->entityTable);
		$insert->values($positionAllowanceInfo);
		$sqlString = $sql->getSqlStringForSqlObject($insert);
		$this->adapter->query($sqlString)->execute();
	}
	
	public function getNewPositionAllowanceBufferList(Company $company) { 
		$sql = $this->getSql();
		$select = $sql->select();
		$select->from(array('e' => 'PositionAllowanceBufferNew'))
		       ->columns(array('id','positionId','allowanceId','companyId','isUpdate'))
		       ->where(array('companyId' => $company->getId()))
		; 
		$sqlString = $sql->getSqlStringForSqlObject($select);
		// echo $sqlString;
		// exit;
		return $this->adapter->query($sqlString)->execute();
	}
	
	public function savePositionAllowanceMain($positionAllowanceInfo) {
		$sql = $this->getSql();
		$insert = $sql->Insert('PositionAllowance'); 
		$insert->values($positionAllowanceInfo); 
		$sqlString = $sql->getSqlStringForSqlObject($insert); 
		// echo $sqlString;
		// exit;
		$this->adapter->query($sqlString)->execute();  
	}
	
	public function getPositionAllowanceList($positionId,$company) { 
		$sql = $this->getSql();
		$select = $sql->select();
		$select->from(array('e' => 'PositionAllowance'))
		       ->columns(array('id','allowanceId',
				               'companyId','positionId'))
			   ->where(array('companyId' => $company->getId()))
			   ->where(array('positionId' => $positionId))
		; 
		$sqlString = $sql->getSqlStringForSqlObject($select);
		// echo $sqlString; 
		// exit; 
		return $this->adapter->query($sqlString)->execute(); 
	} 
     
}