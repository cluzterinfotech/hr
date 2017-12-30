<?php

namespace Application\Model;

use Payment\Model\EntityInterface;

class PositionLevel implements EntityInterface {
	
	private $id;
	private $levelName;
	private $levelSequence;
	
	public function setId($id) {
		$this->id = $id;
	}
	public function getId() {
		return $this->id;
	}
	public function setLevelName($levelName) {
		$this->levelName = $levelName;
	}
	public function getLevelName() {
		return $this->levelName;
	}
	public function setLevelSequence($levelSequence) {
		$this->levelSequence = $levelSequence;
	}
	public function getLevelSequence() {
		return $this->levelSequence;
	}
}