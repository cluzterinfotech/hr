<?php

namespace Application\Model;

use Application\Abstraction\AbstractEntity;

class Position extends AbstractEntity {
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
		if (isset ( $this->fields ["id"] )) {
			throw new \Exception ( "The ID for this user has been set already." );
		}
		if (! is_int ( $id ) || $id < 1) {
			throw new \Exception ( "The user ID is invalid." );
		}
		$this->fields ["id"] = $id;
		return $this;
	}
	public function setName($name) {
		if (strlen ( $name ) < 2 || strlen ( $name ) > 30) {
			throw new \Exception ( "The user name is invalid." );
		}
		$this->fields ["name"] = trim ( $name );
		return $this;
	}
    public function getId()
    {}

}