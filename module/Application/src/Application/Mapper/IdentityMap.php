<?php

namespace Application\Mapper; 

use \SplObjectStorage, ArrayObject; 

class IdentityMap { 
	protected $idToObject; 
	protected $objectToId; 
	public function __construct() { 
		$this->objectToId = new SplObjectStorage ();
		$this->idToObject = new ArrayObject ();
	}
	
	public function set($id, $object) {
		$this->idToObject[$id] = $object;
		$this->objectToId[$object] = $id;
	}
	
	public function getId($object) {
		if (false === $this->hasObject($object)) {
			throw new \Exception('Id not found'); 
		}
		return $this->objectToId[$object];
	}
	
	public function hasId($id) {
		return isset ( $this->idToObject[$id]); 
	}
	
	public function hasObject($object) {
		return isset ( $this->objectToId[$object] );
	}
	
	public function getObject($id) {
		if (false === $this->hasId($id)) {
			throw new \Exception ( 'Id not found' );
		}
		return $this->idToObject [$id];
	}
}