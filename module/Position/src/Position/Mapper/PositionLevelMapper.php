<?php  
namespace Position\Mapper;

use Application\Model\PositionLevel,
    Application\Abstraction\AbstractDataMapper, 
    Application\Contract\EntityCollectionInterface, 
    Application\Contract\DataMapperInterface, 
    Zend\Db\Adapter\Adapter as zendAdapter;
use Zend\Db\Sql\Expression;
use Zend\Db\Sql\Predicate\Predicate; 

class PositionLevelMapper extends AbstractDataMapper {
	
	protected $entityTable = "PositionLevel";
    	
	protected function loadEntity(array $row) { 
		 $entity = new PositionLevel(); 
		 return $this->arrayToEntity($row,$entity); 
	} 
	
	
}