<?php

namespace Application\Model;

use Application\Contract\DataMapperInterface, 
    Application\Storage\ObjectStorageInterface, 
    Application\Contract\EntityInterface, 
    Application\Contract\UnitOfWorkInterface;

class UnitOfWork implements UnitOfWorkInterface {
	const STATE_NEW = "NEW";
	const STATE_CLEAN = "CLEAN";
	const STATE_DIRTY = "DIRTY";
	const STATE_REMOVED = "REMOVED";
	protected $dataMapper;
	protected $storage;
	public function __construct(DataMapperInterface $dataMapper, ObjectStorageInterface $storage) {
		$this->dataMapper = $dataMapper;
		$this->storage = $storage;
	}
	public function getDataMapper() {
		return $this->dataMapper;
	}
	public function getObjectStorage() {
		return $this->storage;
	}
	public function fetchById($id) {
		$entity = $this->dataMapper->fetchById ( $id );
		$this->registerClean($entity);
		return $entity;
	}
	public function registerNew(EntityInterface $entity) {
		$this->registerEntity ( $entity, self::STATE_NEW );
		return $this;
	}
	public function registerClean(EntityInterface $entity) {
		$this->registerEntity ( $entity, self::STATE_CLEAN );
		return $this;
	}
	public function registerDirty(EntityInterface $entity) {
		$this->registerEntity ( $entity, self::STATE_DIRTY );
		return $this;
	}
	public function registerDeleted(EntityInterface $entity) {
		$this->registerEntity ( $entity, self::STATE_REMOVED );
		return $this;
	}
	protected function registerEntity($entity, $state = self::STATE_CLEAN) {
		$this->storage->attach ( $entity, $state );
	}
	public function commit() {
		foreach ( $this->storage as $entity ) {
			switch ($this->storage[$entity]) {
				case self::STATE_NEW :
				case self::STATE_DIRTY :
					$this->dataMapper->save($entity);
					break;
				case self::STATE_REMOVED :
					$this->dataMapper->delete($entity);
			}
		}
		$this->clear();
	}
	
	public function rollback() { }
	
	public function clear() {
		$this->storage->clear();
		return $this;
	}
}
