<?php

namespace Application\Contract;

use Application\Contract\EntityInterface;

interface UnitOfWorkInterface {
	public function fetchById($id);
	public function registerNew(EntityInterface $entity);
	public function registerClean(EntityInterface $entity);
	public function registerDirty(EntityInterface $entity);
	public function registerDeleted(EntityInterface $entity);
	public function commit();
	public function rollback();
	public function clear();
}