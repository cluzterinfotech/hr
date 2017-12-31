<?php
namespace Payment\Mapper;

use Application\Abstraction\AbstractDataMapper,  
    Zend\Db\Adapter\Adapter as zendAdapter;
use Employee\Model\CarRentPositionGroup;
use Zend\Db\Sql\Predicate;
use Zend\Db\Sql\Predicate\Expression;
use Zend\Db\Sql\Ddl\Column\Varchar;
use Payment\Model\BonusCriteria;

class BonusCriteriaMapper extends AbstractDataMapper {
	
	protected $entityTable = "BonusCriteria";
    	
	protected function loadEntity(array $row) {
		 $entity = new BonusCriteria();  
		 return $this->arrayToEntity($row,$entity); 
	}
	
	
}