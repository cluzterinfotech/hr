<?php
      
namespace Application\Model;

use Payment\Model\EntityInterface;

class FamilyMemberType implements EntityInterface {
	
	private $id;
	private $memberTypeName;
	
	public function setId($id) {
		$this->id = $id;
	}
	public function getId() {
		return $this->id;
	}
	public function setMemberTypeName($memberTypeName) {
		$this->memberTypeName = $memberTypeName;
	}
	public function getMemberTypeName() {
		return $this->memberTypeName;
	} 	
}