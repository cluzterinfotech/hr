<?php  
namespace Position\Mapper;

use Application\Model\EmployeeType,
    Application\Abstraction\AbstractDataMapper, 
    Application\Contract\EntityCollectionInterface, 
    Application\Contract\DataMapperInterface, 
    Zend\Db\Adapter\Adapter as zendAdapter;
use Zend\Db\Sql\Expression;
use Zend\Db\Sql\Predicate\Predicate; 

class EmployeeTypeMapper extends AbstractDataMapper {
	
	protected $entityTable = "lkpEmployeeType";
    	
	protected function loadEntity(array $row) { 
		 $entity = new EmployeeType(); 
		 return $this->arrayToEntity($row,$entity); 
	} 
	
}