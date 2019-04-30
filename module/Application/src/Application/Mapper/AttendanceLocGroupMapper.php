<?php

namespace Application\Mapper;

use Application\Abstraction\AbstractDataMapper;
use Application\Model\LocationGroup;
                
    class AttendanceLocGroupMapper extends AbstractDataMapper {
	
	protected $entityTable = "AttendanceLocationGroup";
    	
	protected function loadEntity(array $row) {
		 $entity = new LocationGroup(); 
		 return $this->arrayToEntity($row,$entity);
	}
	
	public function selectLocGroup() {
	    $sql = $this->getSql();
	    $select = $sql->select();
	    $select->from(array('e' => $this->entityTable))
	           ->columns(array('id'))
	           ->join(array('l' => 'Location'),'e.locationId = l.id',
	                  array('locationName'))
	           ->join(array('ag' => 'AttendanceGroup'),'e.attendanceGroupId = ag.id',
	                  array('groupName'))
	        //->where(array('employeeId' => $employeeId))
	    ;
	    return $select;
	}
}