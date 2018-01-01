<?php 

namespace Leave\Mapper; 

use Application\Abstraction\AbstractDataMapper; 
use Leave\Model\PublicHoliday;

class PublicHolidayMapper extends AbstractDataMapper {
	
	protected $entityTable = "PublicHoliday"; 
    	
	protected function loadEntity(array $row) { 
	    $entity = new PublicHoliday(); 
		return $this->arrayToEntity($row,$entity); 
	} 
   
	/*public function selectEntitlement() {
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
	}*/
}