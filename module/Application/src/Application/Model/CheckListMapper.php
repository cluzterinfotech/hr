<?php
namespace Application\Model;

use Application\Abstraction\AbstractDataMapper;   
use Employee\Model\Location; 
use Payment\Model\Company;

class CheckListMapper extends AbstractDataMapper {
	
	protected $entityTable = "CheckListLog"; 
	
	protected $checkListCompany = "CheckListCompany"; 
    	
	protected function loadEntity(array $row) {
		 $entity = new Location(); 
		 return $this->arrayToEntity($row,$entity);
	}
    	
	public function checkListlog($data) {
		$sql = $this->getSql(); 
		$insert = $sql->Insert($this->entityTable);  
		$insert->values($data);
		$sqlString = $sql->getSqlStringForSqlObject($insert); 
		// echo $sqlString;
		// exit;
		$this->adapter->query($sqlString)->execute();	
	} 
	
	public function removeLog($data) { 
		
		$adapter = $this->adapter;
		$qi = function($name) use ($adapter) {
			return $adapter->platform->quoteIdentifier($name);
		};
		/*$fp = function($name) use ($adapter) {
			return $adapter->driver->formatParameterName($name);
		};*/ 
		$statement = $adapter->query("delete FROM " . $qi($this->entityTable) . " where
				id in (select top 1 id from " . $qi($this->entityTable) . " where 
				module      = '".$data['module']."' and
				controller  = '".$data['controller']."' and
				name        = 'save' and 
				companyId   = '".$data['companyId']."' )
				
		");  
		//echo $statement->getSql(); 
		//exit; 
		$results = $statement->execute(); 
	} 
	
	public function closeLog($data) { 
		$sql = $this->getSql();
		$delete = $sql->delete($this->entityTable);
		$delete->where(array(
				'module'        => $data['module'],
				'controller'    => $data['controller'],
				'name'          => 'save',
				'companyId'     => $data['companyId'],
		));
		$sqlString = $delete->getSqlString();
		//exit;
		$sqlString = $sql->getSqlStringForSqlObject($delete);
		return $this->adapter->query($sqlString)->execute()->count();
	}
	
	public function getMonthlyCheckList($controller,Company $company) {
		// return array(); 
		$sql = $this->getSql();
		$select = $sql->select();
		$select->from(array('e' => $this->checkListCompany))
		       ->columns(array('id','controller','relatedController'))
			   ->where(array('checkListType' => 'Monthly'))
			   ->where(array('company' => $company->getId()))
			   ->where(array('controller' => $controller))
		;      
		$sqlString = $sql->getSqlStringForSqlObject($select);
		//echo $sqlString;
		//exit;
		return $this->adapter->query($sqlString)->execute();
         	
	} 
	
	public function isHaveController($controller,Company $company) {
		$sql = $this->getSql(); 
		$select = $sql->select(); 
		$select->from(array('e' => $this->entityTable))
		       ->columns(array('id'))
		       ->where(array('controller' => $controller))
		       ->where(array('companyId' => $company->getId()))
		; 
		$sqlString = $sql->getSqlStringForSqlObject($select);
		//echo $sqlString; 
		//exit; 
		$row = $this->adapter->query($sqlString)->execute()->current(); 
		if($row['id']) { 
		    return 1; 	 
		} 
		return 0; 
	}
	
	/*public function isAllowedThisProcess($module,$controller) {
        
        
	}*/
	
	public function selectChecklist() {
		$sql = $this->getSql();
		$select = $sql->select();
		$select->from(array('e' => $this->checkListCompany))
		       ->columns(array('id','controller','relatedController'
                              ,'company','checkListType','process','relatedProcess'))
               ->join(array('c' => 'Company'),'c.id = e.company',
                      array('companyName'))
		;
		return $select; 
	}
	
	public function selectChecklistCurrent() {
		$sql = $this->getSql();
		$select = $sql->select();
		$select->from(array('e' => $this->entityTable))
		       ->columns(array('controller'))
               ->join(array('c' => 'Company'),'c.id = e.companyId',
                      array('companyName'))
               ->group(array('controller','companyName'))
		;
		return $select; 
	}

	
}