<?php

namespace Application\Mapper;

use Application\Abstraction\AbstractDataMapper; 
use Application\Entity\CompanyEntity;
use Payment\Model\Company;
use Zend\Db\Sql\Expression;
use Payment\Model\CompanyPosition;

class CompanyMapper extends AbstractDataMapper {
	
	protected $entityTable = "Company";
	
	protected $companyPosition = "UserPositionCompany"; 
    
	protected function loadEntity(array $row) { 
	    $entity = new Company(); 
	    return $this->arrayToEntity($row,$entity);
	}
	
	public function getCompanyList() {
		$sql = $this->getSql();
		$select = $sql->select();
		$select->from(array('e' => $this->entityTable))
		       ->columns(array('id','companyName'))
		;
		$sqlString = $sql->getSqlStringForSqlObject($select);
		$results = $this->adapter->query($sqlString)->execute();
		return $this->toArrayList($results,'id','companyName');
	}
	
	public function selectCompanyUser() {
		$sql = $this->getSql();
		$select = $sql->select();
		$select->from(array('e' => 'UserPositionCompany'))
			   ->columns(array('id'))
			   ->join(array('p' => 'Position'),'p.id = e.positionId',
					  array('positionName' => new Expression("positionName + ' ' +shortDescription")))
			   ->join(array('g' => $this->entityTable), 'e.companyId = g.id',
					  array('companyName' ) )
		;
		//echo $select->getSqlString(); 
		//exit; 
		return $select; 
	} 
	
	public function fetchCompPositionById($id) {
		$this->setEntityTable($this->companyPosition); 
		$statement = $this->fetch(array(
				'id' => $id
		) );
		if (!$results = $statement->execute()->current()) {
			return null;
		}
		return $this->loadCompPosition($results);
	} 
	
	protected function loadCompPosition(array $row) {
		$entity = new CompanyPosition(); // AnnivInc();
		return $this->arrayToEntity($row,$entity); 
	}  
	
	public function insertCompPosition($entity) {
		$this->setEntityTable($this->companyPosition);
		return $this->insert($entity);
	}
	
	public function updateCompPosition($entity) { 
		//\Zend\Debug\Debug::dump($entity);
		//exit;
		$this->setEntityTable($this->companyPosition);
		$sql = $this->getSql();
		$update = $sql->Update($this->companyPosition);
		$array = $this->entityToArray($entity);
		$id = $array['id'];
		unset($array['id']);
		$update->set($array);
		$update->where(array(
				'id' => $id
		));
		$sqlString = $update->getSqlString();
		//echo $sqlString;
		//exit;
		$sqlString = $sql->getSqlStringForSqlObject($update);
		return $this->adapter->query($sqlString)->execute()->count();
		//return $this->update($entity);
		return $this->update($entity);
	} 
	
}
