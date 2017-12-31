<?php
namespace Application\Mapper;

use Application\Abstraction\AbstractDataMapper; 
use Application\Model\RamadanAttendance;

class RamadanMapper extends AbstractDataMapper {
	
	protected $entityTable = "AttendanceRamadanException";
    	
	protected function loadEntity(array $row) {
		 $entity = new RamadanAttendance();   
		 return $this->arrayToEntity($row,$entity);
	}
}