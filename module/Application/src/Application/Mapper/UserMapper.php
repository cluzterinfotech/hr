<?php

namespace Application\Mapper;

use Application\Model\User;
use Application\Abstraction\AbstractDataMapper;

class UserMapper extends AbstractDataMapper {
	protected $entityTable = "users";
	protected function loadEntity(array $row) {
		return new User ( array (
				"id" => $row ["id"],
				"name" => $row ["name"],
				"email" => $row ["email"],
				"role" => $row ["role"] 
		) );
	}
}
