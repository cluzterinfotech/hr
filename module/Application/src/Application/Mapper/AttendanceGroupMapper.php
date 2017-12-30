<?php

namespace Application\Mapper;

use Application\Abstraction\AbstractDataMapper;  
use Zend\Db\Adapter\Adapter as zendAdapter;
use Application\Model\AttendanceGroup;

class AttendanceGroupMapper extends AbstractDataMapper {
	
	protected $entityTable = "AttendanceGroup"; 
    	
	protected function loadEntity(array $row) {
		 $entity = new AttendanceGroup(); 
		 return $this->arrayToEntity($row,$entity);
	}
	
	/*public function selectGroupHrs() {
	    $sql = $this->getSql();
	    $select = $sql->select();
	    $select->from(array('e' => $this->entityTable))
	           ->columns(array('id','DayName','Status','WorkingHours','startTime','endTime'))
	           ->join(array('a' => 'AttendanceDay'),'e.DayName = a.id',
	                  array('dayNameFull'))
	           ->join(array('ag' => 'AttendanceGroup'),'e.locationGroup = ag.id',
	                  array('groupName'))
	        //->where(array('employeeId' => $employeeId))
	    ;
	    //echo $select;
	    //exit; 
	    return $select;
	}*/
}