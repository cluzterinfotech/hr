<?php

namespace Application\Mapper;

use Application\Model\PositionTest,
    Application\Abstraction\AbstractDataMapper, 
    Application\Contract\EntityCollectionInterface, 
    Application\Contract\DataMapperInterface, 
    Zend\Db\Adapter\Adapter as zendAdapter;
use Application\Entity\CompanyAllowanceEntity;
use Allowance\Model\AllowanceMapper;
use Application\Entity\AllowanceTypeEntity;

class AllowanceTypeMapper extends AbstractDataMapper {
	
	protected $entityTable = "AllowanceType";
	
	protected $allowanceMapper;
	
	public function __construct(zendAdapter $adapter, 
			EntityCollectionInterface $collection,$sm
			//,AllowanceMapper $allowanceMapper 
			,$entityTable = null) {
		$this->allowanceMapper = new AllowanceMapper($adapter, $collection,$sm);
		parent::__construct($adapter,$collection,$entityTable);
	}
	
	protected function loadEntity(array $row) {
		//var_dump($row);
		//exit;
	    $entity = new AllowanceTypeEntity();
	    $entity->setId($row['id']);
	    $entity->setAllowanceId($this->allowanceMapper->fetchById($row['allowanceId']));
	    $entity->setAllowanceType($row['allowanceType']);
	    return $entity;
	}
	
}
