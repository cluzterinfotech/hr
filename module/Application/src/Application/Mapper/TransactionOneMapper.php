<?php

namespace Application\Mapper;

use Application\Model\Position, 
    Application\Abstraction\AbstractDataMapper, 
    Application\Contract\EntityCollectionInterface, 
    Application\Contract\DataMapperInterface, 
    Zend\Db\Adapter\Adapter as zendAdapter;

class TransactionOneMapper extends AbstractDataMapper {
	
	protected $entityTable = "TransactionOne";
	
	protected function loadEntity(array $row) {
		return new Position(array(
				"id" => (int) trim($row["id"]),
				"name" => trim ($row["name"]),
				"level" => trim ( $row ["level"] ),
				"sequence" => trim ( $row ["sequence"] ),
				"section" => trim ( $row ["section"] ),
				"reportingPosition" => trim ( $row ["reportingPosition"] ),
				"status" => trim ( $row ["status"] ) 
		));
	}	
}