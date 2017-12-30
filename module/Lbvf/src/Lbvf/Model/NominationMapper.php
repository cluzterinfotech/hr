<?php
namespace Lbvf\Model;

use Application\Abstraction\AbstractDataMapper;
use Lbvf\Model\Nomination; 


class NominationMapper extends AbstractDataMapper {
	
	protected $entityTable = "LbvfNominationForm";
    	
	protected function loadEntity(array $row) {
		 $entity = new Nomination(); 
		 return $this->arrayToEntity($row,$entity);
	}
	
	public function selectById($empId) {
		$sql = $this->getSql();
		$select = $sql->select();
		$select->from(array('e' => $this->entityTable))
		       ->columns(array('*'))
		       ->join(array('l' => 'LbvfInfo'),'l.id = e.LbvfId', 
		       		array('LbvfName')) 
			   ->where(array('employeeNumber' => $empId))
				//->where(array('locationId' => $locationId))
		;
		return $select; 
	} 
	
	//->join(array('ep' => 'EmpPersonalInfo'),'ep.id = e.empPersonalInfoId',
			//array('employeeName')) 
}