<?php

namespace Allowance\Mapper;

use Application\Model\Position, 
    Application\Abstraction\AbstractDataMapper, 
    Application\Contract\EntityCollectionInterface, 
    Application\Contract\DataMapperInterface, 
    Zend\Db\Adapter\Adapter as zendAdapter;
    
class AllowanceMapper //extends AbstractDataMapper 
{
	
	protected $entityTable = "Position";
	
	public function __construct(zendAdapter $adapter, EntityCollectionInterface $collection, $entityTable = null) {
		//parent::__construct($adapter, $collection, $entityTable );
	}
	
	public function getTestFunction() {
		return 'Test Function - Allowance Mapper';
	}
}