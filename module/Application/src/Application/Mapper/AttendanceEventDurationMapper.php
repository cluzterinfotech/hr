<?php

namespace Application\Mapper;

use Application\Abstraction\AbstractDataMapper,  
    Zend\Db\Adapter\Adapter as zendAdapter,
    Application\Model\Bank;
use Application\Model\AttendanceEventDuration;
                
    class AttendanceEventDurationMapper extends AbstractDataMapper {
	
	protected $entityTable = "AttendanceEventDuration";
    	
	protected function loadEntity(array $row) {
		 $entity = new AttendanceEventDuration(); 
		 return $this->arrayToEntity($row,$entity);
	}
	
	public function selectEventDuration() {
	    $sql = $this->getSql();
	    $select = $sql->select();
	    $select->from(array('e' => $this->entityTable))
	           ->columns(array('id','eventId','startingDate','endingDate'))
	           ->join(array('ae' => 'AttendanceEvent'),
	               'e.eventId = ae.id',
	        array('eventName'))
	        //->where(array('employeeId' => $employeeId))
	    ;
	    return $select;
	}
}