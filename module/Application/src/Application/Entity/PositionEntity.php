<?php

namespace Application\Entity;

use Application\Abstraction\AbstractEntity;

class PositionEntity extends AbstractEntity {
	
	protected $allowedFields = array (
			"id",
			"name",
			"level",
			"sequence",
			"section",
			"reportingPosition",
			"status" 
	);
	
	public function setId($id) {
		$this->fields["id"] = $id;
		return $this;
	}
	public function setName($name) {
		$this->fields["name"] = trim ( $name );
		return $this;
	}
	public function setLevel($level) {
		$this->fields["level"] = trim ( $level );
		return $this;
	}
    public function getId()
    {}

}
