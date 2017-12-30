<?php

namespace Application\Model;

use Application\Abstraction\AbstractEntity;

class User extends AbstractEntity {
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
		$this->fields ["id"] = $id;
		return $this;
	}
	public function setName($name) {
		$this->fields ["name"] = trim ( $name );
		return $this;
	}
    public function getId()
    {}

}
