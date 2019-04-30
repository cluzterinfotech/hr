<?php

namespace Application\Service;

use Zend\Db\Adapter\Adapter, 
    Position\Mapper\PositionMapper, 
    Position\Grid\PositionGrid, 
    Application\Contract\EntityInterface, 
    Application\Contract\EntityCollectionInterface, 
    Application\Mapper\SectionMapper;

class PositionService {
	protected $adapter;
	protected $collection;
	protected $positionMapper;
	protected $positionGrid;
	public function __construct(Adapter $adapter, EntityCollectionInterface $collection) {
		$this->adapter = $adapter;
		$this->collection = $collection;
	}
    
	protected function positionMapper() {
		if ($this->positionMapper === null) {
			$this->positionMapper = new PositionMapper 
			( $this->adapter, $this->collection, 
			new SectionMapper 
			( $this->adapter, $this->collection ) );
		}
		return $this->positionMapper;
	}
	protected function grid() {
		if ($this->positionGrid === null) {
			$this->positionGrid = new PositionGrid ();
		}
		return $this->positionGrid;
	}
	public function select() {
		try {
			$positionMapper = $this->positionMapper ();
			return $positionMapper->select ();
		} catch ( \Exception $e ) {
			echo $e->getMessage ();
		}
	}
	public function fetchById($id) {
		try {
			$positionMapper = $this->positionMapper ();
			return $positionMapper->fetchById ( $id );
		} catch ( \Exception $e ) {
			echo $e->getMessage ();
		}
	}
	public function fetchAll(array $condition = array()) {
		try {
			$positionMapper = $this->positionMapper ();
			return $positionMapper->fetchAll ( $condition );
		} catch ( \Exception $e ) {
			echo $e->getMessage ();
		}
	}
	public function fetchSectionId($arr) {
		$this->fetchAll ( array (
				'id' => '1' 
		) );
	}
	public function insert(EntityInterface $entity) {
		try {
			$positionMapper = $this->positionMapper ();
			return $positionMapper->insert ( $entity );
		} catch ( \Exception $e ) {
			echo $e->getMessage ();
		}
	}
	public function update(EntityInterface $entity) {
		try {
			$positionMapper = $this->positionMapper ();
			return $positionMapper->update ( $entity );
		} catch ( \Exception $e ) {
			echo $e->getMessage ();
		}
	}
	public function delete(EntityInterface $entity) {
		try {
			$positionMapper = $this->positionMapper ();
			return $positionMapper->delete ( $entity );
		} catch ( \Exception $e ) {
			echo $e->getMessage ();
		}
	}
	public function positionGrid($post) {
		$table = $this->grid ();
		$table->setAdapter ( $this->adapter )->setSource ( $this->select () )->setParamAdapter ( $post );
		return $table->render();
	}
}
