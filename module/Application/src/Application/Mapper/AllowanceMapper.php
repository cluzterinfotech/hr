<?php 
namespace Allowance\Model;

use Application\Abstraction\AbstractDataMapper; 
use Application\Entity\AllowanceEntity;

class AllowanceMapper extends AbstractDataMapper {
	
	protected $entityTable = "Allowance";
    
	protected function loadEntity(array $row) { 
	    $entity = new  AllowanceEntity();
	    return $this->arrayToEntity($row,$entity);
	}	
}