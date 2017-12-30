<?php 
namespace Payment\Mapper;

use Application\Abstraction\AbstractDataMapper; 
use Employee\Model\CarAmortization;
use Zend\Db\Sql\Expression;

class CarAmortizationMapper extends AbstractDataMapper {
	
	protected $entityTable = "CarAmortization"; 
    	
	protected function loadEntity(array $row) {
		 $entity = new CarAmortization();  
		 return $this->arrayToEntity($row,$entity); 
	}
	
	public function selectCarAmortization() {
		$sql = $this->getSql(); 
		$select = $sql->select(); 
		$select->from(array('a' => $this->entityTable))
		       ->columns(array('id','paidAmount','numberOfMonths',
		       		'paidDate' => new Expression('CONVERT(varchar(12),paidDate,107)')
		       )) 
		       ->join(array('e' => 'EmpEmployeeInfoMain'),'a.employeeNumber = e.employeeNumber',
		              array('employeeName')) 
		;  
		//echo $select->getSqlString(); 
		//exit; 
		return $select;   
	}
	
}