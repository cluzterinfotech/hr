<?php 

namespace Leave\Mapper; 

use Application\Abstraction\AbstractDataMapper;
use Leave\Model\LeaveFormEntity;
use Zend\Db\Sql\Expression;
use Zend\Db\Sql\Predicate\Predicate;
use Leave\Model\AnnualLeaveEntitlement; 

class LeaveEntitlementMapper extends AbstractDataMapper {
	
	protected $entityTable = "LeaveEntitlement"; 
    	
	protected function loadEntity(array $row) { 
	    $entity = new AnnualLeaveEntitlement(); 
		return $this->arrayToEntity($row,$entity); 
	} 
   
	public function selectEntitlement() {
		$sql = $this->getSql();
		$select = $sql->select();
		$select->from(array('e' => $this->entityTable))
		       ->columns(array('id','yearsOfService','numberOfDays'))
		       ->join(array('c' => 'Company'),'c.id = e.companyId',
				      array('companyName'))
	           ->order('yearsOfService asc')
		;
	    // echo $sql->getSqlStringForSqlObject($select);
		// exit;
		return $select;
	}
}