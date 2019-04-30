<?php

namespace Application\Contract;

use Application\Contract\EntityInterface;

interface DataMapperInterface {
	public function fetchById($id);
	public function fetchAll(array $conditions = array());
	public function insert($entity);
	public function update($entity);
	public function save($entity);
	public function delete($entity);
}

