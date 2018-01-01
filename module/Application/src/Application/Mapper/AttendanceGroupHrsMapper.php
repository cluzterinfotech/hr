<?php

namespace Application\Mapper;

use Application\Abstraction\AbstractDataMapper;
use Application\Model\GroupWorkHours;

class AttendanceGroupHrsMapper extends AbstractDataMapper {
	
	protected $entityTable = "AttendanceLocationWorkingHrs"; 
    	
	protected function loadEntity(array $row) {
		 $entity = new GroupWorkHours(); 
		 return $this->arrayToEntity($row,$entity);
	}
	
	public function selectGroupHrs() {
	    $sql = $this->getSql();
	    $select = $sql->select();
	    $select->from(array('e' => $this->entityTable))
	           ->columns(array('id','DayName','Status','WorkingHours','startTime','endTime'))
	           ->join(array('a' => 'AttendanceDay'),'e.DayName = a.id',
	                  array('dayNameFull'))
	           ->join(array('ag' => 'AttendanceGroup'),'e.locationGroup = ag.id',
	                  array('groupName'))
	           ->join(array('et' => 'AttendanceEvent'),'e.eventId = et.id',
	                      array('eventName'))
	        //->where(array('employeeId' => $employeeId))
	    ;
	    //echo $select;
	    //exit; 
	    return $select;
	}
}