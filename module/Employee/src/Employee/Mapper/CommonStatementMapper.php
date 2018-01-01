<?php
namespace Employee\Mapper;

use Application\Abstraction\AbstractDataMapper,  
    Zend\Db\Adapter\Adapter as zendAdapter,
    Employee\Model\SplHousing;
use Employee\Model\CommonStatement;

class CommonStatementMapper extends AbstractDataMapper {
	
	protected $entityTable = "CommonBankStatement";
    	
	protected function loadEntity(array $row) {
		 $entity = new CommonStatement();
		 return $this->arrayToEntity($row,$entity);
	}
	
	public function selectStmtList() {
	    
		$sql = $this->getSql(); 
		$select = $sql->select(); 
		$select->from(array('e' => $this->entityTable))
		       ->columns(array('*'))
		       ->join(array('b' => 'lkpBank'),'b.id = e.bankId',
		       		array('bankName'))
			   
		; 
		return $select; 
		//$sqlString = $sql->getSqlStringForSqlObject($select);
		// echo $sqlString;
		// exit;
		//return $this->adapter->query($sqlString)->execute(); 
		
	} 
	
}