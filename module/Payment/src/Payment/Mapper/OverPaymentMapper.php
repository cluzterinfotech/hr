<?php
namespace Payment\Mapper;

use Application\Abstraction\AbstractDataMapper; 
use Employee\Model\OverPaymentEntity;

class OverPaymentMapper extends AbstractDataMapper {
	
	protected $entityTable = "OverPayment"; 
	
	protected $mstTable = "OverPaymentMst";  
    	
	protected function loadEntity(array $row) {
		 $entity = new OverPaymentEntity(); 
		 return $this->arrayToEntity($row,$entity); 
	}
	
	public function selectOverPayment() {
		$sql = $this->getSql();
		$select = $sql->select();
		$select->from(array('m' => $this->mstTable))
		       ->columns(array('employeeId'))
		       ->join(array('d' => $this->entityTable),'m.id = d.mstId',
		              array('dueAmount','paidStatus','deductionDate'))
		       ->join(array('e' => 'EmpEmployeeInfoMain'),'m.employeeId = e.employeeNumber',
				      array('employeeName'))  
		;  
		//echo $select->getSqlString(); 
		//exit; 
		return $select;   
	}
	
	public function insertOverPaymentMst($mst) {
		$this->setEntityTable($this->mstTable);
		return $this->insert($mst); 
	}
	
	public function insertOverPaymentDtls($dtls) {
		$this->setEntityTable("OverPayment");
		$this->insert($dtls);
	}
	
}